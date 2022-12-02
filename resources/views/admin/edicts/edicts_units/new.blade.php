@extends('layouts.admin.app')

@section('title', 'Cadastrar vagas por unidade')
@section('content')

@include('admin.edicts.edicts_units._form', ['route' => route('admin.create.vacant_unit', $edict->id), 'method' => 'POST', 'submit' => 'Adicionar vagas para essa unidade'])

@endsection