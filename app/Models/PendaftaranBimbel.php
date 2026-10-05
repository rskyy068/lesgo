<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PendaftaranBimbel extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_bimbels';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'no_wa',
        'paket',
        'status',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function token(): HasOne
{
    return $this->hasOne(BimbelToken::class, 'pendaftaran_bimbel_id');
}

}
