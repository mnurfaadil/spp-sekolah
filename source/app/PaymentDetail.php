<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    /**
     * Nama table yang digunakan
     */
    protected $table = 'payment_details';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "payment_id",
        "payment_periode_id",
        "user_id",
        "tgl_dibayar",
        "bulan",
        "nominal",
        "status",
    ];

    public function user()
    {
        return $this->belongsTo('App\User', "user_id");
    }

    public function payment()
    {
        return $this->belongsTo('App\Payment','payment_id');
    }

    public function periode()
    {
        return $this->belongsTo('App\PaymentPeriode','payment_periode_id');
    }

    public function cicilan()
    {
        return $this->hasMany('App\Cicilan');
    }

}
