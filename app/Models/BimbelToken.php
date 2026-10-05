<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BimbelToken extends Model
{
    protected $fillable = [
        'pendaftaran_bimbel_id',
        'token',
        'status',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    /**
     * Token milik satu pendaftaran bimbel.
     */
    public function pendaftaranBimbel(): BelongsTo
    {
        return $this->belongsTo(
            PendaftaranBimbel::class,
            'pendaftaran_bimbel_id'
        );
    }
}
