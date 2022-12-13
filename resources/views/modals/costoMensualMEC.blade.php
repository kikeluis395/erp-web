{{-- <button type="button"
        class="btn btn-warning rounded-pill px-5"
        id="costo_mensual"
        data-toggle="modal"
        data-target="#crearST">Costo Mensual</button> --}}
@php
$months = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SET', 'OCT', 'NOV', 'DIC'];
$map_months = ['M1' => 'ENE', 'M2' => 'FEB', 'M3' => 'MAR', 'M4' => 'ABR', 'M5' => 'MAY', 'M6' => 'JUN', 'M7' => 'JUL', 'M8' => 'AGO', 'M9' => 'SET', 'M10' => 'OCT', 'M11' => 'NOV', 'M12' => 'DIC'];

$monedas = ['SOLES' => 'Soles', 'DOLARES' => 'Dólares'];
$now = \Carbon\Carbon::now();
$year = $now->year;
$actual_month = $map_months["M$now->month"];

$lines = false;
$count = 0;
if ($costo_exists) {
    $lines = $costo->lineas;
    $count = count($lines);
}

$pr = $lines && $count > 0;
$data = [];
if ($pr) {
    foreach ($lines as $line) {
        $data = array_merge($data, (array) $line->listar());
    }
}

@endphp
<style>
    .table_costo_mensual td {
        padding: 5px 20px
    }

</style>
<div class="modal fade"
     id="crearST"
     tabindex="-1"
     role="dialog"
     aria-labelledby="crearSTLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-lg"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title"
                    id="editarSTLabel">Costo Mensual - {{ $year }}</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">
                <form id="formStoreMensualidad"
                      method="POST"
                      action="{{ $seccion === 'MEC' ? route('mecanica_mo.store_lineas') : route('carroceria_mo.store_lineas') }}"
                      autocomplete="off">
                    @csrf

                    @if ($costo_exists)
                        @if ($seccion === 'MEC')
                            <input type="hidden"
                                   name="id_costo_asociado_mec"
                                   value="{{ $costo->id_costo_asociado_mec }}">
                        @else
                            <input type="hidden"
                                   name="id_costo_asociado_dyp"
                                   value="{{ $costo->id_costo_asociado_dyp }}">
                        @endif
                    @endif
                    <input type="hidden"
                           name="anho"
                           value="{{ $year }}">

                    <div class="row justify-content-center">
                        <table class="table_costo_mensual">
                            <thead>
                                <th align="center">{{ $year }}</th>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($months as $month)
                                    <tr>
                                        @php
                                            $unique = $year . '_' . strtolower($month);
                                            $enabled = $actual_month === $month;
                                        @endphp

                                        <td align="right"
                                            width="100">{{ $month . '-' . substr($year, 2, 2) }}</td>
                                        <td align="right"
                                            width="250">
                                            <input id="valor_costo_{{ $month }}"
                                                   name="valor_costo_{{ $unique }}"
                                                   type="number"
                                                   step="any"
                                                   class="form-control valor_costo"
                                                   placeholder="Costo Hora Hombre"
                                                   onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))"
                                                   value="{{ $pr ? \Helper::evalZero($data['valor_costo_' . $unique]) : '' }}"
                                                   {{ $enabled ? '' : 'disabled' }}>
                                        </td>
                                        <td width="170">
                                            <select name="moneda_{{ $unique }}"
                                                    id="moneda-{{ $month }}"
                                                    class="form-control w-100 moneda_input"
                                                    data-validation="length"
                                                    data-validation-length="min1"
                                                    data-validation-error-msg="Debe seleccionar moneda"
                                                    required
                                                    {{ $enabled ? '' : 'disabled' }}>
                                                @foreach (array_keys($monedas) as $moneda)
                                                    <option value="{{ $moneda }}"
                                                            {{ $pr ? ($data['moneda_' . $unique] === $moneda ? 'selected' : '') : '' }}>
                                                        {{ $monedas[$moneda] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary rounded-pill px-4 py-2"
                        data-dismiss="modal"
                        id="closeREG">Cerrar</button>

                <button type="submit"
                        class="btn btn-primary rounded-pill px-4 py-2"
                        id="saveREG"
                        form="formStoreMensualidad">Registrar</button>

            </div>
        </div>
    </div>
</div>
