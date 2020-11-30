<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherTrxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_trxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Trx_id');
            $table->integer('Ref_Trx_id')->nullable($value = true);
            $table->integer('SAN_id');
            $table->string('payment_by')->default('Test User');
            $table->tinyInteger('session');
            $table->tinyInteger('class');
            $table->tinyInteger('term');
            $table->string('payment');
            $table->integer('amount_expected');
            $table->integer('amount_paid');
            $table->integer('balance');
            $table->tinyInteger('payment_mode');
            $table->tinyInteger('bank')->nullable($value = true);
            $table->string('comment')->nullable($value = true);
            $table->string('Trx_Status')->default('000');
            $table->string('Payment_Status');
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
        Schema::dropIfExists('other_trxes');
    }
}
