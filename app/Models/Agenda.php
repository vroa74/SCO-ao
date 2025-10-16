<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agenda extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'nombre',
        'apaterno',
        'amaterno',
        'cargo',
        'deporg',
        'telefono',
        'email',
        'dir',
        'modifico',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope para filtrar por título.
     */
    public function scopePorTitulo($query, $titulo)
    {
        return $query->where('titulo', 'like', "%{$titulo}%");
    }

    /**
     * Scope para filtrar por nombre.
     */
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%");
    }

    /**
     * Scope para filtrar por cargo.
     */
    public function scopePorCargo($query, $cargo)
    {
        return $query->where('cargo', 'like', "%{$cargo}%");
    }

    /**
     * Scope para filtrar por departamento/organización.
     */
    public function scopePorDeporg($query, $deporg)
    {
        return $query->where('deporg', 'like', "%{$deporg}%");
    }

    /**
     * Scope para filtrar por email.
     */
    public function scopePorEmail($query, $email)
    {
        return $query->where('email', 'like', "%{$email}%");
    }

    /**
     * Scope para buscar en múltiples campos.
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('nombre', 'like', "%{$termino}%")
              ->orWhere('apaterno', 'like', "%{$termino}%")
              ->orWhere('amaterno', 'like', "%{$termino}%")
              ->orWhere('cargo', 'like', "%{$termino}%")
              ->orWhere('deporg', 'like', "%{$termino}%")
              ->orWhere('email', 'like', "%{$termino}%");
        });
    }
}
