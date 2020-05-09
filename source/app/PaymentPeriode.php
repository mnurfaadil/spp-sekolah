<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentPeriode extends Model
{
    /**
     * Nama table yang digunakan
     */
    protected $table = 'payment_periodes';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "financing_category_id",
        "bulan", 
        "tahun", 
        "nominal",
        "major_id",
        "angkatan_id",
    ];

    public function financingCategory()
    {
        return $this->belongsTo('App\FinancingCategory', "financing_category_id");
    }

    public function pembayaran()
    {
        return $this->hasMany('App\PaymentPeriodeDetail');
    }

    public function major()
    {
        return $this->belongsTo('App\Major', "major_id");
    }

    public function angkatan()
    {
        return $this->belongsTo('App\Angkatan', "angkatan_id");
    }    
}
