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
    
        Schema::create('pharmacy_inventories', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('pharmacy_id')
                  ->constrained('pharmacies')
                  ->cascadeOnDelete();
            
            $table->foreignId('medicine_id')
                  ->constrained('medicines')
                  ->cascadeOnDelete();
            
            $table->unsignedInteger('quantity_in_stock')->default(0); // Ensure non-negative stock
            $table->decimal('selling_price', 10, 2);
            $table->date('expiry_date')->nullable();
            
            $table->enum('status', ['متوفر', 'قليل', 'نفذ'])->default('متوفر');
            $table->unsignedInteger('alert_threshold')->default(10);
            
            // Add a unique constraint to prevent duplicate medicine entries per pharmacy
            $table->unique(['pharmacy_id', 'medicine_id'], 'pharmacy_medicine_unique');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_inventories');
    }
};
