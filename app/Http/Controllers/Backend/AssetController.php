<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AssetController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreAsset;
use App\Http\Requests\Backend\UpdateAsset;
use App\Models\Asset;
use App\Models\Sort\Backend\AssetSort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AssetController extends Controller
{
    
    public function index(Request $request)
    {
        $sort = new AssetSort($request);

        $search = $request->query('search');

        $assets = Asset::when($search, function ($query, $search) {
                return $query
                    ->whereRaw('LOWER(symbol) LIKE ?', [$search.'%'])
                    ->orWhereRaw('LOWER(name) LIKE ?', ['%'.$search.'%']);
            })
            ->orderBy($sort->getSortColumn(), $sort->getOrder())
            ->paginate($this->rowsPerPage);

        return view('pages.backend.assets.index', [
            'assets'    => $assets,
            'sort'      => $sort->getSort(),
            'order'     => $sort->getOrder(),
            'search'    => $search,
        ]);
    }

    
    public function create()
    {
        return view('pages.backend.assets.create');
    }

    
    public function store(StoreAsset $request)
    {
        $asset              = new Asset();
        $asset->symbol      = $request->symbol;
        $asset->external_id = $request->external_id;
        $asset->name        = $request->name;
        $asset->price       = $request->price;
        $asset->change_abs  = $request->change_abs;
        $asset->change_pct  = $request->change_pct;
        $asset->volume      = $request->volume;
        $asset->supply      = $request->supply;
        $asset->market_cap  = $request->market_cap;
        $asset->status      = Asset::STATUS_ACTIVE;

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageFileName = time() . '-' . $request->symbol . '.' . $image->getClientOriginalExtension();
            $imageContents = (string) Image::make($image)
                ->resize(null, config('settings.asset_logo_thumb_height'), function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode();

            
            if (Storage::put('assets/' . $imageFileName, $imageContents)) {
                
                $asset->logo = $imageFileName;
            }
        }

        $asset->save();

        return redirect()
            ->route('backend.assets.index')
            ->with('success', __('app.asset_saved', ['name' => $asset->name]));
    }

    
    public function show($id)
    {
        
    }

    
    public function edit(Asset $asset)
    {
        return view('pages.backend.assets.edit', [
            'asset' => $asset
        ]);
    }

    
    public function update(UpdateAsset $request, Asset $asset)
    {
        $asset->symbol      = $request->symbol;
        $asset->external_id = $request->external_id;
        $asset->name        = $request->name;
        $asset->price       = $request->price;
        $asset->change_abs  = $request->change_abs;
        $asset->change_pct  = $request->change_pct;
        $asset->volume      = $request->volume;
        $asset->supply      = $request->supply;
        $asset->market_cap  = $request->market_cap;
        $asset->status      = $request->status;

        
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageFileName = time() . '-' . $request->symbol . '.' . $image->getClientOriginalExtension();
            $imageContents = (string) Image::make($image)
                ->resize(null, config('settings.asset_logo_thumb_height'), function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode();

            
            if (Storage::put('assets/' . $imageFileName, $imageContents)) {
                
                if ($asset->logo)
                    Storage::delete('assets/' . $asset->logo);
                
                $asset->logo = $imageFileName;
            }
        
        } else if ($request->deleted === 'true' && $asset->logo) {
            Storage::delete('assets/' . $asset->logo);
            $asset->logo = NULL;
        }

        $asset->save();

        return redirect()
            ->route('backend.assets.index')
            ->with('success', __('app.asset_saved', ['name' => $asset->name]));
    }



    
    public function delete(Request $request, Asset $asset) {
        $request->session()->flash('warning', __('app.asset_delete_warning'));
        return view('pages.backend.assets.delete', ['asset' => $asset]);
    }

    
    public function destroy(Asset $asset)
    {
        $assetName = $asset->name;

        
        if ($asset->logo)
            Storage::delete('assets/' . $asset->logo);

        
        $asset->delete();

        return redirect()
            ->route('backend.assets.index')
            ->with('success', __('app.asset_deleted', ['name' => $assetName]));
    }
}
