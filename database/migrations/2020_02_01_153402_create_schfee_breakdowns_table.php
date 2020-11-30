<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchfeeBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schfee_breakdowns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('SAN_id');
            $table->tinyInteger('Field_1')->nullable($value = true);
            $table->tinyInteger('Field_2')->nullable($value = true);
            $table->tinyInteger('Field_3')->nullable($value = true);
            $table->tinyInteger('Field_4')->nullable($value = true);
            $table->tinyInteger('Field_5')->nullable($value = true);
            $table->tinyInteger('Field_6')->nullable($value = true);
            $table->tinyInteger('Field_7')->nullable($value = true);
            $table->tinyInteger('Field_8')->nullable($value = true);
            $table->tinyInteger('Field_9')->nullable($value = true);
            $table->tinyInteger('Field_10')->nullable($value = true);
            $table->tinyInteger('Field_11')->nullable($value = true);
            $table->tinyInteger('Field_12')->nullable($value = true);
            $table->tinyInteger('Field_13')->nullable($value = true);
            $table->tinyInteger('Field_14')->nullable($value = true);
            $table->tinyInteger('Field_15')->nullable($value = true);
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
        Schema::dropIfExists('schfee_breakdowns');
    }
}
