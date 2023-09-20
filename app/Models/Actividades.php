<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';

    protected $fillable = [
        'nombre_actividad',
    ];

    /**
     * Obtiene el día de la semana de la actividad.
     *
     * @return \App\Models\DiaSemana
     */
    public function diaSemana()
    {
        return $this->belongsTo(DiaSemana::class);
    }

    /**
     * Obtiene las agendas de la actividad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }
}
