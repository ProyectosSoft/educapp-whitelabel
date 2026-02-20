<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'moneda_id' => 'required|exists:monedas,id',
            'dctoMin' => 'required|numeric|min:0',
            'dctoMax' => 'required|numeric|min:0',
        ]);

        $price = Price::create([
            'nombre' => $request->name,
            'valor' => $request->value,
            'dctoMin' => $request->dctoMin,
            'dctoMax' => $request->dctoMax,
            'moneda_id' => $request->moneda_id,
            'estado' => 1,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'id' => $price->id,
            'name' => $price->nombre,
            'value' => $price->valor
        ]);
    }
}
