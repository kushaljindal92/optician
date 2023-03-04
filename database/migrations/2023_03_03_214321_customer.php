<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Customer extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('phone')->unique();
            $table->string('email')->unique();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->tinyInteger('customer_type');
            $table->date('birthdate');
            $table->tinyInteger('gender');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('customers');
    }
}
