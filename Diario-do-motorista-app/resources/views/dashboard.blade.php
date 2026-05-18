<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<x-app-layout>
    <div class="principal-div-dashbord">
        <div class="principal-card-div">
            <form method="GET" action="{{ route('dashboard') }}">

                <x-text-input
                    type="date"
                    id="dia"
                    name="dia"
                    value="{{ request('dia') }}"
                    style="width: 100%"
                />

                <x-primary-button style="margin-top: 25px; width: 100%">
                    {{ __('Filtrar dia') }}
                </x-primary-button>

            </form>
            <h3 class="data">{{

                    $dados['dia']
                        ? \Carbon\Carbon::parse($dados['dia'])->format('d/m/Y')
                        : (request('dia')
                        ? \Carbon\Carbon::parse(request('dia'))->format('d/m/Y')
                        : 'Data')

                }}

            </h3>
            <a href="{{ route('registro.create')}}">
                <div class="div-cards">
                    <div class="card-wrapper"> <!--platform-99 platform-indrive platform-particular !-->
                        <div class="platform-card platform-uber">
                            <div class="card-badge">Uber</div>
                            <div class="card-body">
                                <div class="card-value">
                                    <span>R$ {{ number_format($dados['uber'], 2, ',', '.') }}</span>
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
                                    <span>R$ {{ number_format($dados['nove_nove'], 2, ',', '.') }}</span>
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
                                    <span>R$ {{ number_format($dados['indrive'], 2, ',', '.') }}</span>
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
                                    <span>R$ {{ number_format($dados['particular'], 2, ',', '.') }}</span>
                                </div>
                                <div class="card-km"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <div style="display: flex; gap: 50px">
                <h3 class="combustivel">
                    Gás: R$
                    {{number_format($dados['total_combustivel'], 2, ',', '.')}}
                </h3>
                <h3 class="livre-dia">
                    Liquido Dia: R$
                    {{number_format(($dados['uber'] + $dados['nove_nove'] + $dados['indrive'] + $dados['particular']) - $combustivelDia, 2, ',', '.')}}
                </h3>
            </div>

        </div>

        <div style="text-align: center">
            <div style="display: flex;justify-content: space-around; align-items: center; margin-block: 15px">
                <h3 id="total-mes-gas" class='livre-dia'>Total gas mês: {{$combustivelMes}}</h3>
                <h3 id="total-mes-livre" class='livre-dia'>Livre mês: </h3>
            </div>

            <div id="chart">
            </div>
        </div>
        <div style="text-align: center">
            <div>
                <h3 class='livre-dia'>Total gas semana: {{$combustivelSemanaSoma}}</h3>
                <h3 class='livre-dia'>Livre semana: {{$livre_sem}}</h3>
                <h3 class='data'>Bruto semana: {{$bruto_sem}}</h3>
            </div>
            <div id="chart-semana"></div>
        </div>
    </div>

    <div class="card">

        <h2>💰 Gastos do Mês</h2>

        <table class="table-auto w-full text-left">

            <thead>
                <tr>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Pagamento</th>
                    <th>Parcela</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($gastos as $gasto)

                    <tr>

                        {{-- DATA --}}
                        <td>
                            {{ \Carbon\Carbon::parse($gasto->dia)->format('d/m/Y') }}
                        </td>

                        {{-- TIPO --}}
                        <td>
                            {{ ucfirst($gasto->tipo_gasto) }}
                        </td>

                        {{-- DESCRIÇÃO --}}
                        <td>
                            {{ $gasto->qual_gasto ?? '-' }}
                        </td>

                        {{-- VALOR --}}
                        <td>
                            R$ {{ number_format($gasto->valor, 2, ',', '.') }}
                        </td>

                        {{-- PAGAMENTO --}}
                        <td>
                            {{ ucfirst($gasto->forma_pagamento) }}

                            @if($gasto->forma_pagamento === 'parcelado')
                                ({{ $gasto->pagamento_tipo }}) ==
                                ({{  \Carbon\Carbon::parse($gasto->vencimento_parcelas)->format('d/m/Y') }})
                            @endif
                        </td>

                        {{-- PARCELAS --}}
                        <td>
                            @if($gasto->forma_pagamento === 'parcelado')

                                {{-- STATUS VISUAL --}}
                                <small>
                                    {{$gasto->parcela_atual}} / {{$gasto->parcelas}}
                                </small>

                            @else
                                À vista
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6">Nenhum gasto encontrado</td>
                    </tr>

                @endforelse

            </tbody>

        </table>



    </div>
