<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bimbel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CheckExpiredBimbel extends Command
{
    /**
     * Nama dan deskripsi perintah artisan command
     */
    protected $signature = 'bimbel:check-expired {--delete-after-days=7 : Hapus bimbel secara otomatis jika sudah expired lebih dari sekian hari}';
    protected $description = 'Otomatis menonaktifkan dan menghapus bimbel yang telah melewati masa aktif 30 hari';

    /**
     * Jalankan perintah.
     */
    public function handle()
    {
        $deleteAfterDays = (int) $this->option('delete-after-days');
        $now = now();

        // 1. Otomatis ubah status menjadi Nonaktif untuk bimbel yang telah expired
        $expiredBimbels = Bimbel::where('expires_at', '<=', $now)
            ->where('status', 'Aktif')
            ->get();

        $updatedCount = 0;
        foreach ($expiredBimbels as $bimbel) {
            $bimbel->update(['status' => 'Nonaktif']);
            $updatedCount++;
            Log::info("Bimbel #{$bimbel->id} ({$bimbel->nama}) otomatis dinonaktifkan karena masa aktif 30 hari telah habis.");
        }

        // 2. Otomatis hapus bimbel yang sudah kedaluwarsa melebihi masa tenggat (default: 7 hari setelah expired)
        $deletionCutoff = (clone $now)->subDays($deleteAfterDays);
        $toDeleteBimbels = Bimbel::where('expires_at', '<=', $deletionCutoff)->get();

        $deletedCount = 0;
        foreach ($toDeleteBimbels as $bimbel) {
            $nama = $bimbel->nama;
            
            // Hapus file logo & cover jika ada
            if ($bimbel->logo) {
                Storage::disk('public')->delete($bimbel->logo);
            }
            if ($bimbel->cover) {
                Storage::disk('public')->delete($bimbel->cover);
            }

            $bimbel->delete();
            $deletedCount++;
            Log::info("Bimbel #{$bimbel->id} ({$nama}) otomatis dihapus karena telah kedaluwarsa lebih dari {$deleteAfterDays} hari.");
        }

        $this->info("Pemeriksaan selesai: {$updatedCount} bimbel dinonaktifkan, {$deletedCount} bimbel kedaluwarsa dihapus.");
        return Command::SUCCESS;
    }
}
