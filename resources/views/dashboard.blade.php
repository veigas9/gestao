@extends('layouts.app')

@section('title', 'Dashboard - Controle de Estoque')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Visão geral do estoque</h1>

    <p class="mb-4 text-sm text-gray-700">
        Aqui você tem uma visão rápida dos materiais cadastrados e seus saldos atuais.
    </p>

    <div class="bg-white shadow rounded p-4">
        <live-stock-table></live-stock-table>
        {{-- Fallback simples em Blade caso você não use componentes JS reativos depois --}}
        @php
            $materials = \App\Models\Material::with('category')->orderBy('name')->get();
        @endphp

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                <tr class="border-b bg-gray-50">
                    <th class="px-3 py-2 text-left">Categoria</th>
                    <th class="px-3 py-2 text-left">Material</th>
                    <th class="px-3 py-2 text-right">Estoque atual</th>
                    <th class="px-3 py-2 text-right">Estoque mínimo</th>
                    <th class="px-3 py-2 text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($materials as $material)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-2">
                            {{ $material->category?->name ?? '-' }}
                        </td>
                        <td class="px-3 py-2">
                            <div class="font-semibold">{{ $material->name }}</div>
                            @if($material->code)
                                <div class="text-xs text-gray-500">Código: {{ $material->code }}</div>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-right">
                            {{ number_format($material->current_stock, 3, ',', '.') }} {{ $material->unit }}
                        </td>
                        <td class="px-3 py-2 text-right">
                            {{ $material->minimum_stock ? number_format($material->minimum_stock, 3, ',', '.') : '-' }}
                        </td>
                        <td class="px-3 py-2">
                            <div class="table-actions">
                                <a href="{{ route('stock-movements.create', ['material_id' => $material->id]) }}"
                                   class="btn-chip btn-chip--primary">
                                    Nova movimentação
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-3 py-4 text-center text-gray-500">
                            Nenhum material cadastrado ainda.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection


