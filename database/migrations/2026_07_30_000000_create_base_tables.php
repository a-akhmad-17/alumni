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
        // sys_users
        if (!Schema::hasTable('sys_users')) {
            Schema::create('sys_users', function (Blueprint $table) {
                $table->string('id', 36)->primary();
                $table->string('username', 50)->unique();
                $table->string('password', 255);
                $table->string('email', 100)->nullable();
                $table->string('full_name', 100);
                $table->string('role', 20)->default('admin');
                $table->timestamps();
            });
        }

        // sys_settings
        if (!Schema::hasTable('sys_settings')) {
            Schema::create('sys_settings', function (Blueprint $table) {
                $table->string('setting_key', 50)->primary();
                $table->text('setting_value')->nullable();
            });
        }

        // mst_kategori_berita
        if (!Schema::hasTable('mst_kategori_berita')) {
            Schema::create('mst_kategori_berita', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kategori', 100);
                $table->string('slug', 100)->unique();
                $table->text('deskripsi')->nullable();
                $table->timestamps();
            });
        }

        // mst_bidang
        if (!Schema::hasTable('mst_bidang')) {
            Schema::create('mst_bidang', function (Blueprint $table) {
                $table->id();
                $table->string('nama_bidang', 150);
                $table->integer('urutan')->default(0);
                $table->text('deskripsi')->nullable();
            });
        }

        // mst_pengurus
        if (!Schema::hasTable('mst_pengurus')) {
            Schema::create('mst_pengurus', function (Blueprint $table) {
                $table->string('id', 36)->primary();
                $table->string('nama', 150);
                $table->string('jabatan', 100);
                $table->integer('id_bidang')->default(0);
                $table->string('periode', 20)->default('2026-2031');
                $table->string('foto', 255)->nullable();
                $table->string('sosmed_instagram', 150)->nullable();
                $table->string('sosmed_linkedin', 150)->nullable();
                $table->text('deskripsi_tugas')->nullable();
                $table->integer('urutan')->default(0);
                $table->boolean('is_inti')->default(0);
                $table->softDeletes();
                $table->timestamps();
            });
        }

        // mst_alumni
        if (!Schema::hasTable('mst_alumni')) {
            Schema::create('mst_alumni', function (Blueprint $table) {
                $table->string('id', 36)->primary();
                $table->string('nama', 150);
                $table->string('jenis_kelamin', 20)->default('Laki-laki');
                $table->integer('angkatan');
                $table->string('profesi', 150)->nullable();
                $table->string('kategori_profesi', 100)->nullable();
                $table->string('domisili', 150)->nullable();
                $table->string('no_hp', 30)->nullable();
                $table->string('email', 100)->nullable();
                $table->boolean('is_berprestasi')->default(0);
                $table->text('deskripsi_prestasi')->nullable();
                $table->string('foto', 255)->nullable();
                $table->string('status', 20)->default('approved');
                $table->string('no_kta', 50)->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }

        // trn_berita
        if (!Schema::hasTable('trn_berita')) {
            Schema::create('trn_berita', function (Blueprint $table) {
                $table->string('id', 36)->primary();
                $table->string('judul', 255);
                $table->string('slug', 255);
                $table->text('ringkasan')->nullable();
                $table->text('isi')->nullable();
                $table->string('gambar', 255)->nullable();
                $table->string('penulis', 100)->default('Admin IKA');
                $table->string('kategori', 50)->default('Berita');
                $table->string('status', 20)->default('published');
                $table->softDeletes();
                $table->timestamps();
            });
        }

        // trn_galeri
        if (!Schema::hasTable('trn_galeri')) {
            Schema::create('trn_galeri', function (Blueprint $table) {
                $table->string('id', 36)->primary();
                $table->string('judul', 255);
                $table->text('deskripsi')->nullable();
                $table->string('gambar', 255);
                $table->string('kategori', 50)->default('Kegiatan');
                $table->softDeletes();
                $table->timestamp('created_at')->useCurrent();
            });
        }

        // log_activity
        if (!Schema::hasTable('log_activity')) {
            Schema::create('log_activity', function (Blueprint $table) {
                $table->id();
                $table->string('user_id', 36)->nullable();
                $table->text('activity');
                $table->string('ip_address', 45)->nullable();
                $table->timestamp('created_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_activity');
        Schema::dropIfExists('trn_galeri');
        Schema::dropIfExists('trn_berita');
        Schema::dropIfExists('mst_alumni');
        Schema::dropIfExists('mst_pengurus');
        Schema::dropIfExists('mst_bidang');
        Schema::dropIfExists('mst_kategori_berita');
        Schema::dropIfExists('sys_settings');
        Schema::dropIfExists('sys_users');
    }
};
