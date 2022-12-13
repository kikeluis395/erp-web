@extends('mecanica.tableCanvas')
@section('titulo','Reporte General')

@section('pretable-content')
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <h2>Reporte General</h2>
    <div>
        <div>Mes actual: Diciembre 2020</div>
        <div>Días hábiles: 13</div>
        <div>Días transcurridos: 17</div>
    </div>
    <div>
        <a href="{{route('reportes.reporteGeneral.export')}}"><button class="btn btn-primary">Exportar</button></a>
    </div>
    <div class="table-responsive borde-tabla tableFixHead">
        @include('reportes.reporteGeneralTabla')
    </div>
</div>
@endsection