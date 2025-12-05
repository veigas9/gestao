<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Gestão de Materiais de Construção')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
<nav class="navbar shadow">
    <div class="navbar-inner max-w-6xl mx-auto px-4">
        <div class="navbar-left">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <span class="logo-circle">GM</span>
                <span class="brand-text">Gestão Materiais de Construção</span>
            </a>
            @auth
                <a href="{{ route('sales.index') }}" class="navbar-link">
                    Vendas
                </a>
                <a href="{{ route('categories.index') }}" class="navbar-link">
                    Categorias
                </a>
                <a href="{{ route('materials.index') }}" class="navbar-link">
                    Materiais
                </a>
                <a href="{{ route('stock-movements.index') }}" class="navbar-link">
                    Movimentações
                </a>
            @endauth
        </div>
        <div class="navbar-right">
            @auth
                <span class="navbar-user">
                    {{ auth()->user()->name ?? 'Usuário' }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-link">
                        Sair
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-4 pb-8 mt-4">
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 text-sm">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        @yield('content')
    </div>
</main>
</body>
</html>
