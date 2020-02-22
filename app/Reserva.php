<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table= 'reservas';
    protected $primaryKey = 'intIdRes';
    public $timestamps = false;
    protected $fillable = [
        'varNom',
        'varApe',
        'varEmai',
        'intTel',
        'dateRes',
        'timeRes',
        'varLugar',
        'intCant',
        'varCom',
        'dateResF',
        'dateModi',
        'varCodeReserva',
        'intEst'
    ];

}
