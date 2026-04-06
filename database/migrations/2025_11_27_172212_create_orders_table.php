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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('sub_total', 8, 2);
            $table->decimal('tax', 8, 2)->default(0);
            $table->decimal('vat', 8, 2)->default(0); 
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('total_amount', 8, 2);
            $table->enum('status', ['pending', 'paid','refunded','on_the_way','deliverd',])->default('pending');
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', [ 'paid','unpaid'])->default('unpaid'); 
            $table->string('transaction_id')->unique()->nullable(); 
            $table->text('shipping_info')->nullable(); 
            $table->string('coupon_code')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
