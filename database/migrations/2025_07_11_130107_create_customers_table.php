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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable(false);
            $table->string('document_number', 20)->unique()->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone_number', 20)->nullable(false);
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->foreignId('lead_origin_id')->nullable()->constrained('lead_origins')->onDelete('set null');
            $table->foreignId('assigned_to_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};


