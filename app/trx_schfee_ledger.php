<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trx_schfee_ledger extends Model
{
    protected $guarded = [''];

    public function student() {
        return $this->belongsTo('App\student');
      }
}
