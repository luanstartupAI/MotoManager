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
        Schema::create("media", function (Blueprint $table) {
            $table->id();
            $table->string("model_type", 255)->nullable(false);
            $table->unsignedBigInteger("model_id")->nullable(false);
            $table->string("collection_name", 255)->nullable(false);
            $table->string("file_name", 255)->nullable(false);
            $table->string("path", 255)->nullable(false);
            $table->string("mime_type", 255)->nullable();
            $table->integer("size")->nullable(false);
            $table->integer("order_column")->nullable();
            $table->timestamps();

            $table->index(["model_type", "model_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("media");
    }
};


