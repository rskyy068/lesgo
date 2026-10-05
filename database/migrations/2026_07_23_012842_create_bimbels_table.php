<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('bimbels', function (Blueprint $table) {

        $table->id();

        $table->string('nama');
        $table->string('mapel');
        $table->string('jenjang');
        $table->string('kota');

        $table->text('alamat');

        $table->string('telepon')->nullable();
        $table->string('email')->nullable();
        $table->string('website')->nullable();

        $table->string('logo')->nullable();
        $table->string('cover')->nullable();

        $table->longText('deskripsi');

        $table->integer('harga_mulai')->nullable();

        $table->string('jam_operasional')->nullable();

        $table->enum('status',['Aktif','Nonaktif'])
              ->default('Aktif');

        $table->timestamps();
    });
}
};
