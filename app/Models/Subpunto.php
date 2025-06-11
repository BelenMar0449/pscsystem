<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subpunto extends Model
{
    protected $fillable = [
        'punto_id',
        'nombre',
        'codigo',
    ];

    public function punto() {
        return $this->belongsTo(Punto::class);
    }

    public function supervisores()
    {
        return $this->belongsToMany(User::class, 'supervisorpuntos', 'subpunto_id', 'supervisor_id');
    }
}