</x-app-layout>

<script>

    let chart = null;
    document.addEventListener('DOMContentLoaded', () => {

        document.querySelector("#chart").innerHTML = '';
        document.querySelector("#chart-semana").innerHTML = '';

        renderizarGrafico();
        renderizarGraficoSemana();

    });

    function renderizarGrafico(){

        let uber_valor = {{ $mes->uber ?? 0 }};
        let nove_nove_valor = {{ $mes->nove_nove ?? 0 }};
        let indrive_valor = {{ $mes->indrive ?? 0 }};
        let particular_valor = {{ $mes->particular ?? 0 }};

        let dataMês = document.querySelector('.data').innerText.split('/')[1];

        switch(dataMês){
            case '01':
                dataMês = 'Janeiro'
                break;
            case '02':
                dataMês = 'Fevereiro'
                break;
            case '03':
                dataMês = 'Março'
                break;
            case '04':
                dataMês = 'Abril'
                break;
            case '05':
                dataMês = 'Maio'
                break;
            case '06':
                dataMês = 'Junho'
                break;
            case '07':
                dataMês = 'Julho'
                break;
            case '08':
                dataMês = 'Agosto'
                break;
            case '09':
                dataMês = 'Setembro'
                break;
            case '10':
                dataMês = 'Outubro'
                break;
            case '11':
                dataMês = 'Novembro'
                break;
            case '12':
                dataMês = 'Dezembro'
                break;
            default:
                dataMês = 'N/A'
                break;
        }



        const total =
            parseFloat(uber_valor) +
            parseFloat(nove_nove_valor) +
            parseFloat(indrive_valor) +
            parseFloat(particular_valor);
        const combustivel_mes = {{ $combustivelMes }};
        const livre_mes = total - parseFloat(combustivel_mes);
        document.querySelector('#total-mes-livre').innerHTML += livre_mes.toFixed(2);

        // ============================================
        // CONFIGURAÇÕES PRINCIPAIS DO GRÁFICO
        var options = {

            // ============================================
            // COR PRINCIPAL DO RADAR
            // ============================================
            // Essa cor controla:
            // - linha principal
            // - preenchimento interno
            // - animação do radar
            // ============================================

            colors: ['#FFD600'],

            // ============================================
            // CONFIGURAÇÕES GERAIS DO CHART
            // ============================================

            chart: {

                // TIPO DO GRÁFICO
                type: 'radar',

                // ALTURA
                height: 450,

                // LARGURA
                width: 500,

                // FUNDO TRANSPARENTE
                background: 'transparent',

                // REMOVE TOOLBAR NATIVA
                toolbar: {
                    show: true
                },

                // DESATIVA ZOOM
                zoom: {
                    enabled: false
                },

                // SOMBRA SUAVE
                dropShadow: {
                    enabled: true,
                    blur: 6,
                    opacity: 0.35
                }
            },

            // ============================================
            // DADOS DO GRÁFICO
            // ============================================

            series: [{

                // NOME DA SÉRIE
                name: 'Ganhos R$',

                // VALORES
                data: [
                    uber_valor,
                    nove_nove_valor,
                    indrive_valor,
                    particular_valor
                ]
            }],

            // ============================================
            // TÍTULO
            // ============================================

            title: {

                text: 'Ganhos do Mês de ' + dataMês + ' : R$' + total,

                align: 'center',

                style: {
                    color: '#F1F5F9',
                    fontSize: '18px',
                    fontWeight: 700
                }
            },

            // ============================================
            // NOMES DAS PLATAFORMAS
            // ============================================

            xaxis: {

                // NOMES AO REDOR DO RADAR
                categories: [
                    'Uber',
                    ' 99 ',
                    'InDr',
                    'Part'
                ],

                labels: {

                    show: true,

                    style: {

                        // COR DO TEXTO
                        colors: [
                            '#FFFFFF',
                            '#FFFFFF',
                            '#FFFFFF',
                            '#FFFFFF'
                        ],

                        // TAMANHO
                        fontSize: '14px',

                        // PESO
                        fontWeight: 700
                    }
                }
            },

            // ============================================
            // VALORES LATERAIS
            // ============================================

            yaxis: {

                show: true,

                labels: {

                    style: {
                        colors: '#94A3B8',
                        fontSize: '12px'
                    }
                }
            },

            // ============================================
            // REMOVE LEGENDA
            // ============================================

            legend: {
                show: false
            },

            // ============================================
            // NÚMEROS NOS PONTOS
            // ============================================

            dataLabels: {

                enabled: true,

                background: {

                    enabled: true,

                    borderRadius: 6,

                    foreColor: '#fff',

                    padding: 6,

                    opacity: 0.9
                },

                style: {
                    colors: ['#050505'],
                    fontSize: '12px',
                    fontWeight: 700
                }
            },

            // ============================================
            // LINHA DO RADAR
            // ============================================

            stroke: {

                width: 3,

                curve: 'smooth'
            },

            // ============================================
            // PREENCHIMENTO INTERNO
            // ============================================

            fill: {

                opacity: 0.35,

                colors: ['#FFD600']
            },

            // ============================================
            // BOLINHAS DOS PONTOS
            // ============================================

            markers: {

                size: 6,

                strokeColors: '#FFFFFF',

                strokeWidth: 2,

                hover: {
                    size: 9
                },

                // CORES INDIVIDUAIS DOS PONTOS
                discrete: [

                    {
                        seriesIndex: 0,
                        dataPointIndex: 0,
                        fillColor: '#000000',
                        strokeColor: '#FFFFFF',
                        size: 6
                    },

                    {
                        seriesIndex: 0,
                        dataPointIndex: 1,
                        fillColor: '#FFD600',
                        strokeColor: '#FFFFFF',
                        size: 6
                    },

                    {
                        seriesIndex: 0,
                        dataPointIndex: 2,
                        fillColor: '#1DB954',
                        strokeColor: '#FFFFFF',
                        size: 6
                    },

                    {
                        seriesIndex: 0,
                        dataPointIndex: 3,
                        fillColor: '#F97316',
                        strokeColor: '#FFFFFF',
                        size: 6
                    }

                ]
            },

            // ============================================
            // FUNDO HEXAGONAL DO RADAR
            // ============================================

            plotOptions: {

                radar: {

                    polygons: {

                        // LINHAS DO HEXÁGONO
                        strokeColors: '#334155',

                        // LINHAS INTERNAS
                        connectorColors: '#334155',

                        // FUNDO INTERCALADO
                        fill: {

                            colors: [
                                '#0F172A',
                                '#111827'
                            ]
                        }
                    }
                }
            },

            // ============================================
            // TOOLTIP
            // ============================================

            tooltip: {

                theme: 'dark',

                style: {
                    fontSize: '14px'
                }
            },

            // ============================================
            // REMOVE GRID
            // ============================================

            grid: {
                show: false
            },

            // ============================================
            // RESPONSIVIDADE
            // ============================================

            responsive: [{

                breakpoint: 768,

                options: {

                    chart: {

                        height: 320,

                        width: '100%'
                    },
                    title: {

                        style: {
                            fontSize: '12px',
                        }
                    }
                }
            }]
        }


        // ============================================
        // CRIA O CHART
        // ============================================

        chart = new ApexCharts(
            document.querySelector("#chart"),
            options
        );


        // ============================================
        // RENDERIZA
        // ============================================

        chart.render();


        // ============================================
        // CORES PERSONALIZADAS NOS NOMES DAS PLATAFORMAS
        // ============================================

        setTimeout(() => {

            const labels = document.querySelectorAll(
                '.apexcharts-xaxis text'
            );

            const cores = [
                '#000000',
                '#FFD600',
                '#1DB954',
                '#F97316'
            ];

            const coresTexto = [
                '#FFFFFF',
                '#000',
                '#000',
                '#FFFFFF'
            ]

            labels.forEach((label, index) => {

                if (!label) return;

                const bbox = label.getBBox();

                // ============================================
                // CRIA UM "QUADRADO" (RECT) ATRÁS DO TEXTO
                // ============================================
                const rect = document.createElementNS(
                    "http://www.w3.org/2000/svg",
                    "rect"
                );

                rect.setAttribute("x", bbox.x - 16);
                rect.setAttribute("y", bbox.y - 4);
                rect.setAttribute("width", bbox.width + 24);
                rect.setAttribute("height", bbox.height + 8);

                rect.setAttribute("fill", cores[index]);
                rect.setAttribute("rx", "6");
                rect.setAttribute("ry", "6");

                // ============================================
                // INSERE O RECT NO MESMO PAI DO TEXTO
                // ============================================
                label.parentNode.insertBefore(rect, label);

                // ============================================
                // ESTILO DO TEXTO
                // ============================================
                label.style.fill = coresTexto[index];
                label.style.fontWeight = "700";

            });

        }, 500);
    }

    function renderizarGraficoSemana(){
        let uber_valor = {{ $graficoSemana['valores'][0]}};
        let nove_nove_valor = {{ $graficoSemana['valores'][1] }};
        let indrive_valor = {{ $graficoSemana['valores'][2] }};
        let particular_valor = {{ $graficoSemana['valores'][3] }};

        const ano = document.querySelector('.data').innerText.split('/')[2];
        var optionsSemana = {
            chart: {
                type: 'bar',
                height: 450,
                width: 500,
                stacked: true,
                toolbar: { show: true },
                events: {
                    dataPointSelection: function(event, chatContext, config){

                        const index = config.dataPointIndex;
                        const diaIndex = @json($graficoSemana['diasSemana']);
                        const urlBase = "{{ url('/registro/detalhe', ['data' => '']) }}";
                        window.location.href = `${urlBase}?data=${diaIndex[index]}/${ano}`;
                    }
                }
            },

            series: [{
                name: 'Ganhos Dia',
                data: @json(array_values($lucroSemana))
            },
            {
                name: 'Combustivel',
                data: @json(array_values($combustivelSemana))
            }],
            title: {

                text:  `${@json($graficoSemana['diasSemana'][0])} <---------> ${@json($graficoSemana['diasSemana'][6])}`,

                align: 'center',

                style: {
                    color: '#F1F5F9',
                    fontSize: '18px',
                    fontWeight: 700
                }
            },
            legend: {
                labels: {
                    colors: '#FFF' // Substitua por '#fff' ou a cor clara que preferir
                }
            },

            xaxis: {
                categories: @json($graficoSemana['labels']),
                labels: {
                    style: {
                        colors: '#F1F5F9',
                        fontSize: '12px',
                        cssClass: 'apexcharts-xaxis-label-clean'
                    }
                }
            },

            colors: ['#1DB954','#C0421B'],

            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '45%',
                    dataLabels: {
                        total: {
                            enabled: true,
                            style: {
                                color: '#F1F5F9',
                                fontWeight: 700
                            }
                        }
                    }
                }
            },

            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#fff']
                },
                formatter: function (val) {
                    return val.toFixed(2);
                }
            },

            grid: {
                borderColor: '#334155'
            },

            yaxis: {
                labels: {
                    style: {
                        colors: '#94A3B8'
                    },
                    formatter: function (val) {
                        return val.toFixed(2);
                    }
                }

            },

            tooltip: {
                theme: 'dark'
            },

            responsive: [
                {
                    breakpoint: 768,
                    options: {
                        chart: {
                            height: 300,
                            width: '100%'
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: '#F1F5F9',
                                    fontSize: '8px'
                                }
                            }
                        },
                        title: {
                            style:{
                                fontSize: '10px'
                            }
                        }

                    }

                    }
            ]
        };

        var chartSemana = new ApexCharts(
            document.querySelector("#chart-semana"),
            optionsSemana
        );

        chartSemana.render();
    }

