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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorcycle_id')->nullable(false)->constrained('motorcycles')->unique();
            $table->foreignId('customer_id')->nullable(false)->constrained('customers');
            $table->foreignId('user_id')->nullable(false)->constrained('users');
            $table->decimal('final_sale_price', 15, 2)->nullable(false);
            $table->date('sale_date')->nullable(false);
            $table->enum('payment_method', ['A_VISTA', 'FINANCIAMENTO', 'CONSORCIO', 'CARTAO'])->nullable();
            $table->foreignId('trade_in_motorcycle_id')->nullable()->constrained('motorcycles')->unique();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};


