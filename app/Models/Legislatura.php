<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Legislatura extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'legislatura';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'legislatura',
        'actual'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'actual' => 'boolean',
    ];
}
