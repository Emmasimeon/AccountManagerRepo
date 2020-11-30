<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxSchfeeBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_schfee_balances', function (Blueprint $table) {

            $table->unsignedBigInteger('Trx_id');
            $table->primary('Trx_id');
            $table->integer('SAN_id');
            $table->tinyInteger('session')->nullable($value = true);
            $table->tinyInteger('term')->nullable($value = true);

            $table->integer('Field_1_balance')->nullable($value = true);
            $table->integer('Field_2_balance')->nullable($value = true);
            $table->integer('Field_3_balance')->nullable($value = true);
            $table->integer('Field_4_balance')->nullable($value = true);
            $table->integer('Field_5_balance')->nullable($value = true);
            $table->integer('Field_6_balance')->nullable($value = true);
            $table->integer('Field_7_balance')->nullable($value = true);
            $table->integer('Field_8_balance')->nullable($value = true);
            $table->integer('Field_9_balance')->nullable($value = true);
            $table->integer('Field_10_balance')->nullable($value = true);
            $table->integer('Field_11_balance')->nullable($value = true);
            $table->integer('Field_12_balance')->nullable($value = true);
            $table->integer('Field_13_balance')->nullable($value = true);
            $table->integer('Field_14_balance')->nullable($value = true);
            $table->integer('Field_15_balance')->nullable($value = true);          
            $table->integer('bal_total');
            $table->integer('trx_total_expected')->nullable($value = true);            
            $table->timestamps();

            $table->foreign('Trx_id')
                    ->references('Trx_id')->on('trx_schfees')
                    ->onDelete('cascade');
                        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_schfee_balances');
    }
}
