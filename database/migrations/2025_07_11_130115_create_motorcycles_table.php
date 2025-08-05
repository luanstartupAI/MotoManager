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
        Schema::create('motorcycles', function (Blueprint $table) {
            $table->id();
            $table->string('brand', 100)->nullable(false);
            $table->string('model', 100)->nullable(false);
            $table->string('version', 100)->nullable();
            $table->integer('model_year')->nullable(false);
            $table->integer('manufacture_year')->nullable(false);
            $table->enum('type', ['NOVA', 'USADA'])->nullable(false);
            $table->string('license_plate', 10)->unique()->nullable();
            $table->string('chassis_number', 100)->unique()->nullable();
            $table->string('renavam', 100)->unique()->nullable();
            $table->string('color', 50)->nullable(false);
            $table->integer('mileage')->default(0);
            $table->string('engine_details', 255)->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable(false);
            $table->decimal('refurbishment_cost', 15, 2)->default(0.00);
            $table->decimal('sale_price', 15, 2)->nullable(false);
            $table->enum('status', ['DISPONIVEL', 'RESERVADA', 'VENDIDA', 'EM_MANUTENCAO', 'AVALIACAO'])->nullable(false);
            $table->date('purchase_date')->nullable();
            $table->text('details')->nullable();
            $table->string('fipe_code', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycles');
    }
};


