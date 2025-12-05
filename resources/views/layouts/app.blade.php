@extends('adminlte::page')

@section('title', trim($__env->yieldContent('title', 'Gestão de Materiais de Construção')))

@section('css')
    @vite('resources/css/app.css')
@endsection

@section('js')
    @vite('resources/js/app.js')
@endsection

@section('content_header')
    {{-- Espaço reservado caso alguma view queira sobrescrever o header do conteúdo --}}
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
@endsection
