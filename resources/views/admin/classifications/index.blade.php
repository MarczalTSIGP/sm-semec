@extends('layouts.admin.app')

@section('title', 'Classificação')
@section('content')
<div>
   <h4>Vagas por unidades: </h4>
   <table class="table card-table table-striped table-vcenter table-data w-50 mb-5">
    <thead>
      <tr>
        <th>Unidade</th>
        <th>Número de vagas</th>
        <th>Tipo de vaga</th>
      </tr>
    </thead>
    <tbody>
      @each('admin.edicts.edicts_units._edicts_units_row', $edictUnits, 'edictUnit')
    </tbody>
  </table>
<div>
<div class="table-responsive mt-5">
  <h4>Classificação: </h4>
  <table class="table card-table table-striped table-vcenter table-data">
    <thead>
      <tr>
        <th>Classificação</th>
        <th>Nome</th>
        <th>Matrícula</th>
        <th>Tempo Geral</th>
        <th>Graduação</th>
        <th>Tempo na unidade</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @each('admin.classifications._classification_row', $classificationOccupiedVacancyFalse, 'classification')
    </tbody>

  </table>
</div>
<div class="table-responsive mt-5">
<h4>Inscritos que assumiram vagas: </h4>
  <table class="table card-table table-striped table-vcenter table-data">
    <thead>
      <tr>
        <th>Classificação</th>
        <th>Nome</th>
        <th>Matrícula</th>
        <th>Tempo Geral</th>
        <th>Graduação</th>
        <th>Tempo na unidade</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @each('admin.classifications._classification_row', $classificationOccupiedVacancyTrue, 'classification')
    </tbody>
  </table>
</div>
@endsection
