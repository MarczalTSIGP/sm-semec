@extends('layouts.admin.app')

@section('title', 'Servidores')
@section('content')

@component('components.index.header', ['search_url' => route('admin.search.servants')]) @endcomponent

<div class="table-responsive mt-3">
  <table class="table card-table table-striped table-vcenter">
      <thead>
         <tr>
           <th>Nome</th>
           <th>CPF</th>
           <th>Matrícula</th>
           <th>Cargo / Local de trabalho</th>
         </tr>
       </thead>
       <tbody>
          @each('admin.servants._servant_row', $servants, 'servant')
       </tbody>
    </table>
  </div>
</div>

@endsection
