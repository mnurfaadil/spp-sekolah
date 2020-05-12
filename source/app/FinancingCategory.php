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
        "jenis",
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
        return $this->hasMany('App\FinancingCategoryReset');
    }

    public function periode()
    {
        return $this->hasMany('App\PaymentPeriode');
    }

    public function payment()
    {
        return $this->hasMany('App\Payment');
    }
    
    public function pembayaran()
    {
        return $this->belongsToMany('App\Student', 'payments', 'financing_category_id', 'student_id')->withPivot('id','persentase', 'jenis_pembayaran','keterangan','updated_at');
    }
}
