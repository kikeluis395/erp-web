<table class="table text-center table-striped table-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">CODIGO</th>
      <th scope="col">DESCRIPCION</th>
      <th scope="col">LOCAL</th>
      <th scope="col">SALDO ACTUAL</th>
      <th scope="col">ULTIMA FECHA INGRESO</th>
      <th scope="col">ULTIMA FECHA EGRESO</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($listaRepuestos as $repuesto)
    <tr>
      <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
      <td style="vertical-align: middle">{{$repuesto->codigo_repuesto}}</td>
      <td style="vertical-align: middle">{{$repuesto->descripcion}}</td>
      <td style="vertical-align: middle">{{$repuesto->nombre_local}}</td>
      <td style="vertical-align: middle">{{$repuesto->saldo_actual}}</td>
      <td style="vertical-align: middle">{{\Carbon\Carbon::parse($repuesto->ult_fecha_ingreso)->format('d/m/Y')}}</td>
      <td style="vertical-align: middle">{{\Carbon\Carbon::parse($repuesto->ult_fecha_egreso)->format('d/m/Y')}}</td>
    </tr>
    @endforeach
    <!-- <tr>
      <th style="vertical-align: middle" scope="row">1</th>
      <td style="vertical-align: middle">REP001</td>
      <td style="vertical-align: middle">Repuesto prueba 1</td>
      <td style="vertical-align: middle">DyP Nissan San Miguel</td>
      <td style="vertical-align: middle">50</td>
      <td style="vertical-align: middle">09/12/2020</td>
      <td style="vertical-align: middle">09/12/2020</td>
    </tr>
    <tr>
      <th style="vertical-align: middle" scope="row">2</th>
      <td style="vertical-align: middle">REP001</td>
      <td style="vertical-align: middle">Repuesto prueba 1</td>
      <td style="vertical-align: middle">DyP Miraflores</td>
      <td style="vertical-align: middle">10</td>
      <td style="vertical-align: middle">09/12/2020</td>
      <td style="vertical-align: middle">09/12/2020</td>
    </tr>
    <tr>
      <th style="vertical-align: middle" scope="row">3</th>
      <td style="vertical-align: middle">REP001</td>
      <td style="vertical-align: middle">Repuesto prueba 1</td>
      <td style="vertical-align: middle">DyP Surquillo</td>
      <td style="vertical-align: middle">10</td>
      <td style="vertical-align: middle">09/12/2020</td>
      <td style="vertical-align: middle">09/12/2020</td>
    </tr>
    <tr>
      <th style="vertical-align: middle" scope="row">4</th>
      <td style="vertical-align: middle">REP001</td>
      <td style="vertical-align: middle">Repuesto prueba 1</td>
      <td style="vertical-align: middle">DyP Surco</td>
      <td style="vertical-align: middle">10</td>
      <td style="vertical-align: middle">09/12/2020</td>
      <td style="vertical-align: middle">09/12/2020</td>
    </tr>
    <tr>
      <th style="vertical-align: middle" scope="row">5</th>
      <td style="vertical-align: middle">REP002</td>
      <td style="vertical-align: middle">Repuesto prueba 2</td>
      <td style="vertical-align: middle">DyP Nissan Los Olivos</td>
      <td style="vertical-align: middle">50</td>
      <td style="vertical-align: middle">09/12/2020</td>
      <td style="vertical-align: middle">09/12/2020</td>
    </tr> -->
  </tbody>
</table>