<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxSchfeeLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_schfee_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('SAN_id');
            $table->tinyInteger('stu_class_id')->nullable($value = true);
            $table->tinyInteger('session')->nullable($value = true);
            $table->tinyInteger('term')->nullable($value = true);
            $table->integer('Field_1_paid')->nullable($value = true);
            $table->integer('Field_1_discount')->nullable($value = true);
            $table->integer('Field_1_balance')->nullable($value = true);
            $table->integer('Field_2_paid')->nullable($value = true);
            $table->integer('Field_2_discount')->nullable($value = true);
            $table->integer('Field_2_balance')->nullable($value = true);
            $table->integer('Field_3_paid')->nullable($value = true);
            $table->integer('Field_3_discount')->nullable($value = true);
            $table->integer('Field_3_balance')->nullable($value = true);
            $table->integer('Field_4_paid')->nullable($value = true);
            $table->integer('Field_4_discount')->nullable($value = true);
            $table->integer('Field_4_balance')->nullable($value = true);
            $table->integer('Field_5_paid')->nullable($value = true);
            $table->integer('Field_5_discount')->nullable($value = true);
            $table->integer('Field_5_balance')->nullable($value = true);
            $table->integer('Field_6_paid')->nullable($value = true);
            $table->integer('Field_6_discount')->nullable($value = true);
            $table->integer('Field_6_balance')->nullable($value = true);
            $table->integer('Field_7_paid')->nullable($value = true);
            $table->integer('Field_7_discount')->nullable($value = true);
            $table->integer('Field_7_balance')->nullable($value = true);
            $table->integer('Field_8_paid')->nullable($value = true);
            $table->integer('Field_8_discount')->nullable($value = true);
            $table->integer('Field_8_balance')->nullable($value = true);
            $table->integer('Field_9_paid')->nullable($value = true);
            $table->integer('Field_9_discount')->nullable($value = true);
            $table->integer('Field_9_balance')->nullable($value = true);
            $table->integer('Field_10_paid')->nullable($value = true);
            $table->integer('Field_10_discount')->nullable($value = true);
            $table->integer('Field_10_balance')->nullable($value = true);
            $table->integer('Field_11_paid')->nullable($value = true);
            $table->integer('Field_11_discount')->nullable($value = true);
            $table->integer('Field_11_balance')->nullable($value = true);
            $table->integer('Field_12_paid')->nullable($value = true);
            $table->integer('Field_12_discount')->nullable($value = true);
            $table->integer('Field_12_balance')->nullable($value = true);
            $table->integer('Field_13_paid')->nullable($value = true);
            $table->integer('Field_13_discount')->nullable($value = true);
            $table->integer('Field_13_balance')->nullable($value = true);
            $table->integer('Field_14_paid')->nullable($value = true);
            $table->integer('Field_14_discount')->nullable($value = true);
            $table->integer('Field_14_balance')->nullable($value = true);
            $table->integer('Field_15_paid')->nullable($value = true);
            $table->integer('Field_15_discount')->nullable($value = true);
            $table->integer('Field_15_balance')->nullable($value = true);
            $table->integer('trx_total_expected');
            $table->integer('trx_dsc_total');
            $table->integer('bal_total');
            $table->string('Trx_Status', 1)->default('D');
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
        Schema::dropIfExists('trx_schfee_ledgers');
    }
}
