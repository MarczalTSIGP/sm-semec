<?php

namespace App\Services;

use App\Models\Classification;
use App\Models\Movement;
use App\Models\Inscription;
use App\Models\EdictUnit;

class ClassificationService
{
    public function calculateDaysWorked($inscription)
    {
          $daysWorked  = \Carbon\Carbon::now()->diffInDays($inscription->contract->admission_at);

          return $daysWorked;
    }

    public function calculateFormationScore($inscription)
    {
        $score =  $inscription->contract->servantCompletaryData->formation->score_formation;

        return $score;
    }

    public function calculateDaysWorkedInUnit($inscription)
    {
        $servantCompletaryData = $inscription->contract->servantCompletaryData;
         $unitIds = [];
        foreach ($inscription->interestedUnits as $unit) {
                $unitIds [] = $unit->id;
        }

        $movements = Movement::where('servant_completary_data_id', $servantCompletaryData->id)
                             ->whereIn('unit_id', $unitIds)->get();
        $diffDates = 0;

        if ($movements) {
            foreach ($movements as $movement) {
                $started = $movement->started_at;
                $diffDates +=  $started->diffInDays($movement->ended_at);
            }
        }
        return $diffDates;
    }

    public function calculaterank()
    {
        $classifications = Classification::where('occupied_vacancy', false)
                                         ->orderBy('worked_days', 'desc')
                                         ->orderBy('formation_points', 'desc')
                                         ->orderBy('worked_days_unit', 'desc')
                                         ->get();

        $count = 1;

        foreach ($classifications as $classification) {
            $classification['rank'] = $count;
            $classification->save();
            $count++;
        }
    }

    public function decreaseVacancyInUnitOfInterest($inscription)
    {

        foreach ($inscription->interestedUnits as $unit) {
            $edictUnit = EdictUnit::where('edict_id', $inscription->edict_id)
                              ->where('unit_id', $unit->id)
                              ->first();
            if ($edictUnit) {
                if ($edictUnit->number_vacancies > 0) {
                    if (is_null($edictUnit->servants_id)) {
                        $edictUnit->servants_id = $inscription->contract->servant_id;
                    }
                        $count = $this->countServants($edictUnit->servants_id);

                    if ($edictUnit->number_vacancies != $count) {
                            $edictUnit->servants_id = $edictUnit->servants_id . ","
                            . $inscription->contract->servant_id;
                    }

                    $edictUnit->update();
                    return;
                }
            }
        }
    }


    public function countServants($servantsId)
    {
        $countServant;

        if (is_null($servantsId)) {
            $countServant = 0;
        }
            $servants = explode(',', $servantsId);
            $countServant = count($servants);
        return $countServant;
    }

    public function increaseVacancyInTheUnit($inscription)
    {
        $edictUnit = EdictUnit::where('edict_id', $inscription->edict_id)
                              ->where('unit_id', $inscription->current_unit_id)
                              ->where('type_of_vacancy', 'released')
                              ->first();

        if ($edictUnit) {
            $edictUnit->number_vacancies = $edictUnit->number_vacancies + 1;
            $edictUnit->update();
            return redirect()->route('admin.new.vacant_unit', ['edict' => $inscription->edict])
            ->with('success', 'Vagas cadastradas com sucesso');
        }
        EdictUnit::create([
                        'edict_id' => $inscription->edict_id,
                        'unit_id' => $inscription->current_unit_id,
                        'number_vacancies' => '1',
                        'type_of_vacancy' => 'released']);
        return redirect()->route('admin.new.vacant_unit', ['edict' => $inscription->edict])
                            ->with('success', 'Vagas cadastradas com sucesso');
    }
}
