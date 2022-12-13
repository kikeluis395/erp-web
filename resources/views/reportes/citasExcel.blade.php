<table class="table text-center table-striped table-sm">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">REGISTRADO POR</th>
            <th scope="col">FECHA CITA</th>
            <th scope="col">HORA CITA</th>
            {{-- <th scope="col">HORA LLEGADA</th> --}}
            <th scope="col">FECHA LLEGADA</th>
            <th scope="col">PLACA</th>
            <th scope="col">ASESOR</th>
            <th scope="col">MODELO</th>
            <th scope="col">CLIENTE</th>
            <th scope="col">TELEFONO</th>
            <th scope="col">CORREO</th>
            <th scope="col">SERVICIO</th>
            <th scope="col">OBSERVACIONES</th>
            <th scope="col">ESTADO</th>
        </tr>
    </thead>
    <tbody>
        @if (true)
            @foreach ($listaCitas as $cita)
                <tr>
                    <th style="vertical-align: middle"
                        scope="row">{{ $loop->iteration }}</th>
                    <td style="vertical-align: middle">{{ $cita->getUsuarioEmisor() }}</td>
                    <td style="vertical-align: middle">{{ $cita->getFechaProgramada() }}</td>
                    <td style="vertical-align: middle">{{ $cita->getHoraProgramada() }}</td>
                    <td style="vertical-align: middle">{{ $cita->getFechaParseLlegada() }}</td>
                    <td style="vertical-align: middle">{{ $cita->placa_vehiculo }}</td>
                    <td style="vertical-align: middle">{{ $cita->empleado->nombreCompleto() }}</td>
                    <td style="vertical-align: middle">{{ $cita->getModelo() }}</td>
                    <td style="vertical-align: middle">{{ $cita->getNombreCliente() }}</td>
                    <td style="vertical-align: middle">{{ $cita->telefono_contacto }}</td>
                    <td style="vertical-align: middle">{{ $cita->email_contacto }}</td>
                    <td style="vertical-align: middle">{{ $cita->getServicio() }}</td>
                    <td style="vertical-align: middle">{{ $cita->observaciones }}</td>
                    <td style="vertical-align: middle">{{ $cita->getEstado() }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
