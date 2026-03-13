<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orderid')->constrained('scorders')->onDelete('cascade');
            $table->foreignId('productid')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('order_details');
    }
};