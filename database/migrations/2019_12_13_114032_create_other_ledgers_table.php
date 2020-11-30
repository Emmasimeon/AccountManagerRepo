<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('SAN_id');
            $table->tinyInteger('stu_class')->nullable($value = true);
            $table->tinyInteger('session')->nullable($value = true);
            $table->tinyInteger('term')->nullable($value = true);
            $table->integer('payment');
            $table->string('total_expected');
            $table->string('total_paid');
            $table->string('balance');
            $table->string('payment_status')->default('D');
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
        Schema::dropIfExists('other_ledgers');
    }
}
