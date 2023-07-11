@extends('layouts.admin.app')

@section('title', 'Cadastrar vagas no edital')
@section('content')

@include('admin.edicts.vacancies._form', ['route' => route('admin.create.vacancies'), 'method' => 'POST', 'submit' => 'Adicionar quantidade de vagas'])

@endsection