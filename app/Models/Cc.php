<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cc extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'cc';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tc_id',
        'ccor'
    ];

    /**
     * Get the TC that owns the CC.
     */
    public function tc(): BelongsTo
    {
        return $this->belongsTo(Tc::class);
    }
}
