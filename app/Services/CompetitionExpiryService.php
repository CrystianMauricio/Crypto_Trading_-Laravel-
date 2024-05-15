<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CompetitionExpiryService.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services;

use App\Events\AfterCompetitionClosed;
use App\Models\Competition;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CompetitionExpiryService
{
    private $competitionModel;

    public function __construct(Competition $competition)
    {
        
        
        
        $this->competitionModel = $competition;
    }

    public function run()
    {
        $competitions = $this->competitionModel::where('status', Competition::STATUS_IN_PROGRESS)
            ->where('end_time', '<', Carbon::now())
            ->get();

        foreach ($competitions as $competition) {
            Log::info(sprintf('Closing competition %d %s', $competition->id, $competition->title));

            
            $competition->status = $this->competitionModel::STATUS_COMPLETED;
            $competition->save();

            
            foreach ($competition->participants()->get() as $participant) {
                $tradeService = new TradeService($competition, $participant);
                $tradeService->closeAll();
            }

            
            $competition->participants()
                
                ->whereColumn([
                    ['start_balance', '!=', 'current_balance'],
                    ['competition_participants.updated_at', '>', 'competition_participants.created_at']
                ])
                ->orderBy('current_balance', 'desc')
                ->orderBy('created_at', 'asc')
                ->get()
                ->each(function ($participant, $i) {
                    $participant->data->place = $i + 1;
                    $participant->data->save();
                    
                    if (in_array($participant->data->place, [1,2,3])) {
                        $userPointService = new UserPointService();
                        $userPointService->add(
                            $participant,
                            constant('\App\Models\UserPoint::TYPE_COMPETITION_PLACE' . $participant->data->place),
                            config('settings.points_type_competition_place' . $participant->data->place)
                        );
                    }
            });

            
            event(new AfterCompetitionClosed($competition));
        }
    }
}