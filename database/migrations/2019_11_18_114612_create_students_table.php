<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('SAN_id');
            $table->string('regno', 10);
            $table->string('surname', 25);
            $table->string('middlename', 25);
            $table->string('lastname', 25);
            $table->string('sex', 1);
            $table->string('class', 1);
            $table->string('status', 3)->default('101');
            $table->string('PaymentFeeStatus', 20)->default('Regular');
            $table->string('accomodation', 10)->default('Day');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE students AUTO_INCREMENT = 101;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
