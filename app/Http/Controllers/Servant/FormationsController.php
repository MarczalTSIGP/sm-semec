<?php

namespace App\Http\Controllers\Servant;

use Illuminate\Support\Facades\Validator;
use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Servant\AppController;

class FormationsController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed $formations
     */
    public function index()
    {

        $formations = Formation::all();
        return $formations;
    }

    /**
     * Store a newly created resource in storage.
     * @param  array  $data
     * @return  mixed
     */
    public function create($data)
    {
        $formation = new Formation($data);

        $formation->save();
        return;
    }
}
