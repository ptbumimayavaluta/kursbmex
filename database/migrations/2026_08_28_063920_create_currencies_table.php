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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // USD, AUD, EUR, dll.
            $table->string('name');                // US Dollar, Australian Dollar, dll.
            $table->string('flag')->nullable();    // Path/nama ikon bendera
            $table->decimal('buy_rate', 12, 2);    // Kurs Beli (We Buy)
            $table->decimal('sell_rate', 12, 2);   // Kurs Jual (We Sell)
            $table->integer('order_number')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
