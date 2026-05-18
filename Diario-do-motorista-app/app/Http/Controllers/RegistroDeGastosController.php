<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistroDeGastos;

class RegistroDeGastosController extends Controller
{
    public function create()
    {
        return view('registro-gastos.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'tipo_gasto' => 'required|string|max:255',

            'qual_gasto' => 'nullable|string|max:255',

            'valor' => 'required|numeric',

            'forma_pagamento' => 'required|string',

            'pagamento_tipo' => 'nullable|string',

            'parcelas' => 'nullable|integer',

            'vencimento_parcelas' => 'nullable|date',

            'inicio_parcela' => 'nullable|date',

            'dia' => 'required|date'
        ]);

        RegistroDeGastos::create([
            'user_id' => Auth::id(),
            'tipo_gasto' => $request->tipo_gasto,
            'qual_gasto' => $request->qual_gasto,
            'valor' => $request->valor,
            'forma_pagamento' => $request->forma_pagamento,
            'pagamento_tipo' => $request->pagamento_tipo,
            'parcelas' => $request->parcelas,
            'vencimento_parcelas' => $request->vencimento_parcelas,
            'inicio_parcela' => $request->vencimento_parcelas,
            'dia' => $request->dia
        ]);

        return redirect()
            ->back()
            ->with('success', 'Gasto registrado com sucesso!');
    }
}
