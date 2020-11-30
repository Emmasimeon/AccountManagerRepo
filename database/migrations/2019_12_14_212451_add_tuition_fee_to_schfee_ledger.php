<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTuitionFeeToSchfeeLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schfee_ledgers', function (Blueprint $table) {
            $table->integer('tuition_fee_paid')->nullable($value = true);
            $table->integer('tuition_fee_discount')->nullable($value = true);
            $table->integer('tuition_fee_balance')->nullable($value = true);
            $table->integer('ict_fee_paid')->nullable($value = true);
            $table->integer('ict_fee_discount')->nullable($value = true);
            $table->integer('ict_fee_balance')->nullable($value = true);
            $table->integer('pta_fee_paid')->nullable($value = true);
            $table->integer('pta_fee_discount')->nullable($value = true);
            $table->integer('pta_fee_balance')->nullable($value = true);
            $table->integer('boarding_fee_paid')->nullable($value = true);           
            $table->integer('boarding_fee_discount')->nullable($value = true);           
            $table->integer('boarding_fee_balance')->nullable($value = true);           
            $table->integer('utility_fee_paid')->nullable($value = true);           
            $table->integer('utility_fee_discount')->nullable($value = true);           
            $table->integer('utility_fee_balance')->nullable($value = true);           
            $table->integer('development_levy_paid')->nullable($value = true);            
            $table->integer('development_levy_discount')->nullable($value = true);            
            $table->integer('development_levy_balance')->nullable($value = true);            
            $table->integer('books_paid')->nullable($value = true);            
            $table->integer('books_discount')->nullable($value = true);            
            $table->integer('books_balance')->nullable($value = true);            
            $table->integer('uniforms_paid')->nullable($value = true);      
            $table->integer('uniforms_discount')->nullable($value = true);      
            $table->integer('uniforms_balance')->nullable($value = true);      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schfee_ledgers', function (Blueprint $table) {
            $table->dropColumn('tuition_fee_paid');
            $table->dropColumn('tuition_fee_discount');
            $table->dropColumn('tuition_fee_balance');
            $table->dropColumn('ict_fee_paid');
            $table->dropColumn('ict_fee_discount');
            $table->dropColumn('ict_fee_balance');
            $table->dropColumn('pta_fee_paid');
            $table->dropColumn('pta_fee_discount');
            $table->dropColumn('pta_fee_balance');
            $table->dropColumn('boarding_fee_paid');           
            $table->dropColumn('boarding_fee_discount');           
            $table->dropColumn('boarding_fee_balance');           
            $table->dropColumn('utility_fee_paid');           
            $table->dropColumn('utility_fee_discount');           
            $table->dropColumn('utility_fee_balance');           
            $table->dropColumn('development_levy_paid');            
            $table->dropColumn('development_levy_discount');            
            $table->dropColumn('development_levy_balance');            
            $table->dropColumn('books_paid');            
            $table->dropColumn('books_discount');            
            $table->dropColumn('books_balance');            
            $table->dropColumn('uniforms_paid');      
            $table->dropColumn('uniforms_discount');      
            $table->dropColumn('uniforms_balance');    
        });
    }
}
