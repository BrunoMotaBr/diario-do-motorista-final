<x-app-layout>
    --status-ruim: #ff4d4d;       /* Vermelho vivo */
    --status-regular: #ffad33;    /* Laranja/Amarelo caloroso */
    --status-bom: #99cc33;        /* Verde claro/Lima */
    --status-otimo: #33cc33;
    @php
    $registro = $registrosTrabalho[0];

    $valor_total_dia = $registro->valor_uber + $registro->valor_99 + $registro->valor_indrive + $registro->valor_particular;
    $valor_livre = $valor_total_dia - $registro->total_combustivel;

    $porcentagem_ganhos_gas = ($valor_total_dia > 0) ? ($registro->total_combustivel / $valor_total_dia) * 100 : 0;
    $ganhos_por_KM_livre    = ($registro->km > 0) ? $valor_livre / $registro->km : 0;
    $ganhos_por_KM          = ($registro->km > 0) ? $valor_total_dia / $registro->km : 0;
    $desempenho_carro       = ($registro->litros > 0) ? $registro->km / $registro->litros : 0;
    $ganhos_por_litro       = ($registro->litros > 0) ? $valor_total_dia / $registro->litros : 0;
    $ganhos_por_hora_livre  = ($registro->horas_trabalhadas > 0) ? $valor_livre / $registro->horas_trabalhadas : 0;
    $ganhos_por_hora        = ($registro->horas_trabalhadas > 0) ? $valor_total_dia / $registro->horas_trabalhadas : 0;


    if ($valor_total_dia >= 450) { $status_total_dia = '--status-otimo'; }
    elseif ($valor_total_dia >= 300) { $status_total_dia = '--status-bom'; }
    elseif ($valor_total_dia >= 200) { $status_total_dia = '--status-regular'; }
    else { $status_total_dia = '--status-ruim'; }

    if ($valor_livre >= 300) { $status_valor_livre = '--status-otimo'; }
    elseif ($valor_livre >= 200) { $status_valor_livre = '--status-bom'; }
    elseif ($valor_livre >= 150) { $status_valor_livre = '--status-regular'; }
    else { $status_valor_livre = '--status-ruim'; }

    if ($porcentagem_ganhos_gas <= 25) { $status_gas = '--status-otimo'; }
    elseif ($porcentagem_ganhos_gas <= 33) { $status_gas = '--status-bom'; }
    elseif ($porcentagem_ganhos_gas <= 35) { $status_gas = '--status-regular'; }
    else { $status_gas = '--status-ruim'; }

    if ($ganhos_por_KM_livre >= 1.70) { $status_km_livre = '--status-otimo'; }
    elseif ($ganhos_por_KM_livre >= 1.50) { $status_km_livre = '--status-bom'; }
    elseif ($ganhos_por_KM_livre >= 1.30) { $status_km_livre = '--status-regular'; }
    else { $status_km_livre = '--status-ruim'; }

    if ($ganhos_por_KM >= 2.10) { $status_km = '--status-otimo'; }
    elseif ($ganhos_por_KM >= 1.70) { $status_km = '--status-bom'; }
    elseif ($ganhos_por_KM >= 1.60) { $status_km = '--status-regular'; }
    else { $status_km = '--status-ruim'; }

    if ($desempenho_carro >= 9) { $status_desempenho = '--status-otimo'; }
    elseif ($desempenho_carro >= 7.5) { $status_desempenho = '--status-bom'; }
    elseif ($desempenho_carro >= 7.0) { $status_desempenho = '--status-regular'; }
    else { $status_desempenho = '--status-ruim'; }

    if ($ganhos_por_litro >= 12) { $status_ganho_litro = '--status-otimo'; }
    elseif ($ganhos_por_litro >= 10) { $status_ganho_litro = '--status-bom'; }
    elseif ($ganhos_por_litro >= 9.5) { $status_ganho_litro = '--status-regular'; }
    else { $status_ganho_litro = '--status-ruim'; }

    if ($ganhos_por_hora_livre >= 37) { $status_hora_livre = '--status-otimo'; }
    elseif ($ganhos_por_hora_livre >= 34) { $status_hora_livre = '--status-bom'; }
    elseif ($ganhos_por_hora_livre >= 30) { $status_hora_livre = '--status-regular'; }
    else { $status_hora_livre = '--status-ruim'; }

    if ($ganhos_por_hora >= 50) { $status_hora = '--status-otimo'; } // Ajustado para ótimo/bom conforme sua regra limite de 50
    elseif ($ganhos_por_hora >= 45) { $status_hora = '--status-bom'; }
    elseif ($ganhos_por_hora >= 33) { $status_hora = '--status-regular'; }
    else { $status_hora = '--status-ruim'; }

    @endphp
    <h1 style="color:white">Resulmo do dia {{$dataSelecionadaBR}}
    </h1>
    <div style="display: flex; gap: 50px; ">
        <a href="{{ route('registro.create')}}">
            <div class="div-cards resulmo-dia">
                <div class="card-wrapper"> <!--platform-99 platform-indrive platform-particular !-->
                    <div class="platform-card platform-uber">
                        <div class="card-badge">Uber</div>
                        <div class="card-body">
                            <div class="card-value">
                                <span>R$ {{$registro->valor_uber}}</span>
                            </div>
                            <div class="card-km"></div>
                        </div>
                    </div>
                </div>
                <div class="card-wrapper"> <!--platform-99 platform-indrive platform-particular !-->
                    <div class="platform-card platform-99">
                        <div class="card-badge">99</div>
                        <div class="card-body">
                            <div class="card-value">
                                <span>R$ {{$registro->valor_99}}</span>
                            </div>
                            <div class="card-km"></div>
                        </div>
                    </div>
                </div>
                <div class="card-wrapper"> <!--platform-99 platform-indrive platform-particular !-->
                    <div class="platform-card platform-indrive">
                        <div class="card-badge">InDriver</div>
                        <div class="card-body">
                            <div class="card-value">
                                <span>R$ {{$registro->valor_indrive}}</span>
                            </div>
                            <div class="card-km"></div>
                        </div>
                    </div>
                </div>
                <div class="card-wrapper"> <!--platform-99 platform-indrive platform-particular !-->
                    <div class="platform-card platform-particular">
                        <div class="card-badge">Particular</div>
                        <div class="card-body">
                            <div class="card-value">
                                <span>R$ {{$registro->valor_particular}}</span>
                            </div>
                            <div class="card-km"></div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <span style="border-left: #2c3e50 solid 2px"></span>
        <div style="background-color: white; width: 80%; text-align: center">
            valor_total_dia:{{number_format($valor_total_dia, 2, ',', '.')}} / <br>
            valor_livre:{{number_format($valor_livre, 2, ',', '.')}} / <br>
            porcentagem_ganhos_gas:{{number_format($porcentagem_ganhos_gas, 2, ',', '.')}} / <br>
            ganhos_por_KM_livre:{{number_format($ganhos_por_KM_livre, 2, ',', '.')}} / <br>
            ganhos_por_KM:{{number_format($ganhos_por_KM, 2, ',', '.')}} / <br>
            desempenho_carro:{{number_format($desempenho_carro, 2, ',', '.')}} / <br>
            ganhos_por_litro:{{number_format($ganhos_por_litro, 2, ',', '.')}} / <br>
            ganhos_por_hora_livre:{{number_format($ganhos_por_hora_livre, 2, ',', '.')}} / <br>
            ganhos_por_hora:{{number_format($ganhos_por_hora, 2, ',', '.')}} /
        </div>
    </div>


    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Tipo de gasto</th>
                    <th>Qual gasto</th>
                    <th>Valor</th>
                    <th>Forma de pagamento</th>
                    <th>Tipo de pagamento</th>
                    <th>Parcelas</th>
                    <th>Vencimento da parcela</th>
                    <th>Início da parcela</th>
                    <th>Fim da parcela</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registrosGasto as $gasto)
                    <tr>
                        <td>{{ $gasto->tipo_gasto }}</td>
                        <td><strong>{{ $gasto->qual_gasto }}</strong></td>
                        <td class="text-right text-bold">R$ {{ number_format($gasto->valor, 2, ',', '.') }}</td>
                        <td>{{ $gasto->forma_pagamento }}</td>
                        <td>{{ $gasto->pagamento_tipo }}</td>

                        @if ($gasto->parcelas != null)
                            <td>{{ $gasto->parcelas }}x  R$ {{number_format($gasto->valor / $gasto->parcelas, 2, ',', '.') }}</td>
                        @else
                            <td><span class="badge">À vista</span></td>
                        @endif

                        @if ($gasto->vencimento_parcelas != null)
                            <td>{{ $gasto->vencimento_parcelas }}</td>
                        @else
                            <td><span class="badge">À vista</span></td>
                        @endif

                        @if ($gasto->inicio_parcela != null)
                            <td>{{ $gasto->inicio_parcela }}</td>
                        @else
                            <td><span class="badge">À vista</span></td>
                        @endif

                        @if ($gasto->inicio_parcela != null)
                            <td>{{ date('Y-m-d', strtotime('+' . ((int)$gasto->parcelas - 1) . ' month', strtotime($gasto->inicio_parcela))) }}</td>
                        @else
                            <td><span class="badge">À vista</span></td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center no-data">Nenhum gasto encontrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</x-app-layout>

