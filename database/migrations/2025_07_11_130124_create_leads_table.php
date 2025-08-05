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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable(false)->constrained('customers')->onDelete('cascade');
            $table->foreignId('motorcycle_of_interest_id')->nullable()->constrained('motorcycles')->onDelete('set null');
            $table->foreignId('assigned_to_user_id')->nullable(false)->constrained('users')->onDelete('cascade');
            $table->foreignId('lead_origin_id')->nullable(false)->constrained('lead_origins');
            $table->enum('status', ['NOVO', 'CONTATADO', 'PROPOSTA_ENVIADA', 'NEGOCIACAO', 'GANHO', 'PERDIDO'])->nullable(false);
            $table->text('lost_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};


