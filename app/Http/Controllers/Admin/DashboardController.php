<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbel;
use App\Models\Mapel;
use App\Models\User;
use App\Models\PendaftaranBimbel;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        // Otomatis sinkronkan status bimbel kedaluwarsa di DB
        Bimbel::autoUpdateExpiredStatus();

        // Ambil 10 aktivitas terakhir
        $activities = Activity::latest()->take(10)->get();

        // Ubah data agar formatnya bisa dibaca FullCalendar
        $events = [];
        foreach ($activities as $activity) {
            $date = $activity->created_at->toDateString();
            $title = $activity->causer?->name . ' ' . strtolower($activity->description);
            $events[] = [
                'title' => $title,
                'start' => $date,
            ];
        }

        // Ambil 10 pendaftaran terakhir (dengan relasi token)
        $pendaftaran = PendaftaranBimbel::with('token')->latest()->take(10)->get();

        // Ambil daftar bimbel yang sudah expired atau hampir expired (<= 7 hari)
        $allBimbels = Bimbel::with('user')->get();
        $expiringBimbels = $allBimbels->filter(function ($b) {
            return $b->isExpired() || $b->remainingDays() <= 7;
        })->sortBy('expires_at')->values();

        return view('admin.dashboard', [
            'totalBimbel'     => Bimbel::count(),
            'totalMapel'      => Mapel::count(),
            'totalUser'       => User::count(),
            'totalReview'     => \App\Models\Review::count(),
            'activities'      => $activities,
            'events'          => $events,
            'pendaftaran'     => $pendaftaran,
            'expiringBimbels' => $expiringBimbels,
        ]);
    }

    /**
     * Endpoint API untuk real-time count data di halaman admin
     */
    public function realtimeCounts()
    {
        Bimbel::autoUpdateExpiredStatus();
        $allBimbels = Bimbel::all();
        $expiredCount = $allBimbels->filter(fn($b) => $b->isExpired())->count();
        $expiringSoonCount = $allBimbels->filter(fn($b) => !$b->isExpired() && $b->remainingDays() <= 7)->count();

        return response()->json([
            'totalUser'          => User::count(),
            'totalBimbel'        => Bimbel::count(),
            'totalReview'        => \App\Models\Review::count(),
            'totalMapel'         => Mapel::count(),
            'activeBimbel'       => Bimbel::active()->count(),
            'expiredBimbel'      => $expiredCount,
            'expiringSoonBimbel' => $expiringSoonCount,
            'pendingPendaftaran' => PendaftaranBimbel::where('status', 'pending')->count(),
            'timestamp'          => now()->format('H:i:s'),
        ]);
    }
}

