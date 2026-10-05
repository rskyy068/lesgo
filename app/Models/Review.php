<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $fillable=[

        'user_id',
        'bimbel_id',
        'rating',
        'komentar'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bimbel()
    {
        return $this->belongsTo(Bimbel::class);
    }

}