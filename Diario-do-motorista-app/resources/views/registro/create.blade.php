<x-app-layout>
    <div class="div-principal-forms">
        @if ($errors->any())
            <div>

                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

            </div>
        @endif
        <form method="POST" action="{{ route('registro.store') }}">
            @csrf

            <x-input-label for="dia" :value="__('Dia')" />
            <x-text-input
                id="dia"
                type="date"
                name="dia"
                :value="old('dia')"
                required/>
            <section>
                <div>

                    <x-input-label  :value="__('Plataforma')" />
                    <h3 class="plataform-name">Uber</h3>


                    <x-input-label for="valor_uber" :value="__('Valor do dia')" />
                    <x-text-input
                        id="valor_uber"
                        placeholder="0.00"
                        type="number"
                        step="0.01"
                        min='0'
                        name="valor_uber"
                        :value="old('valor_uber')"
                        required autofocus/>
                        @error('valor_uber')
                            <span>{{ $message }}</span>
                        @enderror
                </div>

                <div>
                    <x-input-label  :value="__('Plataforma')" />
                    <h3 class='plataform-name'>99</h3>

                    <x-input-label for="valor_99" :value="__('Valor do dia')" />
                    <x-text-input
                        id="valor_99"
                        placeholder="0.00"
                        type="number"
                        step="0.01"
                        min='0'
                        name="valor_99"
                        :value="old('valor_99')"
                        required/>

                        @error('valor_99')
                            <span>{{ $message }}</span>
                        @enderror
                </div>

                <div>
                    <x-input-label  :value="__('Plataforma')" />
                    <h3 class='plataform-name'>InDrive</h3>

                    <x-input-label for="valor_indrive" :value="__('Valor do dia')" />
                    <x-text-input
                        id="valor_indrive"
                        placeholder="0.00"
                        type="number"
                        step="0.01"
                        min='0'
                        name="valor_indrive"
                        :value="old('valor_indrive')"
                        required/>

                        @error('valor_indrive')
                            <span>{{ $message }}</span>
                        @enderror
                </div>

                <div>
                    <x-input-label  :value="__('Plataforma')" />
                    <h3 class='plataform-name'>Particular</h3>

                    <x-input-label for="valor_particular" :value="__('Valor do dia')" />
                    <x-text-input
                        id="valor_particular"
                        placeholder="0.00"
                        type="number"
                        step="0.01"
                        min='0'
                        name="valor_particular"
                        :value="old('valor_particular')"
                        required/>

                        @error('valor_particular')
                            <span>{{ $message }}</span>
                        @enderror
            </div>
            </section>

            <x-input-label for="km" :value="__('km')" />
            <x-text-input
                id="km"
                type="number"
                min='0'
                placeholder="100"
                name="km"
                :value="old('km')"
                required/>

            <section class="combustivel">
                <x-input-label color="--text-black" for="litros" :value="__('Litros')" />
                <x-text-input
                    id="litros"
                    type="number"
                    step="0.01"
                    min='0'
                    placeholder="100L"
                    name="litros"
                    :value="old('litros')"
                    required/>

                <x-input-label color="--text-black" for="valor_por_litro" :value="__('Valor por litro')" />
                <x-text-input
                    id="valor_por_litro"
                    type="number"
                    step="0.01"
                    min='0'
                    placeholder="0.00"
                    name="valor_por_litro"
                    :value="old('valor_por_litro')"
                    required/>

                <x-input-label color="--text-black" for="total_combustivel" :value="__('Total dia combustivel')" />
                <x-text-input
                    id="total_combustivel"
                    disabled
                    type="number"
                    step="0.01"
                    min='0'
                    placeholder="0.00"
                    name="total_combustivel"
                    :value="old('total_combustivel')"
                    />
            </section>

            <x-input-label for="horas_trabalhadas" :value="__('Tempo')" />
            <x-text-input
                id="horas_trabalhadas"
                type="number"
                min='0'
                placeholder="12"
                name="horas_trabalhadas"
                :value="old('horas_trabalhadas')"/>

            <x-primary-button style="margin-top: 25px">
                {{ __('Salvar dia') }}
            </x-primary-button>
        </form>
        @if(session('success'))
            <div style="background-color: var(--secondary); padding: 5px 10px">
                {{ session('success') }}
            </div>
        @endif

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', () => {

            const litros = document.getElementById('litros');
            const valorPorLitro = document.getElementById('valor_por_litro');
            const totalDiaGas = document.getElementById('total_combustivel');

            function calcularCombustivel() {

                if (!litros.value || !valorPorLitro.value) {
                    totalDiaGas.value = '';
                    return;
                }

                const total =
                    parseFloat(litros.value) *
                    parseFloat(valorPorLitro.value);

                totalDiaGas.value = total.toFixed(2);
            }

            litros.addEventListener('input', calcularCombustivel);

            valorPorLitro.addEventListener('input', calcularCombustivel);

        });

    </script>
</x-app-layout>
