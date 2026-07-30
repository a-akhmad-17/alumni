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
        if (!Schema::hasTable('trn_infografis')) {
            Schema::create('trn_infografis', function (Blueprint $table) {
                $table->string('id', 36)->primary();
                $table->string('judul', 255);
                $table->string('slug', 255);
                $table->text('deskripsi')->nullable();
                $table->string('gambar', 255);
                $table->string('link_tautan', 500)->nullable();
                $table->boolean('is_popup')->default(0)->comment('Apakah ditampilkan di popup beranda');
                $table->integer('urutan')->default(0);
                $table->string('status', 20)->default('published');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_infografis');
    }
};
