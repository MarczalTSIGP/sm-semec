<?php

namespace App\Http\Controllers\Servant;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Servant\AppController;
use Illuminate\Http\Request;
use App\Models\Edict;
use App\Models\Inscription;
use App\Models\Unit;
use App\Models\RemovalType;
use App\Models\Contract;
use App\Http\Controllers\Admin\ClassificationsController;
use DB;

class InscriptionsController extends AppController
{
     /** @var \App\Models\Edict */
    protected $edict;

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->redirectToDashboardIfExpired();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $servant = \Auth::guard('servant')->user();

        return view('servant.edicts.inscriptions.index', [
            'servant' => $servant->inscriptions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse.
     */
    public function new()
    {
        $servant = \Auth::guard('servant')->user();
        $inscription = new Inscription();
        $inscription->current_unit_id = $servant->currentUnit()->id;
        $inscription->interested_unit_ids = []; /* @phpstan-ignore-line */

        return view('servant.edicts.inscriptions.new', [
            'edict' => $this->edict,
            'servant' => $servant,
            'contracts' => $servant->contracts,
            'units' => Unit::orderBy('name', 'ASC')->get(),
            'removal_types' => RemovalType::all(),
            'inscription' => $inscription
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse.
       */
    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'contract_id'         => 'required',
            'removal_type_id'     => 'required',
            'interested_unit_ids' => 'required',
            'reason'              => 'required',
        ]);

        $contract = Contract::find($data['contract_id']);

        if ($contract->servantCompletaryData == null) {
            $request->session()->now('danger', 'É necessário um cadastro complementar em seu contrato.');
            return $this->new();
        }

        $servant = \Auth::guard('servant')->user();
        $inscription = new Inscription($data);
        $inscription->servant_id = $servant->id;
        $inscription->current_unit_id = $servant->currentUnit()->id;

        if ($validator->fails()) {
            $request->session()->now('danger', 'Existem dados incorretos! Por favor verifique!');

            $iuids = $request->interested_unit_ids;
            $inscription->interested_unit_ids = isset($iuids) ? $iuids : []; /* @phpstan-ignore-line */

            return view('servant.edicts.inscriptions.new', [
                'edict' => $this->edict,
                'servant' => $servant,
                'contracts' => $servant->contracts,
                'units' => Unit::orderBy('name', 'ASC')->get(),
                'removal_types' => RemovalType::all(),
                'inscription' => $inscription
            ])->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $this->edict->inscriptions()->save($inscription);
            $inscription->interestedUnits()->attach($request->interested_unit_ids);

            $classfication = [
                'inscription_id' => $inscription->id,
                'edict_id'       => $this->edict->id,
            ];

            $classficationController = new ClassificationsController();
            $classficationController->create($classfication, $inscription);

            DB::commit();

            return redirect()->route('servant.dashboard')->with('success', 'Inscrição realizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();

            return view('servant.edicts.inscriptions.new', [
                'edict' => $this->edict,
                'servant' => $servant,
                'contracts' => $servant->contracts,
                'units' => Unit::orderBy('name', 'ASC')->get(),
                'removal_types' => RemovalType::all(),
                'inscription' => $inscription
            ])->with('danger', 'Existem dados incorretos! Por favor verifique!');
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Inscription  $id
    * @return \Illuminate\View\View
    */
    public function show($id)
    {
        $inscription = Inscription::find($id);

        return view('servant.edicts.inscriptions.show', [
                    'inscription' => $inscription]);
    }

    private function redirectToDashboardIfExpired(): void
    {
        $this->middleware(function ($request, $next) {
            $this->edict = Edict::find($request->edict_id);

            if (now()->gt($this->edict->ended_at)) {
                \Session::flash('danger', 'A data limite das inscrições foi atingida!');
                return redirect()->route('servant.dashboard');
            }
            return $next($request);
        })->except(['index','show']);
    }
}
