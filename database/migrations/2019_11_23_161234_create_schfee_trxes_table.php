<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchfeeTrxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schfee_trxes', function (Blueprint $table) {
            $table->unsignedBigInteger('Trx_id');
            $table->primary('Trx_id');
            $table->unsignedBigInteger('Ref_Trx_id')->nullable($value = true);
            $table->integer('SAN_id');
            $table->tinyInteger('stu_class_id')->nullable($value = true);
            $table->string('payment_by')->default('Test User');
            $table->tinyInteger('session')->nullable($value = true);
            $table->tinyInteger('term')->nullable($value = true);
            $table->integer('tuition_fee_amount')->nullable($value = true);
            $table->integer('tuition_fee_discount')->nullable($value = true);
            $table->integer('ict_fee_amount')->nullable($value = true);
            $table->integer('ict_fee_discount')->nullable($value = true);
            $table->integer('pta_fee_amount')->nullable($value = true);
            $table->integer('pta_fee_discount')->nullable($value = true);
            $table->integer('boarding_fee_amount')->nullable($value = true);
            $table->integer('boarding_fee_discount')->nullable($value = true);
            $table->integer('utility_fee_amount')->nullable($value = true);
            $table->integer('utility_fee_discount')->nullable($value = true);
            $table->integer('development_levy_amount')->nullable($value = true);
            $table->integer('development_levy_discount')->nullable($value = true);
            $table->integer('books_amount')->nullable($value = true);
            $table->integer('books_discount')->nullable($value = true);
            $table->integer('uniforms_amount')->nullable($value = true);
            $table->integer('uniforms_discount')->nullable($value = true);
            $table->integer('trx_total');
            $table->integer('trx_dsc_total')->nullable($value = true);
            $table->tinyInteger('payment_mode');
            $table->tinyInteger('bank')->nullable($value = true);
            $table->string('comment')->nullable($value = true);
            $table->string('Trx_Status')->default('000');
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
        Schema::dropIfExists('schfee_trxes');
    }
}
