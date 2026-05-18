<x-app-layout>
    <div class="div-principal-forms">

        {{-- ERROS --}}
        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('registro-gastos.store') }}">
            @csrf

            {{-- ================= DIA ================= --}}
            <div class="form-group">
                <x-input-label for="dia" :value="__('Data do gasto')" />

                <x-text-input
                    id="dia"
                    type="date"
                    name="dia"
                    :value="old('dia')"
                    required
                />
            </div>

            {{-- ================= TIPO DE GASTO ================= --}}
            <div class="form-group">
                <x-input-label for="tipo_gasto" :value="__('Tipo de gasto')" />

                <select name="tipo_gasto" id="tipo_gasto" class="input-text" required>
                    <option value="">Selecione</option>

                    <option value="manutencao" {{ old('tipo_gasto') == 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                    <option value="alimentacao" {{ old('tipo_gasto') == 'alimentacao' ? 'selected' : '' }}>Alimentação</option>
                    <option value="limpeza" {{ old('tipo_gasto') == 'limpeza' ? 'selected' : '' }}>Limpeza</option>
                    <option value="outros" {{ old('tipo_gasto') == 'outros' ? 'selected' : '' }}>Outros</option>

                </select>
            </div>

            {{-- ================= DESCRIÇÃO ================= --}}
            <div class="form-group">
                <x-input-label for="qual_gasto" :value="__('Descrição do gasto')" />

                <x-text-input
                    id="qual_gasto"
                    type="text"
                    name="qual_gasto"
                    :value="old('qual_gasto')"
                />
            </div>

            {{-- ================= VALOR ================= --}}
            <div class="form-group">
                <x-input-label for="valor" :value="__('Valor')" />

                <x-text-input
                    id="valor"
                    type="number"
                    step="0.01"
                    min="0"
                    name="valor"
                    :value="old('valor')"
                    required
                />
            </div>

            {{-- ================= FORMA PAGAMENTO ================= --}}
            <div class="form-group">
                <x-input-label for="forma_pagamento" :value="__('Forma de pagamento')" />

                <select name="forma_pagamento" id="forma_pagamento" class="input-text" required>
                    <option value="">Selecione</option>

                    <option value="avista" {{ old('forma_pagamento') == 'avista' ? 'selected' : '' }}>À vista</option>
                    <option value="parcelado" {{ old('forma_pagamento') == 'parcelado' ? 'selected' : '' }}>Parcelado</option>

                </select>
            </div>

            {{-- ================= TIPO PAGAMENTO ================= --}}
            <div class="form-group" id="pagamento_tipo_box" style="display:none;">
                <x-input-label for="pagamento_tipo" :value="__('Tipo de pagamento')" />

                <select name="pagamento_tipo" id="pagamento_tipo" class="input-text">
                    <option value="">Selecione</option>

                    <option value="debito" id='deb' {{ old('pagamento_tipo') == 'debito' ? 'selected' : '' }}>Débito</option>
                    <option value="credito" {{ old('pagamento_tipo') == 'credito' ? 'selected' : '' }}>Crédito</option>

                </select>
            </div>

            {{-- ================= PARCELAS ================= --}}
            <div class="form-group" id="parcelas_box" style="display:none;">
                <x-input-label for="parcelas" :value="__('Número de parcelas')" />

                <x-text-input
                    id="parcelas"
                    type="number"
                    min="1"
                    name="parcelas"
                    :value="old('parcelas')"
                />
            </div>

            {{-- ================= VENCIMENTO ================= --}}
            <div class="form-group" id="vencimento_box" style="display:none;">
                <x-input-label for="vencimento_parcelas" :value="__('Vencimento da primeira parcela')" />

                <x-text-input
                    id="vencimento_parcelas"
                    type="date"
                    name="vencimento_parcelas"
                    :value="old('vencimento_parcelas')"
                />
            </div>

            {{-- BOTÃO --}}
            <x-primary-button style="margin-top: 25px">
                {{ __('Salvar gasto') }}
            </x-primary-button>

        </form>

    </div>

    {{-- ================= JS ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const forma = document.getElementById('forma_pagamento');
            const tipoBox = document.getElementById('pagamento_tipo_box');
            const parcelasBox = document.getElementById('parcelas_box');
            const deb = document.querySelector('deb');
            const vencBox = document.getElementById('vencimento_box');
            function atualizar() {

                const valor = forma.value;

                tipoBox.style.display = valor ? 'block' : 'none';

                if (valor === 'parcelado') {
                    document.getElementById('deb').disabled = true;
                    parcelasBox.style.display = 'block';
                    vencBox.style.display = 'block';

                } else {
                    document.getElementById('deb').disabled = false;
                    parcelasBox.style.display = 'none';
                    vencBox.style.display = 'none';
                }
            }

            forma.addEventListener('change', atualizar);

            atualizar();
        });
    </script>

</x-app-layout>
