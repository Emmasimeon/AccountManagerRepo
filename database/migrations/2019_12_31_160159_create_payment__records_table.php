<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment__records', function (Blueprint $table) {
            $table->date('date');
            $table->bigIncrements('id');
            $table->string('user')->default('Test User');
            $table->string('office')->default('Super User');
            $table->string('payment');
            $table->integer('quantity');
            $table->integer('amount');
            $table->string('comment')->nullable($value = true);
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
        Schema::dropIfExists('payment__records');
    }
}
