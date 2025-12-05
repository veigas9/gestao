@extends('layouts.app')

@section('title', 'Novo usuário')

@section('content_header')
    <h1>Novo usuário</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dados do usuário</h3>
        </div>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Nome *</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name') }}"
                               class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Senha *</label>
                        <input type="password" id="password" name="password"
                               class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirmar senha *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="role">Perfil *</label>
                        <select id="role" name="role" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" @selected(old('role') === $role)>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($authUser->isSuperAdmin())
                        <div class="form-group col-md-8">
                            <label for="company_setting_id">Loja (empresa)</label>
                            <select id="company_setting_id" name="company_setting_id" class="form-control">
                                <option value="">-- Sem vínculo --</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @selected(old('company_setting_id') == $company->id)>
                                        {{ $company->trade_name ?? $company->company_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group col-md-8">
                            <label>Loja</label>
                            <input type="text" class="form-control" disabled
                                   value="{{ $companies->first()->trade_name ?? $companies->first()->company_name ?? '---' }}">
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('users.index') }}" class="btn btn-default mr-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Salvar
                </button>
            </div>
        </form>
    </div>
@endsection


