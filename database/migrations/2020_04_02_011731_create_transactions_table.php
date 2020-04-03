<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchaser_id');
            $table->foreignId('vendor_id');
            $table->foreignId('product_id');
            $table->string('street');
            $table->integer('number');
            $table->string('neighborhood');
            $table->string('complement')->nullable();
            $table->integer('zip_code');
            $table->string('city');
            $table->string('state');
            $table->timestamps();

            $table->foreign('purchaser_id')->references('id')->on('users');
            $table->foreign('vendor_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
