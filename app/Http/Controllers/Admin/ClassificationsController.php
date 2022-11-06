<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Models\Classification;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AppController;
use App\Services\ClassificationService;

class ClassificationsController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
      
        $classifications = Classification::orderBy('rank', 'asc')->get();
         
        return view('admin.classifications.index', ['classifications' => $classifications]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse.
     */
    public function create($data, $inscription)
    {
        $classificationService = new ClassificationService();

        $data['worked_days'] = $classificationService->calculateDaysWorked($inscription);
        $data['formation_points'] = $classificationService->calculateFormationScore($inscription);
        $data['worked_days_unit'] =  $classificationService->calculateDaysWorkedInUnit($inscription);;

        $classificationService->calculateRank();

        $validator = Validator::make($data, [
            'inscription_id' => 'required|exists:inscriptions,id',
            'edict_id'       => 'required|exists:edicts,id',
            'worked_days'    => 'required|integer',
            'formation_points' => 'required|integer',
            'worked_days_unit' => 'required|integer',
              
      ]);

        $classification = new Classification($data);

        $classification->save();
        
        $classificationService->calculateRank();
    }


}
