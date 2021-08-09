@extends('layouts.admin.app')

@section('title', 'Cargos')
@section('content')

@component('components.index.header', ['base_search_path' => route('admin.roles'),
                                       'new_url' => route('admin.new.role'),
                                       'new_btn_name' => 'Novo Cargo']) @endcomponent

<div class="table-responsive mt-3">
@component('components.index.page_entries_info', ['entries' => $roles]) @endcomponent

  <table class="table card-table table-striped table-vcenter table-data">
    <thead>
      <tr>
        <th>Nome</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @each('admin.roles._role_row', $roles, 'role')
    </tbody>
  </table>
  <div class="mt-5 float-right flex-wrap">
    {!! $roles !!}
  </div>
</div>
@endsection
