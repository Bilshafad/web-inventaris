<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'foto_barang')) {
                $table->dropColumn('foto_barang');
            }
            $table->string('kode_barang')->after('id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('kode_barang');
            $table->string('foto_barang')->nullable();
        });
    }
};
