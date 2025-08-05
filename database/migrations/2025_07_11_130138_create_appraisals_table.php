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
        Schema::create('appraisals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorcycle_id')->nullable(false)->constrained('motorcycles')->unique()->onDelete('cascade');
            $table->foreignId('appraiser_id')->nullable(false)->constrained('users');
            $table->decimal('base_fipe_price', 15, 2)->nullable();
            $table->decimal('total_deductions', 15, 2)->default(0.00);
            $table->decimal('final_appraisal_value', 15, 2)->nullable(false);
            $table->enum('status', ['PENDENTE', 'APROVADA', 'RECUSADA'])->nullable(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appraisals');
    }
};


