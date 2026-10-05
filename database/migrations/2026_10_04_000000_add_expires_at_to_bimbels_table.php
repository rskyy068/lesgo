<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bimbels', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('status');
        });

        // Set default expires_at for existing bimbels to created_at + 30 days
        DB::statement("UPDATE bimbels SET expires_at = DATE_ADD(created_at, INTERVAL 30 DAY) WHERE expires_at IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bimbels', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });
    }
};
