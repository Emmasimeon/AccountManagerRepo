<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error__deductions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ref_trx_id');
            $table->string('transaction');
            $table->tinyInteger('session');
            $table->tinyInteger('term');
            $table->Integer('amount');
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
        Schema::dropIfExists('error__deductions');
    }
}
