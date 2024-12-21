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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 11, 2);
            $table->string('description');
            $table->integer('quantity');
            $table->string('product_image');  // This will be required (non-nullable)
            $table->string('category');       // Added category column
            $table->timestamps();  // Automatically adds created_at and updated_at columns
        });
        
        
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
