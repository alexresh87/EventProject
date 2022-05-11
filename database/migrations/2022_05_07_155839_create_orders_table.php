<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 50); //Имя клиента
            $table->string('lastname', 50); //Фамилия клиента
            $table->string('patronymic', 50); //отчество клиента
            $table->string('city', 50); //Город клиента
            $table->string('address', 150); //Адрес клиента
            $table->string('phone', 20); //Телефон клиента
            $table->string('email', 50)->nullable(); //Телефон клиента
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
