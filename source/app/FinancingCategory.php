<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancingCategory extends Model
{
    /** 
     * Nama table yang digunakan
     */
    protected $table = 'financing_categories';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "nama",
        "besaran",
        "jenis"
    ];

    /**
     * Relasi Many to Many
     */
    public function payments()
    {
        return $this->belongsTo('App\Payment');
    }

    /**
     * Relasi One to Many
     */
    public function history()
    {
        return $this->hasMany('App\FinancingCategoryReset', 'financing_category_id');
    }

    public function periode()
    {
        return $this->hasMany('App\PaymentPeriode');
    }

    public function pembayaran()
    {
        return $this->hasMany('App\Payment');
    }
}
