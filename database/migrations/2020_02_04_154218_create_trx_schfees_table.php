<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxSchfeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_schfees', function (Blueprint $table) {
            $table->unsignedBigInteger('Trx_id');
            $table->primary('Trx_id');
            $table->unsignedBigInteger('Ref_Trx_id')->nullable($value = true);
            $table->integer('SAN_id');
            $table->tinyInteger('stu_class_id')->nullable($value = true);
            $table->string('payment_by')->default('Test User');
            $table->tinyInteger('session')->nullable($value = true);
            $table->tinyInteger('term')->nullable($value = true);
            $table->integer('Field_1_amount')->nullable($value = true);
            $table->integer('Field_1_discount')->nullable($value = true);
            $table->integer('Field_2_amount')->nullable($value = true);
            $table->integer('Field_2_discount')->nullable($value = true);
            $table->integer('Field_3_amount')->nullable($value = true);
            $table->integer('Field_3_discount')->nullable($value = true);
            $table->integer('Field_4_amount')->nullable($value = true);
            $table->integer('Field_4_discount')->nullable($value = true);
            $table->integer('Field_5_amount')->nullable($value = true);
            $table->integer('Field_5_discount')->nullable($value = true);
            $table->integer('Field_6_amount')->nullable($value = true);
            $table->integer('Field_6_discount')->nullable($value = true);
            $table->integer('Field_7_amount')->nullable($value = true);
            $table->integer('Field_7_discount')->nullable($value = true);
            $table->integer('Field_8_amount')->nullable($value = true);
            $table->integer('Field_8_discount')->nullable($value = true);
            $table->integer('Field_9_amount')->nullable($value = true);
            $table->integer('Field_9_discount')->nullable($value = true);
            $table->integer('Field_10_amount')->nullable($value = true);
            $table->integer('Field_10_discount')->nullable($value = true);
            $table->integer('Field_11_amount')->nullable($value = true);
            $table->integer('Field_11_discount')->nullable($value = true);
            $table->integer('Field_12_amount')->nullable($value = true);
            $table->integer('Field_12_discount')->nullable($value = true);
            $table->integer('Field_13_amount')->nullable($value = true);
            $table->integer('Field_13_discount')->nullable($value = true);
            $table->integer('Field_14_amount')->nullable($value = true);
            $table->integer('Field_14_discount')->nullable($value = true);
            $table->integer('Field_15_amount')->nullable($value = true);
            $table->integer('Field_15_discount')->nullable($value = true);
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
        Schema::dropIfExists('trx_schfees');
    }
}
