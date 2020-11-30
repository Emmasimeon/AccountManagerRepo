<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trx_schfee_balance extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'Trx_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = [''];

    /**
     * Establishing an inverse one to one relationship between a school fees payment and school fees balance
     * for a student.
     */
    public function SchoolFees()
    {
        return $this->belongsTo('App\trx_schfee', 'Trx_id', 'Trx_id');
    }
}
