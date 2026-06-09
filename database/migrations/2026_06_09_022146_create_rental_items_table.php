<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('rental_id')
                  ->constrained()
                  ->onDelete('cascade');   // Si se borra el alquiler, se borran los items
            
            $table->foreignId('equipment_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->decimal('daily_price', 10, 2);
            $table->integer('days');
            $table->decimal('subtotal', 10, 2);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rental_items');
    }
};