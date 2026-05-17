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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('material', 255)->nullable() ->default(null);
                $table->string('color', 255)->nullable() ->default(null);
                $table->string('size', 255)->nullable() ->default(null);
                $table->decimal('price', 8, 2);
                $table->integer('stock');
                $table->string('image_path')->nullable() ->default(null); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
