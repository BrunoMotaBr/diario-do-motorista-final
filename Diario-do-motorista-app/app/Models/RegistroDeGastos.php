<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroDeGastos extends Model
{
    protected $fillable = [

        'user_id',
        'tipo_gasto',
        'qual_gasto',
        'valor',
        'forma_pagamento',
        'pagamento_tipo',
        'parcelas',
        'vencimento_parcelas',
        'inicio_parcela',
        'dia'
    ];
}
