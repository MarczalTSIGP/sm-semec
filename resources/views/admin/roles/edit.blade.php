@extends('layouts.admin.app')

@section('title', 'Editar Cargo')
@section('content')

@include('admin.roles._form', ['route' => route('admin.update.role', $role->id),
                                          'method' => 'patch', 'submit' => 'Atualizar Cargo'])

@endsection
