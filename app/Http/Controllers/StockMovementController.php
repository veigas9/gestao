<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = StockMovement::with('material.category')
            ->orderByDesc('movement_date')
            ->orderByDesc('id')
            ->paginate(20);

        $materials = Material::orderBy('name')->get();

        return view('stock_movements.index', compact('movements', 'materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materials = Material::orderBy('name')->get();

        // Estrutura simplificada dos materiais para ser usada em JavaScript
        $materialsForJs = $materials->map(function (Material $m) {
            return [
                'id' => $m->id,
                'name' => $m->name,
                'current_stock' => (float) $m->current_stock,
                'unit' => $m->unit,
            ];
        });

        return view('stock_movements.create', compact('materials', 'materialsForJs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'material_id' => ['required', 'exists:materials,id'],
            'type' => ['required', 'in:in,out'],
            'quantity' => ['required', 'numeric', 'min:0.001'],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'movement_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $material = Material::findOrFail($data['material_id']);

        $previousStock = $material->current_stock;
        $quantity = (float) $data['quantity'];

        if ($data['type'] === 'in') {
            $resultingStock = $previousStock + $quantity;
        } else {
            // Saída: bloquear estoque negativo
            if ($previousStock - $quantity < 0) {
                return back()
                    ->withInput()
                    ->withErrors(['quantity' => 'Quantidade superior ao estoque disponível.']);
            }

            $resultingStock = $previousStock - $quantity;
        }

        $movement = new StockMovement();
        $movement->fill($data);
        $movement->previous_stock = $previousStock;
        $movement->resulting_stock = $resultingStock;
        if (!empty($data['movement_date'])) {
            $movement->movement_date = $data['movement_date'];
        }
        $movement->save();

        $material->update(['current_stock' => $resultingStock]);

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Movimentação registrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movement = StockMovement::with('material.category')->findOrFail($id);

        return view('stock_movements.show', compact('movement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $movement = StockMovement::findOrFail($id);
        $materials = Material::orderBy('name')->get();

        return view('stock_movements.edit', compact('movement', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Para manter o exemplo simples e seguro, não permitimos edição
        // de movimentações, pois isso exigiria recálculo do estoque.
        return redirect()
            ->route('stock-movements.index')
            ->with('error', 'Edição de movimentações não é permitida. Exclua e refaça, se necessário.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movement = StockMovement::findOrFail($id);
        $material = $movement->material;

        // Ao excluir, retornamos o estoque ao valor anterior da movimentação.
        if ($material) {
            $material->update([
                'current_stock' => $movement->previous_stock,
            ]);
        }

        $movement->delete();

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Movimentação excluída e estoque ajustado.');
    }
}
