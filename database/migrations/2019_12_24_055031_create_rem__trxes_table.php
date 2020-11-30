<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemTrxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rem__trxes', function (Blueprint $table) {
            $table->date('date');
            $table->bigIncrements('id');
            $table->string('user')->default('Test User');
            $table->string('office')->default('Super User');
            $table->integer('amount');
            $table->string('source');
            $table->string('receiver')->default('Peace(Secretary)');
            $table->string('comment');
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
        Schema::dropIfExists('rem__trxes');
    }
}
