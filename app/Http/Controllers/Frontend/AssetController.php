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

namespace App\Http\Controllers\Frontend;

use App\Models\Asset;
use App\Http\Controllers\Controller;
use App\Models\Sort\Frontend\AssetSort;
use App\Services\AssetService;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $sort = new AssetSort($request);

        $assets = Asset::where('status', Asset::STATUS_ACTIVE)
            ->withCount('trades')
            ->orderBy($sort->getSortColumn(), $sort->getOrder())
            ->paginate($this->rowsPerPage);

        return view('pages.frontend.assets.index', [
            'assets'    => $assets,
            'sort'      => $sort->getSort(),
            'order'     => $sort->getOrder(),
        ]);
    }


    
    public function remember(Request $request, Asset $asset)
    {
        session(['default_asset_id' => $asset->id]);
        return ['success' => TRUE];
    }

    
    public function search($query) {
        $query = strtolower($query);

        
        $assets = Asset::select('name', 'id AS value')
            ->where('status', Asset::STATUS_ACTIVE)
            ->where(function($sql) use($query) {
                $sql->whereRaw('LOWER(symbol) LIKE ?', [$query.'%']);
                $sql->orWhereRaw('LOWER(name) LIKE ?', ['%'.$query.'%']);
            })
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get()
            ->makeHidden(['logo_url', 'title']); 

        return [
            'success' => TRUE,
            'results' => $assets
        ];
    }

    public function info(Request $request)
    {
        $assetsIds = array_filter($request->ids ?: [], function ($id) {
            return intval($id) > 0;
        });

        $assets = [];

        if (!empty($assetsIds)) {
            $assetService = new AssetService();
            foreach ($assetsIds as $assetId) {
                $asset = Asset::findOrFail($assetId);
                if ($asset->status == Asset::STATUS_ACTIVE) {
                    $assets[] = $assetService->asset($asset);
                }
            }
        }

        return $assets;
    }
}