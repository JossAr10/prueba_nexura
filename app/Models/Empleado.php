<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    //
    protected $fillable = [
        'nombre',
        'email',
        'sexo',
        'area_id',
        'descripcion',
        'boletin'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'empleado_rol');
    }

}
