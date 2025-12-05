@extends('layouts.app')

@section('title', 'Nova loja')

@section('content_header')
    <h1>Nova loja</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dados da loja</h3>
        </div>
        <form action="{{ route('stores.store') }}" method="POST">
            @csrf
            <div class="card-body">
                @include('stores.partials._form-fields', ['store' => $store])
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('stores.index') }}" class="btn btn-default mr-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Salvar
                </button>
            </div>
        </form>
    </div>
@endsection


