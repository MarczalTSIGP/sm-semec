<?php

namespace App\Services;

use App\Models\Classification;
use App\Models\Movement;
use App\Models\Inscription;
use App\Models\EdictUnit;

class ClassificationService
{
    /**
    * @return int $daysWorked
    */
    public function calculateDaysWorked(Inscription $inscription)
    {
          $daysWorked  = \Carbon\Carbon::now()->diffInDays($inscription->contract->admission_at);

          return $daysWorked;
    }

    /**
    * @return int $score
    */
    public function calculateFormationScore(Inscription $inscription)
    {
        $score =  $inscription->contract->servantCompletaryData->formation->score_formation;

        return $score;
    }

    /**
    * @return int $diffDates
    */
    public function calculateDaysWorkedInUnit(Inscription $inscription)
    {
        $servantCompletaryData = $inscription->contract->servantCompletaryData;
         $unitIds = [];
        foreach ($inscription->interestedUnits as $unit) {
                $unitIds [] = $unit->id;
        }

        $movements = Movement::where('servant_completary_data_id', $servantCompletaryData->id)
                             ->whereIn('unit_id', $unitIds)->get();
        $diffDates = 0;

        foreach ($movements as $movement) {
            $started = $movement['started_at'];
            $diffDates +=  $started->diffInDays($movement['ended_at']);
        }

        return $diffDates;
    }

    /**
    * @return mixed
    */
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
        return;
    }

    /**
    * @return mixed
    */
    public function decreaseVacancyInUnitOfInterest(Inscription $inscription)
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

    /**
    * @return int $countServant
    */
    public function countServants(string $servantsId)
    {
        $countServant = 0;

        if (!is_null($servantsId)) {
            $servants = explode(',', $servantsId);
            $countServant = count($servants);
        }
        return $countServant;
    }

    /**
    * @return mixed
    */
    public function increaseVacancyInTheUnit(Inscription $inscription)
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
