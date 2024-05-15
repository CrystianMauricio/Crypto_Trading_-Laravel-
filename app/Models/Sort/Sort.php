<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   Sort.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models\Sort;

use Illuminate\Http\Request;

class Sort
{
    private $request;

    
    protected $sortableColumns = [];

    
    protected $defaultSort = 'id';

    
    protected $defaultOrder = 'desc';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    
    public function getSort() {
        $sort = (string) $this->request->input('sort');
        return array_key_exists($sort, $this->sortableColumns)
                ? $sort
                : $this->defaultSort;
    }

    
    public function getSortColumn() {
        $sort = (string) $this->request->input('sort');
        return array_key_exists($sort, $this->sortableColumns)
                ? $this->sortableColumns[$sort]
                : $this->sortableColumns[$this->defaultSort];
    }

    
    public function getOrder() {
        $order = (string) $this->request->input('order');
        return in_array($order, ['asc','desc']) ? $order : $this->defaultOrder;
    }
}