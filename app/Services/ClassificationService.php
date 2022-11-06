<?php

namespace App\Services;

use App\Models\Classification;
use App\Models\Movement;

class ClassificationService
{
    public function calculateDaysWorked($inscription){
          $daysWorked  = \Carbon\Carbon::now()->diffInDays($inscription->contract->admission_at);

          return $daysWorked;
    }

    public function calculateFormationScore($inscription){
        $score =  $inscription->contract->servantCompletaryData->formation->score_formation;

        return $score;
    }

    public function calculateDaysWorkedInUnit($inscription){
        $servantCompletaryData = $inscription->contract->servantCompletaryData;
        $unitIds = [];
       foreach($inscription->interestedUnits as $unit){
                $unitIds [] = $unit->id;
       }
        

        $movements = Movement::where('servant_completary_data_id', $servantCompletaryData->id)
                             ->whereIn('unit_id', $unitIds)->get();
       
        $diffDates = 0;
        
    if($movements){
        foreach($movements as $movement)
        {
            $started = $movement->started_at;
            $diffDates +=  $started->diffInDays($movement->ended_at);
        }
    } else {
        return $diffDates;
    }
      return $diffDates;
        
    }

    public function calculaterank(){
        $classifications = Classification::orderBy('worked_days', 'desc')
                                         ->orderBy('formation_points', 'desc')
                                         ->orderBy('worked_days_unit', 'desc')
                                         ->get();
        
        $count = 1;

        foreach($classifications as $classification){
            $classification['rank'] = $count;
            $classification->save();
            $count++;
        }

    }

   
   
}
