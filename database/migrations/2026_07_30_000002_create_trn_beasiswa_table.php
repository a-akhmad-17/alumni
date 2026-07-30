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
        if (!Schema::hasTable('trn_beasiswa')) {
            Schema::create('trn_beasiswa', function (Blueprint $table) {
                $table->string('id', 36)->primary();
                $table->string('judul', 255);
                $table->string('slug', 255);
                $table->text('informasi');
                $table->string('link_eksternal', 500);
                $table->string('gambar', 255)->nullable();
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
        Schema::dropIfExists('trn_beasiswa');
    }
};
