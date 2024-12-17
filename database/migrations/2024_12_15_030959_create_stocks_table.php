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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // Name of the item
            $table->string('sku')->unique();            // Stock Keeping Unit - unique identifier
            $table->integer('quantity')->default(0);    // Current quantity in stock
            $table->integer('min_quantity')->default(0);// Minimum quantity before reorder
            $table->decimal('unit_price', 10, 2);      // Price per unit
            $table->string('unit_type');               // Type of unit (pieces, kg, etc)
            $table->boolean('active')->default(true);   // Status of the item
            $table->timestamps();                       // Created and updated timestamps
            $table->softDeletes();                     // For soft deleting records
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};