<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'activo',
        'notif_nueva_queja',
        'notif_atendida',
        'notif_anulada',
        'notif_reporte_semanal',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at'     => 'datetime',
        'password'              => 'hashed',
        'activo'                => 'boolean',
        'notif_nueva_queja'     => 'boolean',
        'notif_atendida'        => 'boolean',
        'notif_anulada'         => 'boolean',
        'notif_reporte_semanal' => 'boolean',
    ];

    public function quejasSugerencias()
    {
        return $this->hasMany(QuejaSugerencia::class);
    }
}