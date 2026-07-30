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
        Schema::table('mst_alumni', function (Blueprint $table) {
            if (!Schema::hasColumn('mst_alumni', 'no_kta')) {
                $table->string('no_kta', 50)->nullable()->unique()->after('status')->comment('Nomor KTA Resmi Alumni');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_alumni', function (Blueprint $table) {
            if (Schema::hasColumn('mst_alumni', 'no_kta')) {
                $table->dropColumn('no_kta');
            }
        });
    }
};
