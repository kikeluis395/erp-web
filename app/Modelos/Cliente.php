<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    protected $table = "cliente";
    protected $fillable = ['num_doc', 'tipo_doc', 'tipo_cliente', 'nombres', 'apellido_pat', 'apellido_mat', 'sexo', 'estado_civil', 'direccion', 'celular', 'email', 'cod_ubigeo'];
    protected $primaryKey = 'num_doc';

    public $timestamps = false;
    public $incrementing = false;

    public static function saveCliente($num_doc, $tipo_doc, $tipo_cliente, $nombres, $apellido_pat, $apellido_mat, $sexo, $estado_civil, $direccion, $celular, $email, $cod_ubigeo)
    {
        $cliente = Self::find($num_doc);
        if (!$cliente) {
            $cliente = new Self();
            $cliente->num_doc = $num_doc;
        }

        $cliente->tipo_doc = $tipo_doc;
        $cliente->tipo_cliente = in_array($tipo_doc, ['CE', 'DNI']) ? 'NATURAL' : 'EMPRESA';
        $cliente->nombres = $nombres;
        $cliente->apellido_pat = $apellido_pat;
        $cliente->apellido_mat = $apellido_mat;
        
        if ($sexo) $cliente->sexo = $sexo;
        if ($estado_civil) $cliente->estado_civil = $estado_civil;
        if ($direccion) $cliente->direccion = $direccion;
        if ($celular) $cliente->celular = $celular;
        if ($email) $cliente->email = $email;
        if ($cod_ubigeo) $cliente->cod_ubigeo = ($cod_ubigeo ? $cod_ubigeo : null);

        $cliente->save();

        return $cliente->num_doc;
    }

    public function hojasTrabajo()
    {
        return $this->hasMany('App\Modelos\HojaTrabajo', 'num_doc');
    }

    public function ubigeo()
    {
        return $this->belongsTo('App\Modelos\Ubigeo', 'cod_ubigeo');
    }

    public function getNombreCliente()
    {
        return $this->nombres . " " . $this->apellido_pat;
    }

    public function getNombreCompleto()
    {
        return $this->nombres . ($this->apellido_pat ? ' ' . $this->apellido_pat : '') . ($this->apellido_mat ? ' ' . $this->apellido_mat : '');
    }

    //-------------------------------------- Numero Documento ---------------------------------------
    public function getNumDocCliente()
    {
        return $this->num_doc;
    }

    public function setNumDocCliente($num_doc)
    {
        $this->num_doc = $num_doc;
    }

    //-------------------------------------- Tipo Documento ---------------------------------------
    public function getTipoDocCliente()
    {
        return $this->tipo_doc;
    }

    public function setTipoDocCliente($tipo_doc)
    {
        $this->tipo_doc = $tipo_doc;
    }

    //-------------------------------------- Tipo Cliente ---------------------------------------
    public function getTipoCliente()
    {
        return $this->tipo_cliente;
    }

    public function setTipoCliente($tipo_cliente)
    {
        $this->tipo_cliente = $tipo_cliente;
    }

    //-------------------------------------- Nombres ---------------------------------------
    public function getNombres()
    {
        return $this->nombres;
    }

    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    //-------------------------------------- Apellido Pat ---------------------------------------
    public function getApellidoPat()
    {
        return $this->apellido_pat;
    }

    public function setApellidoPat($apellido_pat)
    {
        $this->apellido_pat = $apellido_pat;
    }

    //-------------------------------------- Apellido Mat ---------------------------------------
    public function getApellidoMat()
    {
        return $this->apellido_mat;
    }

    public function setApellidoMat($apellido_mat)
    {
        $this->apellido_mat = $apellido_mat;
    }

    //-------------------------------------- Sexo ---------------------------------------
    public function getSexo()
    {
        return $this->sexo;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    //-------------------------------------- Estado Civil ---------------------------------------
    public function getEstadoCivil()
    {
        return $this->estado_civil;
    }

    public function setEstadoCivil($estado_civil)
    {
        $this->estado_civil = $estado_civil;
    }

    //-------------------------------------- Direccion ---------------------------------------
    public function getDireccionCliente()
    {
        return $this->direccion;
    }

    public function setDireccionCliente($direccion)
    {
        $this->direccion = $direccion;
    }

    //-------------------------------------- Telefono ---------------------------------------
    public function getTelefonoCliente()
    {
        return $this->celular;
    }

    public function setTelefonoCliente($telefono)
    {
        $this->celular = $telefono;
    }

    //-------------------------------------- Correo ---------------------------------------
    public function getCorreoCliente()
    {
        return $this->email;
    }

    public function setCorreoCliente($email)
    {
        $this->email = $email;
    }

    public function getCorreoClienteSplit()
    {
        $email = str_replace('@', ' @', $this->email);
        return $email;
    }

    //-------------------------------------- Ubigeo ---------------------------------------
    public function getUbigeoCliente()
    {
        return $this->cod_ubigeo;
    }

    public function setUbigeoCliente($cod_ubigeo)
    {
        $this->cod_ubigeo = $cod_ubigeo;
    }

    public function getDepartamento()
    {
        return substr($this->cod_ubigeo, 0, 2);
    }

    public function getDepartamentoText()
    {
        return $this->ubigeo ? $this->ubigeo->departamento : '';
    }

    public function getProvincia()
    {
        return substr($this->cod_ubigeo, 2, 2);
    }

    public function getProvinciaText()
    {
        return $this->ubigeo ? $this->ubigeo->provincia : '';
    }

    public function getDistrito()
    {
        return substr($this->cod_ubigeo, 4, 2);
    }

    public function getDistritoText()
    {
        return $this->ubigeo ? $this->ubigeo->distrito : '';
    }
}
