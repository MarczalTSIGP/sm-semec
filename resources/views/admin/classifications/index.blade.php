@extends('layouts.admin.app')

@section('title', 'Classificação')
@section('content')

@component('components.index.header', ['base_search_path' => route('admin.edicts')]) @endcomponent

<div class="table-responsive mt-3">

  <table class="table card-table table-striped table-vcenter table-data">
    <thead>
      <tr>
        <th>Classificação</th>
        <th>Nome</th>
        <th>Matrícula</th>
        <th>Tempo Geral</th>
        <th>Graduação</th>
        <th>Tempo na unidade</th>
      </tr>
    </thead>
    <tbody>
      @each('admin.classifications._classification_row', $classifications, 'classification')
    </tbody>
  </table>
  <div class="mt-5 float-right flex-wrap">
   
  </div>
</div>
@endsection
