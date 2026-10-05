<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Mapel extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'mapels';

    protected $fillable = [
        'nama',
        'slug',
        'icon',
        'warna',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Mapel');
    }

    public function bimbels()
    {
        return $this->belongsToMany(Bimbel::class, 'bimbel_mapel', 'mapel_id', 'bimbel_id')->withTimestamps();
    }
}
