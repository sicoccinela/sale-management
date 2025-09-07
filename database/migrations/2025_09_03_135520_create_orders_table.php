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
            $table->string('order_code')->unique();
            $table->foreignId('sales_id')->constrained('sales')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('product_name');
            $table->integer('quantity');
            $table->json('images')->nullable();
            $table->decimal('price', 12, 2);
            $table->enum('status', ['DIPROSES','DIVERIFIKASI','DIPRINT'])->default('DIPROSES');
            $table->string('invoice_path')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
        $table->dropConstrainedForeignId('verified_by');
        $table->dropColumn('verified_at');
        Schema::dropIfExists('orders');
    });
    }
    
};
