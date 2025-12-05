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
        Schema::table('materials', function (Blueprint $table) {
            $table->string('ncm', 8)->nullable()->after('sale_price');
            $table->string('cfop_saida', 4)->nullable()->after('ncm');
            $table->string('csosn', 3)->nullable()->after('cfop_saida');
            $table->decimal('icms_rate', 5, 2)->nullable()->after('csosn');
            $table->string('cest', 7)->nullable()->after('icms_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['ncm', 'cfop_saida', 'csosn', 'icms_rate', 'cest']);
        });
    }
};


