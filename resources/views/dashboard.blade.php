@extends('layouts.app')

@section('title', 'Dashboard - Controle de Estoque')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    @php
        use App\Models\Material;
        use App\Models\Category;
        use App\Models\Sale;

        $materialsCount = Material::count();
        $categoriesCount = Category::count();
        $totalStockQty = Material::sum('current_stock');
        $salesToday = Sale::whereDate('sale_date', now())->sum('total');

        $salesByDay = Sale::selectRaw('DATE(sale_date) as date, SUM(total) as total')
            ->where('sale_date', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $salesByDay->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m'))->values();
        $chartData = $salesByDay->pluck('total')->values();
    @endphp

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $materialsCount }}</h3>
                    <p>Materiais cadastrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <a href="{{ route('materials.index') }}" class="small-box-footer">
                    Ver materiais <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($totalStockQty, 0, ',', '.') }}</h3>
                    <p>Itens em estoque (soma de quantidades)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <a href="{{ route('stock-movements.index') }}" class="small-box-footer">
                    Ver movimentações <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $categoriesCount }}</h3>
                    <p>Categorias</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i>
                </div>
                <a href="{{ route('categories.index') }}" class="small-box-footer">
                    Ver categorias <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>R$ {{ number_format($salesToday, 2, ',', '.') }}</h3>
                    <p>Vendas de hoje</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="{{ route('sales.index') }}" class="small-box-footer">
                    Ver vendas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vendas nos últimos 7 dias</h3>
                </div>
                <div class="card-body">
                    <canvas id="sales-chart" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resumo rápido</h3>
                </div>
                <div class="card-body">
                    <p>Total de materiais: <strong>{{ $materialsCount }}</strong></p>
                    <p>Total de categorias: <strong>{{ $categoriesCount }}</strong></p>
                    <p>Itens em estoque: <strong>{{ number_format($totalStockQty, 0, ',', '.') }}</strong></p>
                    <p>Vendas hoje: <strong>R$ {{ number_format($salesToday, 2, ',', '.') }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4 mb-2">Visão geral do estoque</h3>

    <p class="mb-4 text-sm text-gray-700">
        Aqui você tem uma visão rápida dos materiais cadastrados e seus saldos atuais.
    </p>

    <div class="card">
        <div class="card-body table-responsive p-0">
            @php
                $materials = Material::with('category')->orderBy('name')->get();
            @endphp

            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Material</th>
                    <th class="text-right">Estoque atual</th>
                    <th class="text-right">Estoque mínimo</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($materials as $material)
                    <tr>
                        <td>
                            {{ $material->category?->name ?? '-' }}
                        </td>
                        <td>
                            <div class="font-weight-bold">{{ $material->name }}</div>
                            @if($material->code)
                                <div class="text-muted small">Código: {{ $material->code }}</div>
                            @endif
                        </td>
                        <td class="text-right">
                            {{ number_format($material->current_stock, 3, ',', '.') }} {{ $material->unit }}
                        </td>
                        <td class="text-right">
                            {{ $material->minimum_stock ? number_format($material->minimum_stock, 3, ',', '.') : '-' }}
                        </td>
                        <td class="text-center">
                            <div class="table-actions">
                                <a href="{{ route('stock-movements.create', ['material_id' => $material->id]) }}"
                                   class="btn btn-xs btn-primary">
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

@section('js')
    <script>
        const ctx = document.getElementById('sales-chart').getContext('2d');
        const salesChartLabels = @json($chartLabels);
        const salesChartData = @json($chartData);

        if (typeof Chart !== 'undefined') {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: salesChartLabels,
                    datasets: [{
                        label: 'Total de vendas (R$)',
                        data: salesChartData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
@endsection
