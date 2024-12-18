<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stocks = Stock::orderBy('created_at', 'desc')
            ->orderBy('expiry_date', 'asc')
            ->orderBy('quantity', 'asc')
            ->orderBy('unit_price', 'asc')
            ->paginate(10);
        return view('layouts.manageStock.adminStockList', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.manageStock.adminStockAddForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'expiry_date' => 'required|date',
            'sku' => 'required|string|max:50|unique:stocks',
            'min_quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'unit_type' => 'required|string|max:50',
            'active' => 'boolean'
        ]);

        Stock::create($validated);

        return redirect()->route('manageStock.index')
            ->with('success', 'Stock created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return view('layouts.manageStock.adminStockEditForm', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'expiry_date' => 'required|date',
            'sku' => 'required|string|max:50|unique:stocks,sku,' . $id,
            'min_quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'unit_type' => 'required|string|max:50',
            'active' => 'boolean'
        ]);

        $stock->update($validated);

        return redirect()->route('manageStock.index')
            ->with('success', 'Stock updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('manageStock.index')
            ->with('success', 'Stock deleted successfully.');
    }
}