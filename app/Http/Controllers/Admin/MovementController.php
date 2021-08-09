<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contract;
use App\Models\Movement;
use App\Models\Unit;
use App\Models\Role;
use App\Models\ServantCompletaryData;
use App\Models\Servant;

class MovementController extends AppController
{
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\View\View
     * @param  \App\Models\Servant $servantId
     * @param  \App\Models\Contract $contractId
     * @param  \App\Models\ServantCompletaryData $id
     * @SuppressWarnings("unused")
    */
    public function new($servantId, $contractId, $id)
    {
        $servant = Servant::find($servantId);
        $contract = $servant->contracts->find($contractId);
        $movement = new Movement();
        $completaryData = ServantCompletaryData::find($id);

        return view('admin.servant_completary_data.movements.new', [
            'contract' => $contract,
            'roles' => Role::all(),
            'units' => Unit::all(),
            'movement' => $movement,
            'completaryData' => $completaryData]);
    }

    /**
    * Store a newly created resource in storage.
    * @param  \Illuminate\Http\Request  $request
    * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse.
    * @param  \App\Models\Contract $contractId
    * @param  \App\Models\Servant $servantId
    * @param  \App\Models\ServantCompletaryData $id
    * @SuppressWarnings("unused")
    */
    public function create(Request $request, $servantId, $contractId, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'occupation' => 'required',
            'period' => 'required',
            'unit_id' => 'required',
            'started_at'  => 'required|date_format:d/m/Y H:i',
        ]);
        $this->filterDateTimeFormat($data, ['started_at', 'ended_at']);

        $servant = Servant::find($servantId);
        $contract = $servant->contracts->find($contractId);
        $completaryData = $contract->servantCompletaryData->find($id);

        $movement = new Movement($data);

        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.servant_completary_data.movements.new', [
                'movement' => $movement,
                'roles' => Role::all(),
                'units' => Unit::all(),
                'completaryData' => $completaryData])->withErrors($validator);
        }

        $completaryData->moviments()->save($movement);

        return redirect()->route('admin.index.completary_datas', ['servant_id' => $servant->id,
            'id' => $contract->id])->with('success', 'Movimentação adicionada com sucesso');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movement $id
     * @return  \Illuminate\View\View
     * @param  \App\Models\ServantCompletaryData $completaryDataId
     * @param  \App\Models\Contract $contractId
     * @param  \App\Models\Servant $servantId
     * @SuppressWarnings("unused")
     */
    public function edit($servantId, $contractId, $completaryDataId, $id)
    {
        $servant = Servant::find($servantId);
        $contract = $servant->contracts->find($contractId);
        $completaryData = $contract->servantCompletaryData->find($completaryDataId);
        $movement = $completaryData->moviments->find($id);

        return view('admin.servant_completary_data.movements.edit', [
            'movement' => $movement,
            'completaryData' => $completaryData,
            'roles' => Role::all(),
            'units' => Unit::all()]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  \App\Models\Contract $contractId
    * @param  \App\Models\Servant $servantId
    * @param  \App\Models\Movement $id
    * @param  \App\Models\ServantCompletaryData $completaryDataId
    * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
    * @SuppressWarnings("unused")
    */
    public function update(Request $request, $servantId, $contractId, $completaryDataId, $id)
    {
        $data = $request->all();

        $servant = Servant::find($servantId);
        $contract = $servant->contracts->find($contractId);
        $completaryData = $contract->servantCompletaryData->find($completaryDataId);
        $movement = $completaryData->moviments->find($id);

        $validator = Validator::make($data, [
        'occupation' => "required",
        'period' => 'required',
        'unit_id' => "required",
        'started_at'  => 'required|date_format:d/m/Y H:i',
        ]);

        $movement->fill($data);

        if ($validator->fails()) {
                $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
                return view('admin.servant_completary_data.movements.edit', [
                    'completaryData' => $completaryData,
                    'roles' => Role::all(),
                    'units' => Unit::all(),
                    'movement' => $movement])->withErrors($validator);
        }

        $movement->save();
        return redirect()->route('admin.index.completary_datas', ['servant_id' => $servant->id, 'id' =>
            $contract->id])
        ->with('success', 'Movimentação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
    * @param  \App\Models\Contract $contractId
    * @param  \App\Models\Servant $servantId
    * @param  \App\Models\Movement $id
    * @param  \App\Models\ServantCompletaryData $completaryDataId
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function destroy($servantId, $contractId, $completaryDataId, $id)
    {
        $servant = Servant::find($servantId);
        $contract = $servant->contracts->find($contractId);
        $completaryData = $contract->servantCompletaryData->find($completaryDataId);
        $movement = $completaryData->moviments->find($id);

        $movement->delete();
        return redirect()->route('admin.index.completary_datas', [
            'servant_id' => $servant->id, 'id' => $contract->id
        ])->with('success', 'Movimentação removida com sucesso.');
    }
}
