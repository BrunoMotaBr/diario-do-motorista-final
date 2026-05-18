<?php

namespace App\Http\Controllers;

use App\Models\RegistroDeGastos;
use App\Models\RegistroTrabalho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroTrabalhoController extends Controller
{

    public function create()
    {
        return view('registro.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dia' => 'required|date',

            'valor_uber' => 'required|numeric|min:0',
            'valor_99' => 'required|numeric|min:0',
            'valor_indrive' => 'required|numeric|min:0',
            'valor_particular' => 'required|numeric|min:0',

            'km' => 'required|integer|min:0',

            'litros' => 'required|numeric|min:0',

            'valor_por_litro' => 'required|numeric|min:0',

            'horas_trabalhadas' => 'required|integer|min:0',
        ]);

        $totalCombustivel = $request->litros * $request->valor_por_litro;
        $userId = Auth::id();
        RegistroTrabalho::create([

            'user_id' => $userId,

            'dia' => $request->dia,

            'valor_uber' => $request->valor_uber,
            'valor_99' => $request->valor_99,
            'valor_indrive' => $request->valor_indrive,
            'valor_particular' => $request->valor_particular,

            'km' => $request->km,

            'litros' => $request->litros,

            'valor_por_litro' => $request->valor_por_litro,

            'total_combustivel' => $totalCombustivel,

            'horas_trabalhadas' => $request->horas_trabalhadas,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Registro salvo com sucesso!');
    }

    public function show(Request $request)
    {

        $dataSelecionada = $request->query('data');
        $dataSelecionadaBR = $request->query('data');

        $dataSelecionada = explode('/', $dataSelecionada);
        $dataSelecionada = $dataSelecionada[2] . '-' . $dataSelecionada[1] . '-' . $dataSelecionada[0];
        $userId = Auth::id();

        $registrosTrabalho = null;
        $registrosGasto = null;
        if ($dataSelecionada) {
            $registrosTrabalho = RegistroTrabalho::where('user_id', $userId)
                ->whereDate('dia', $dataSelecionada)->get();
            $registrosGasto = RegistroDeGastos::where('user_id', $userId)
                ->whereDate('dia', $dataSelecionada)->get();
        }

        return view('registro.show', compact('dataSelecionadaBR' ,'registrosTrabalho', 'registrosGasto'));
    }
}
