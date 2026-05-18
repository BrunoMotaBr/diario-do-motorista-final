<?php

namespace App\Http\Controllers;

use App\Models\RegistroDeGastos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistroTrabalho;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $dataBase = $request->filled('dia')
            ? Carbon::parse($request->dia)
            : Carbon::now();

        $registro = RegistroTrabalho::where('user_id', $userId)
            ->when($request->filled('dia'), function ($query) use ($request) {
                $query->whereDate('dia', $request->dia);
            }, function ($query) {
                $query->latest('dia');
            })
            ->first();

        $dados = [
            'dia' => $registro->dia ?? null,
            'uber' => $registro->valor_uber ?? 0,
            'nove_nove' => $registro->valor_99 ?? 0,
            'indrive' => $registro->valor_indrive ?? 0,
            'particular' => $registro->valor_particular ?? 0,
            'km' => $registro->km ?? 0,
            'litros' => $registro->litros ?? 0,
            'valor_por_litro' => $registro->valor_por_litro ?? 0,
            'total_combustivel' => $registro->total_combustivel ?? 0,
            'horas_trabalhadas' => $registro->horas_trabalhadas ?? 0,
        ];

        $combustivelDia = RegistroTrabalho::where('user_id', $userId)
            ->whereDate('dia', $dataBase->toDateString())
            ->sum('total_combustivel');

        $inicioSemana = $dataBase->copy()->startOfWeek(Carbon::MONDAY);
        $fimSemana = $dataBase->copy()->endOfWeek(Carbon::SUNDAY);

        $combustivelSemanaSoma = RegistroTrabalho::where('user_id', $userId)
            ->whereBetween('dia', [$inicioSemana, $fimSemana])
            ->sum('total_combustivel');

        $registrosSemana = RegistroTrabalho::where('user_id', $userId)
            ->whereBetween('dia', [$inicioSemana, $fimSemana])
            ->get()
            ->groupBy(fn ($item) => Carbon::parse($item->dia)->format('Y-m-d'));

        $diasSemana = [];
        $valoresSemana = [];
        $combustivelSemana = [];
        $lucroSemana = [];

        for ($i = 0; $i < 7; $i++) {
            $dia = $inicioSemana->copy()->addDays($i)->format('Y-m-d');

            $totalDia = $registrosSemana[$dia] ?? collect();

            $soma = $totalDia->sum(fn ($r) =>
                $r->valor_uber +
                $r->valor_99 +
                $r->valor_indrive +
                $r->valor_particular
            );

            $somaCombustivel = $totalDia->sum(fn ($r) => $r->total_combustivel ?? 0);


            $lucroLiquido = $soma - $somaCombustivel;

            $diasSemana[] = Carbon::parse($dia)->format('d/m');
            $valoresSemana[] = $soma;
            $combustivelSemana[] = $somaCombustivel;
            $lucroSemana[] = $lucroLiquido;
        }

        $combustivelMes = RegistroTrabalho::where('user_id', $userId)
            ->whereBetween('dia', [
                $dataBase->copy()->startOfMonth(),
                $dataBase->copy()->endOfMonth()
            ])
            ->sum('total_combustivel');

        $mes = RegistroTrabalho::where('user_id', $userId)
            ->whereBetween('dia', [
                $dataBase->copy()->startOfMonth(),
                $dataBase->copy()->endOfMonth()
            ])
            ->selectRaw('
                SUM(valor_uber) as uber,
                SUM(valor_99) as nove_nove,
                SUM(valor_indrive) as indrive,
                SUM(valor_particular) as particular
            ')
            ->first();

        $inicioMes = $dataBase->copy()->startOfMonth();
        $fimMes = $dataBase->copy()->endOfMonth();

        // =========================
        // GASTOS (COM PARCELA CORRETA)
        // =========================
        $gastos = RegistroDeGastos::where('user_id', $userId)
            ->get()
            ->map(function ($gasto) use ($inicioMes) {

                if ($gasto->forma_pagamento === 'parcelado') {

                    if (!$gasto->inicio_parcela || !$gasto->parcelas) {
                        return null;
                    }

                    $inicio = Carbon::parse($gasto->inicio_parcela);

                    $mesInicio = $inicio->format('Y-m');
                    $mesAtual = $inicioMes->format('Y-m');

                    $inicioDate = Carbon::createFromFormat('Y-m', $mesInicio);
                    $atualDate = Carbon::createFromFormat('Y-m', $mesAtual);

                    $mesesDecorridos = $inicioDate->diffInMonths($atualDate, false);
                    if ($mesesDecorridos < 0 || $mesesDecorridos >= $gasto->parcelas) {
                        return null;
                    }else if ($inicioDate == $atualDate){
                        return $gasto;
                    }else{
                        $gasto->vencimento_parcelas = date('Y-m-d', strtotime('+1 month', strtotime($gasto->vencimento_parcelas)));
                        $gasto->save();
                    }
                    $gasto->parcela_atual = $mesesDecorridos + 1;

                    return $gasto;
                }else{

                    $inicio = Carbon::parse($gasto->dia);
                    $mesInicio = $inicio->format('Y-m');
                    $mesAtual = $inicioMes->format('Y-m');

                    if($mesInicio < $mesAtual){
                        return null;
                    }
                    return $gasto;
                }
            })
            ->filter()
            ->values();

        // =========================
        // RESUMO DO MÊS
        // =========================
        $mesGastos = [
            'total_gastos' => $gastos->sum('valor'),
            'manutencao' => $gastos->where('tipo_gasto', 'manutencao')->sum('valor'),
            'alimentacao' => $gastos->where('tipo_gasto', 'alimentacao')->sum('valor'),
            'limpeza' => $gastos->where('tipo_gasto', 'limpeza')->sum('valor'),
            'outros' => $gastos->where('tipo_gasto', 'outros')->sum('valor'),
        ];

        $grafico = [
            'labels' => ['Uber', '99', 'InDrive', 'Particular'],
            'valores' => [
                $dados['uber'],
                $dados['nove_nove'],
                $dados['indrive'],
                $dados['particular']
            ]
        ];

        $graficoSemana = [
            'diasSemana' => $diasSemana,
            'labels' => ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'],
            'valores' => $valoresSemana
        ];

        $livre_sem = 0;
        $bruto_sem = 0;

        foreach ($lucroSemana as $item){
            $livre_sem += $item;
        }

        foreach ($valoresSemana as $item){
            $bruto_sem += $item;
        }


        return view('dashboard', compact(
            'dados',
            'grafico',
            'graficoSemana',
            'mes',
            'mesGastos',
            'gastos',
            'combustivelDia',
            'combustivelSemanaSoma',
            'combustivelMes',
            'combustivelSemana',
            'livre_sem',
            'bruto_sem',
            'lucroSemana'
        ));
    }
}
