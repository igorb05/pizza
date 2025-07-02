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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id()->from(1001);

            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pizza_id')->constrained()->cascadeOnDelete();

            $table->string('pizza_name');
            $table->string('size');
            $table->string('crust');
            $table->json('addons')->nullable();

            $table->integer('quantity');
            $table->float('unit_price')->comment('Цена за одну (включая надбавки)');
            $table->float('full_price')->comment('Полная цена');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
