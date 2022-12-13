<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    //
    protected $table = "vehiculo";
    protected $fillable = ['placa', 'vin', 'motor', 'id_marca_auto', 'modelo', 'tipo_transmision', 'anho_vehiculo', 'color', 'tipo_combustible', 'id_modelo_tecnico', 'anhoModelo'];
    protected $primaryKey = 'placa';

    public $timestamps = false;
    public $incrementing = false;

    public static function saveVehiculo($placa, $vin, $motor, $id_marca_auto, $id_modelo_tecnico, $modelo, $tipo_transmision, $anho_vehiculo, $color, $tipo_combustible, $anho_modelo)
    {
        $vehiculo = Self::find($placa);
        if (!$vehiculo) {
            $vehiculo = new Self();
            $vehiculo->placa = $placa;
        }
        if ($vin) $vehiculo->vin = $vin;
        if ($motor) $vehiculo->motor = $motor;
        if ($id_marca_auto) $vehiculo->id_marca_auto = (int)$id_marca_auto;
        if ($id_modelo_tecnico) $vehiculo->id_modelo_tecnico = (int)$id_modelo_tecnico;
        if ($modelo) $vehiculo->modelo = $modelo;
        if ($tipo_transmision) $vehiculo->tipo_transmision = $tipo_transmision;
        if ($anho_vehiculo) $vehiculo->anho_vehiculo = ($anho_vehiculo ? (int)$anho_vehiculo : null);
        if ($anho_modelo) $vehiculo->anho_modelo = ($anho_modelo ? (int)$anho_modelo : null);
        if ($color) $vehiculo->color = $color;
        if ($tipo_combustible) $vehiculo->tipo_combustible = $tipo_combustible;

        $vehiculo->save();
        return $vehiculo->placa;
    }

    public function hojasTrabajo()
    {
        return $this->hasMany('App\Modelos\HojaTrabajo', 'placa_auto');
    }

    public function marcaAuto()
    {
        return $this->belongsTo('App\Modelos\MarcaAuto', 'id_marca_auto');
    }

    public function modeloTecnico()
    {
        return $this->belongsTo('App\Modelos\ModeloTecnico', 'id_modelo_tecnico');
    }

    public function modeloTable()
    {
        return $this->belongsTo('App\Modelos\Modelo', 'modelo');
    }

    //-------------------------------------- PLACA ---------------------------------------
    public function getPlaca()
    {
        return $this->placa;
    }

    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }


    //-------------------------------------- Marca ---------------------------------------
    public function getIdMarca()
    {
        return $this->id_marca_auto;
    }

    public function setIdMarca($idMarca)
    {
        $this->id_marca_auto = $idMarca;
    }

    //-------------------------------------- VIN ---------------------------------------
    public function getVin()
    {
        return $this->vin;
    }

    public function setVin($vin)
    {
        $this->vin = $vin;
    }

    //-------------------------------------- Motor ---------------------------------------
    public function getMotor()
    {
        return $this->motor;
    }

    public function setMotor($motor)
    {
        $this->motor = $motor;
    }

    //-------------------------------------- Modelo ---------------------------------------
    public function getModelo()
    {
        $modelo = $this->modeloTable ? $this->modeloTable->nombre_modelo : $this->modelo;
        return $modelo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }


    //-------------------------------------- Color ---------------------------------------
    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    //-------------------------------------- TipoTransmision ---------------------------------------
    public function getTipoTransmision()
    {
        return $this->tipo_transmision;
    }

    public function setTipoTransmision($tipoTransmision)
    {
        $this->tipo_transmision = $tipoTransmision;
    }

    //-------------------------------------- Kilometraje ---------------------------------------
    public function getKilometraje()
    {
        return $this->kilometraje;
    }

    public function setKilometraje($kilometraje)
    {
        $this->kilometraje = $kilometraje;
    }

    //-------------------------------------- AnhoVehiculo ---------------------------------------
    public function getAnhoVehiculo()
    {
        return $this->anho_vehiculo;
    }
    public function getAnhoModelo()
    {
        return $this->anho_modelo;
    }

    public function setAnhoVehiculo($anhoVehiculo)
    {
        $this->anho_vehiculo = $anhoVehiculo;
    }

    //-------------------------------------- TipoCombustible ---------------------------------------
    public function getTipoCombustible()
    {
        return $this->tipo_combustible;
    }

    public function setTipoCombustible($tipoCombustible)
    {
        $this->tipo_combustible = $tipoCombustible;
    }

    public function getNombreMarca()
    {
        return $this->marcaAuto ? $this->marcaAuto->nombre_marca : '-';
    }

    public function getNombreModeloTecnico()
    {
        return $this->modeloTecnico ? $this->modeloTecnico->nombre_modelo : '';
    }

    public function hasModelos()
    {
        $id_marca = $this->id_marca_auto;

        if (!is_null($id_marca)) {
            $modelos_disponibles = Modelo::where('id_marca_auto', $id_marca)->get();
            if (count($modelos_disponibles) > 0) return true;
        }
        return false;
    }
}
