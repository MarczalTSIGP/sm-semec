@extends('layouts.admin.app')

@section('title', 'Dados Complementares - '. $contract->servant->name. ', '.$contract->registration)
@section('content')

@include('admin.servant_completary_data._contract_data')

  <fieldset class="border p-2 mt-5">
    <legend  class="w-auto">Dados Adicionais</legend>

    @if($completaryData == null)
      <a href="{{ route('admin.new.completary_data', ['servant_id' => $contract->servant_id, 'id' => $contract->id]) }}" class="btn btn-outline-primary d-block col-md-2 ml-md-auto">
        <i class="fas fa-plus"></i>
        Novo Cadastro Complementar
      </a>
    @endisset

    @isset($completaryData)
      <span class="span-field-effect ">Formação Acadêmica</span>
      <p class="p-field-effect">{{$completaryData->formation->formation_name}}</p>

      <span class="span-field-effect ">Carga Horária</span>
      <p class="p-field-effect">{{$completaryData->workload->hours}}</p>

      <span class="span-field-effect ">Observação</span>
      <p class="p-field-effect">{{$completaryData->observation}}</p>

      <a href="{{ route('admin.edit.completary_data', ['servant_id' => $completaryData->contract->servant_id,
                                                       'contract_id' => $completaryData->contract_id,
                                                       'id' => $completaryData->id]) }}" class="btn btn-outline-primary d-block col-md-2 ml-md-auto">
          <i class="fas fa-plus"></i>
          Editar Cadastro Complementar
        </a>
    @endisset
  </fieldset>

  @isset($completaryData)
     @include('admin.servant_completary_data.movements.index')
  @endisset

@endsection
