@extends('layouts.app')

@section('title', 'Usuários')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Usuários</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Novo usuário
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Loja</th>
                    <th>Perfil</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->companySetting?->trade_name ?? $user->companySetting?->company_name ?? '-' }}</td>
                        <td>
                            @if($user->role === \App\Models\User::ROLE_SUPER_ADMIN)
                                SUPER_ADMIN
                            @elseif($user->role === \App\Models\User::ROLE_ADMIN)
                                ADMIN
                            @else
                                USER
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex align-items-center">
                                <a href="{{ route('users.edit', $user) }}"
                                   class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-edit mr-1"></i> Editar
                                </a>
                                @if($authUser->id !== $user->id)
                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Excluir
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted p-3">
                            Nenhum usuário cadastrado.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection


