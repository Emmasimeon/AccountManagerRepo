<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankingTrxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banking__trxes', function (Blueprint $table) {
            $table->date('date');
            $table->bigIncrements('id');
            $table->string('user')->default('Test User');
            $table->string('office')->default('Super Admin');
            $table->string('bank');
            $table->integer('amount');
            $table->string('source');
            $table->string('teller');
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
        Schema::dropIfExists('banking__trxes');
    }
}
