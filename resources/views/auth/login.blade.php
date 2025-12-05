<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Gestão Materiais de Construção</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br">
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-primary mb-1">Gestão Materiais de Construção</h1>
            <p class="text-sm text-gray-600">Acesse o painel de controle de estoque</p>
        </div>

        <div class="card shadow-lg">
            <form method="POST" action="{{ route('login.perform') }}" class="space-y-4">
                @csrf

                @if($errors->any())
                    <div class="alert-error mb-2">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-input" required autofocus>
                </div>

                <div>
                    <label class="form-label">Senha</label>
                    <input type="password" name="password" class="form-input" required>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="remember">
                        <span>Lembrar-me</span>
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full mt-2">
                    Entrar
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-500 mt-4">
            Desenvolvido para controle de materiais de construção.
        </p>
    </div>
    </div>
</body>
</html>




