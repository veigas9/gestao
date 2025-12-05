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
        Schema::create('nfe_invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sale_id')
                ->constrained('sales')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('environment', 20)->default('homologacao'); // homologacao|producao
            $table->string('status', 20)->default('draft'); // draft|generated|authorized|rejected

            $table->string('series', 3)->nullable();
            $table->unsignedBigInteger('number')->nullable();
            $table->string('access_key', 44)->nullable();
            $table->string('protocol', 30)->nullable();

            $table->string('xml_path')->nullable();
            $table->text('last_message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nfe_invoices');
    }
};


