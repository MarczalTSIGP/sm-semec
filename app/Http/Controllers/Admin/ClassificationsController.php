<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Models\Classification;
use App\Models\Inscription;
use App\Models\EdictUnit;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AppController;
use App\Services\ClassificationService;
use stdClass;

class ClassificationsController extends AppController
{
    /**
    * Display a listing of the resource.
    * @param  int  $edict
    * @return \Illuminate\View\View
    */
    public function index($edict)
    {
        $classifications = Classification::where('edict_id', $edict)->orderBy('rank', 'asc')->get();
        $classificationOccupiedVacancyFalse = $classifications->where('occupied_vacancy', false);
        $classificationOccupiedVacancyTrue = $classifications->where('occupied_vacancy', true);
        $edictUnits = $this->mountedArray($edict);

        return view('admin.classifications.index', [
                                                        'classificationOccupiedVacancyFalse'
                                                        => $classificationOccupiedVacancyFalse,
                                                        'classificationOccupiedVacancyTrue'
                                                        => $classificationOccupiedVacancyTrue,
                                                        'edictUnits'
                                                        => $edictUnits,
                                                    ]);
    }

    /**
     * @param  mixed $data
     * @param  \App\Models\Inscription  $inscription
     * @return mixed
     */
    public function create($data, $inscription)
    {
        $classificationService = new ClassificationService();

        $data['worked_days'] = $classificationService->calculateDaysWorked($inscription);
        $data['formation_points'] = $classificationService->calculateFormationScore($inscription);
        $data['worked_days_unit'] =  $classificationService->calculateDaysWorkedInUnit($inscription);

        $classification = new Classification($data);
        $classification->save();
        $classificationService->calculateRank();

        return;
    }

     /**
     * @param  int  $id
     * @return mixed
     */
    public function updateVacancyOccupation($id)
    {
        $classification =  Classification::find($id);
        $classificationService = new ClassificationService();
        $inscription = Inscription::find($classification->inscription_id);

        $classificationService->decreaseVacancyInUnitOfInterest($inscription);
        $classificationService->increaseVacancyInTheUnit($inscription);
        $classification->occupied_vacancy = true;
        $classification->save();
        $classificationService->calculateRank();

        return $this->index($classification->edict_id);
    }

     /**
     * @param int $edict
     * @return array $listEdictUnits
     */
    public function mountedArray($edict)
    {
        $edictUnits = EdictUnit::where('edict_id', $edict)->get();
        $classificationService = new ClassificationService();

        $listEdictUnits = [];
        foreach ($edictUnits as $edictUnit) {
            $countServants = $classificationService->countServants($edictUnit->servants_id);
            $unit = Unit::find($edictUnit->unit_id);
            $unitVancancies = new stdClass();
            $unitVancancies->unit_name = $unit->name;

            $unitVancancies->vacancies = $edictUnit->number_vacancies - $countServants;
            $unitVancancies->type_of_vacancy = $edictUnit->type_of_vacancy;
            array_push($listEdictUnits, $unitVancancies);
        }
        return $listEdictUnits;
    }
}