<style>
    .table-container {
        width: 100%;
        overflow-x: auto; /* Garante a responsividade em telas menores */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        margin: 20px 0;
        background-color: #ffffff;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        text-align: left;
        color: #333333;
        min-width: 1000px; /* Impede que os dados fiquem espremidos no mobile */
    }

    /* Cabeçalho */
    .custom-table thead tr {
        background-color: #2c3e50;
        color: #ffffff;
        font-weight: 600;
    }

    .custom-table th {
        padding: 14px 16px;
        white-space: nowrap;
    }

    /* Linhas e Células */
    .custom-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s;
    }

    .custom-table tbody tr:hover {
        background-color: #f8fafc; /* Efeito de destaque ao passar o mouse */
    }

    .custom-table tbody tr:nth-of-type(even) {
        background-color: #f1f5f9; /* Linhas alternadas */
    }

    .custom-table tbody tr:nth-of-type(even):hover {
        background-color: #e2e8f0;
    }

    .custom-table td {
        padding: 12px 16px;
        vertical-align: middle;
    }

    /* Alinhamentos e Destaques */
    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .text-bold {
        font-weight: bold;
        color: #2e7d32; /* Cor verde discreta para o valor financeiro */
    }

    .no-data {
        color: #718096;
        padding: 30px !important;
        font-style: italic;
    }

    /* Badge para "À vista" */
    .badge {
        background-color: #edf2f7;
        color: #4a5568;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
</style>