</script>

<style>
    .apexcharts-xaxis-label-clean {
        text-shadow: none !important;
        background: transparent !important;
        fill: #F1F5F9 !important;
    }

    .apexcharts-bar-area {
        cursor: pointer !important;
    }

    .card{
        background-color: var(--text-secondary);
        text-align: center;
        margin: 12px 24px;
        table,tr,th,td,tbody,thead{
            border: 2px solid black;
            text-align: center;
        }
    }

    .card h2{
            font-size: 24px;
            font-weight: 700;
        }
    .principal-div-dashbord{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        width: 100%;
        overflow: hidden;
        margin-top: 25px
    }
    .principal-card-div{
        width: 30%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 0 15px;
        flex-wrap: wrap;
        gap: 25px;
        form{
            margin-top: 15px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    }
    .data{
        color: var(--text-black);
        font-weight: 700;
        background-color: var(--secondary);
        padding:2px 10px;
        border-radius: 16px;
    }
    .combustivel{
        color: var(--text-primary);
        background-color: #c2410c;
        font-weight: 700;
        padding:2px 10px;
        border-radius: 16px;
    }
    .livre-dia{
        color: var(--text-primary);
        background-color: var(--text-muted);
        font-weight: 700;
        padding:2px 10px;
        border-radius: 16px;
    }

    @media screen and (max-width: 699px){
        .principal-card-div{
            width:100%;
        }
        .principal-div-dashbord{
            justify-content: center
        }
    }

</style>
