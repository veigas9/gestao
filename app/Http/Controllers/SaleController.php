<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with('seller')
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->paginate(20);

        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materials = Material::orderBy('name')->get();

        $materialsForJs = $materials->map(function (Material $m) {
            return [
                'id' => $m->id,
                'name' => $m->name,
                'unit' => $m->unit,
                'current_stock' => (float) $m->current_stock,
            ];
        });

        return view('sales.create', compact('materials', 'materialsForJs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['nullable', 'string', 'max:255'],
            'discount_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.material_id' => ['required', 'exists:materials,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.001'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $discountPercent = (float) ($data['discount_percent'] ?? 0);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $itemsData = [];

            // Validação de estoque e cálculo dos itens
            foreach ($data['items'] as $item) {
                /** @var \App\Models\Material $material */
                $material = Material::lockForUpdate()->findOrFail($item['material_id']);

                $quantity = (float) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];
                $lineTotal = $quantity * $unitPrice;

                // Bloqueia estoque negativo somando a quantidade da venda
                if ($material->current_stock - $quantity < 0) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'items' => ["Quantidade para {$material->name} superior ao estoque disponível."],
                    ]);
                }

                $subtotal += $lineTotal;

                $itemsData[] = [
                    'material' => $material,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total' => $lineTotal,
                ];
            }

            $discountAmount = $discountPercent > 0
                ? round($subtotal * ($discountPercent / 100), 2)
                : 0;

            $total = $subtotal - $discountAmount;

            $sale = Sale::create([
                'user_id' => Auth::id(),
                'customer_name' => $data['customer_name'] ?? null,
                'subtotal' => $subtotal,
                'discount_percent' => $discountPercent,
                'discount_amount' => $discountAmount,
                'total' => $total,
                'sale_date' => now(),
                'notes' => null,
            ]);

            // Cria itens e movimentações de estoque
            foreach ($itemsData as $itemData) {
                /** @var \App\Models\Material $material */
                $material = $itemData['material'];
                $quantity = $itemData['quantity'];
                $unitPrice = $itemData['unit_price'];
                $lineTotal = $itemData['total'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'material_id' => $material->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total' => $lineTotal,
                ]);

                $previousStock = $material->current_stock;
                $resultingStock = $previousStock - $quantity;

                StockMovement::create([
                    'material_id' => $material->id,
                    'sale_id' => $sale->id,
                    'type' => 'out',
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'previous_stock' => $previousStock,
                    'resulting_stock' => $resultingStock,
                    'movement_date' => now(),
                    'notes' => 'Venda #' . $sale->id,
                ]);

                $material->update([
                    'current_stock' => $resultingStock,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('sales.show', $sale)
                ->with('success', 'Venda registrada com sucesso.');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Sale::with(['seller', 'items.material'])->findOrFail($id);

        return view('sales.show', compact('sale'));
    }
}


