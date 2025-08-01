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
        Schema::table('solicitud_altas', function (Blueprint $table) {
            $table->string('cp_fiscal')->nullable()->after('domicilio_estado');
            $table->string('liga_rfc')->nullable()->after('cp_fiscal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud_altas', function (Blueprint $table) {
            $table->dropColumn('cp_fiscal');
            $table->dropColumn('liga_rfc');
        });
    }
};
