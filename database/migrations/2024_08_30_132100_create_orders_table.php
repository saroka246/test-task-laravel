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
            $table->unsignedBigInteger('type_id')->comment('Тип заказа');
            $table->unsignedBigInteger('partnership_id')->comment('Компания, от лица которой создан заказ');
            $table->unsignedBigInteger('user_id')->comment('Пользователь, создавший заказ');
            $table->text('description')->nullable()->comment('Описание заказа');
            $table->dateTimeTz('date')->comment('Дата исполнения заказа');
            $table->string('address')->nullable()->comment('Адрес заказа');
            $table->integer('amount')->nullable()->comment('Кол-во');
            $table->enum('status',['Создан','Назначен Исполнитель','Завершен'])->index()->comment('Статус заказа');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('order_types');
            $table->foreign('partnership_id')->references('id')->on('partnerships');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
