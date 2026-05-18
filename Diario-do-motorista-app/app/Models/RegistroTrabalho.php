<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroTrabalho extends Model
{
    protected $fillable = [
        'user_id',
        'dia',
        'valor_uber',
        'valor_99',
        'valor_indrive',
        'valor_particular',
        'km',
        'litros',
        'valor_por_litro',
        'total_combustivel',
        'horas_trabalhadas',
    ];
}
