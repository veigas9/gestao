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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();

            // Dados cadastrais básicos
            $table->string('company_name');
            $table->string('trade_name')->nullable();
            $table->string('cnpj', 14)->unique();
            $table->string('ie', 20)->nullable();
            $table->string('im', 20)->nullable();
            $table->string('tax_regime', 20)->default('MEI');
            $table->string('cnae', 20)->nullable();

            // Endereço
            $table->string('street');
            $table->string('number', 20)->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city');
            $table->string('city_ibge_code', 7)->nullable();
            $table->string('state', 2)->default('RS');
            $table->string('zip_code', 8)->nullable();

            // Contato
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();

            // NF-e
            $table->string('nfe_environment', 20)->default('homologacao'); // homologacao|producao
            $table->string('nfe_series', 3)->default('1');
            $table->unsignedBigInteger('nfe_last_number')->default(0);

            // Campos auxiliares para caminho do certificado (senha deve ficar no .env)
            $table->string('nfe_cert_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};


