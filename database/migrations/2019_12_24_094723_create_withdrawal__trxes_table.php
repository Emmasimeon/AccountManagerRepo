<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalTrxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal__trxes', function (Blueprint $table) {
            $table->date('date');
            $table->bigIncrements('id');
            $table->string('user')->default('Test User');
            $table->string('office')->default('Super Admin');
            $table->string('bank');
            $table->string('cheque');
            $table->integer('amount');
            $table->string('authority');
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
        Schema::dropIfExists('withdrawal__trxes');
    }
}
