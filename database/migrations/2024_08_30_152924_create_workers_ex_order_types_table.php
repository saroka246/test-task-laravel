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
        Schema::create('workers_ex_order_types', function (Blueprint $table) {
            $table->unsignedBigInteger('worker_id')->comment('ID исполнителя');
            $table->unsignedBigInteger('type_id')->comment('ID типа заказа, с которым НЕ работает исполнитель');

            $table->foreign('worker_id')->references('id')->on('workers');
            $table->foreign('type_id')->references('id')->on('order_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers_ex_order_types');
    }
};
