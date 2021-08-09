@extends('layouts.admin.app')

@section('title', 'Novo Cargo')
@section('content')

@include('admin.roles._form', ['route' => route('admin.create.role'), 'method' => 'POST', 'submit' => 'Criar Cargo'])

@endsection
