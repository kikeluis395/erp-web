<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;


class TrackDeletedTransactions extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'origen', 'id_contenedor_origen', 'description', 'data', 'created_at', 'id_usuario_registro'
    ];

    public function getDescription(){

    }

    public function usuario()
    {
        return $this->belongsTo('App\Modelos\Usuario','id_usuario_eliminador');
    }

}