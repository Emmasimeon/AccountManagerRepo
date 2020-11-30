<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchfeeLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schfee_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('SAN_id');
            $table->tinyInteger('stu_class_id')->nullable($value = true);
            $table->tinyInteger('session')->nullable($value = true);
            $table->tinyInteger('term')->nullable($value = true);
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
        Schema::dropIfExists('schfee_ledgers');
    }
}
