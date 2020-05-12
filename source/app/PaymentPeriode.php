<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentPeriode extends Model
{
    /**
     * Nama table yang digunakan
     */
    protected $table = 'financing_periodes';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "financing_category_id",
        "angkatan_id",
        "major_id",
        "nominal",
    ];

    public function category()
    {
        return $this->belongsTo('App\FinancingCategory', "financing_category_id");
    }

    public function pembayaran()
    {
        return $this->hasMany('App\PaymentDetail');
    }

    public function major()
    {
        return $this->belongsTo('App\Major', "major_id");
    }

    public function angkatan()
    {
        return $this->belongsTo('App\Angkatan', "angkatan_id");
    }    

    public function payment()
    {
        return $this->belongsToMany('App\Payment', 'payment_details', 'payment_periode_id', 'payment_id');
    }
}
