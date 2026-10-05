<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Bimbel extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'bimbels';

    protected $fillable = [
        'user_id',
        'nama',
        'mapel',
        'jenjang',
        'kota',
        'alamat',
        'telepon',
        'email',
        'website',
        'logo',
        'cover',
        'deskripsi',
        'harga_mulai',
        'jam_operasional',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'bimbel_mapel', 'bimbel_id', 'mapel_id')->withTimestamps();
    }

    /**
     * Cek apakah masa aktif bimbel sudah habis (kedaluwarsa)
     */
    public function isExpired(): bool
    {
        $expiration = $this->expires_at ?? $this->created_at?->addDays(30);
        if (!$expiration) {
            return false;
        }
        return now()->greaterThanOrEqualTo($expiration);
    }

    /**
     * Hitung sisa hari masa aktif bimbel
     */
    public function remainingDays(): int
    {
        $expiration = $this->expires_at ?? $this->created_at?->addDays(30);
        if (!$expiration) {
            return 30;
        }

        if (now()->greaterThanOrEqualTo($expiration)) {
            return 0;
        }

        return (int) ceil(now()->diffInSeconds($expiration, false) / 86400);
    }

    /**
     * Scope query untuk hanya menampilkan bimbel aktif dan belum kedaluwarsa
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['Aktif', 'aktif', 'Active', 'active'])
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Otomatis update status bimbel yang kedaluwarsa di database
     */
    public static function autoUpdateExpiredStatus(): void
    {
        static::where('expires_at', '<=', now())
            ->where('status', 'Aktif')
            ->update(['status' => 'Nonaktif']);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'nama',
                'mapel',
                'kota',
                'status',
                'expires_at',
            ])
            ->logOnlyDirty()
            ->useLogName('Bimbel');
    }
}

