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
    {      Schema::create('medicines', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Trade name
        $table->decimal('base_price', 10, 2);


        $table->text('description')->nullable();
        $table->boolean('is_available')->default(true);

        $table->foreignId('medicine_category_id')
              ->nullable()
              ->constrained('medicine_categories')
              ->nullOnDelete();

        $table->foreignId('company_id')
              ->constrained('companies')
              ->cascadeOnDelete();

        $table->date('expiry_date')->nullable();
        $table->boolean('is_controlled')->default(false);

        $table->timestamps();
        $table->softDeletes();
    });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
