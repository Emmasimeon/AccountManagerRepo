<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trx_schfee extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'Trx_id';

    /**
     * Establishing a one to one relationship between a school fees payment and school fees balance
     * for a student.
     */
    public function balance()
    {
        return $this->hasOne('App\trx_schfee_balance', 'Trx_id', 'Trx_id');
    }

    /**
     * Establishing a one to one relationship between a school fees payment and the payment mode
     * for a student.
     */
    public function payment_mode()
    {
        return $this->hasOne('App\payment_modes', 'payment_mode', 'payment_mode.id');
    }
}
