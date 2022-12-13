<table class="table text-center table-striped table-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">FECHA CITA</th>
      <th scope="col">HORA CITA</th>
      <th scope="col">HORA LLEGADA</th>
      <th scope="col">PLACA</th>
      <th scope="col">ASESOR</th>
      <th scope="col">MODELO</th>
      <th scope="col">CLIENTE</th>
      <th scope="col">TELEFONO</th>
      <th scope="col">SERVICIO</th>
      <th scope="col">ESTADO</th>
    </tr>
  </thead>
  <tbody>
    @if(false)
    @foreach ($listaCitas as $cita)
    <tr>
      <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
      <td style="vertical-align: middle">{{$cita->fecha_programada}}</td>
      <td style="vertical-align: middle">{{$cita->hora_programada}}</td>
      <td style="vertical-align: middle">{{$cita->hora_llegada}}</td>
      <td style="vertical-align: middle">{{$cita->placa}}</td>
      <td style="vertical-align: middle">{{$cita->asesor}}</td>
      <td style="vertical-align: middle">{{$cita->modelo}}</td>
      <td style="vertical-align: middle">{{$cita->cliente}}</td>
      <td style="vertical-align: middle">{{$cita->telefono}}</td>
      <td style="vertical-align: middle">{{$cita->servicio}}</td>
      <td style="vertical-align: middle">{{$cita->estado}}</td>
    </tr>
    @endforeach
    @endif
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