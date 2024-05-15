<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   FreeMarginIsSufficient.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Rules;

use App\Models\Asset;
use App\Models\Competition;
use App\Models\User;
use App\Services\TradeService;
use Illuminate\Contracts\Validation\Rule;

class FreeMarginIsSufficient implements Rule
{
    private $asset;
    private $competition;
    private $user;
    private $volume;
    private $requiredMargin;

    
    public function __construct(Asset $asset, Competition $competition, User $user, $volume)
    {
        $this->asset = $asset;
        $this->competition = $competition;
        $this->user = $user;
        $this->volume = $volume;
    }

    
    public function passes($attribute = NULL, $value = NULL)
    {
        $tradeService = new TradeService($this->competition, $this->user);
        $this->requiredMargin = $tradeService->margin($this->asset, $this->volume);
        return $this->requiredMargin > 0 && $this->requiredMargin <= $tradeService->freeMargin($this->user);
    }

    
    public function message()
    {
        return __('app.free_margin_not_sufficient', ['amount' => $this->requiredMargin]);
    }
}