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
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('company_setting_id')
                ->nullable()
                ->after('id')
                ->constrained('company_settings')
                ->nullOnDelete();
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->foreignId('company_setting_id')
                ->nullable()
                ->after('id')
                ->constrained('company_settings')
                ->nullOnDelete();
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('company_setting_id')
                ->nullable()
                ->after('id')
                ->constrained('company_settings')
                ->nullOnDelete();
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            $table->foreignId('company_setting_id')
                ->nullable()
                ->after('id')
                ->constrained('company_settings')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_setting_id');
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_setting_id');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_setting_id');
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_setting_id');
        });
    }
};


