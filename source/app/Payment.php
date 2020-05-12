<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * Nama table yang digunakan
     */
    protected $table = 'payments';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "student_id", 
        "financing_category_id", 
        "jenis_pembayaran", 
        "persentase",
    ];

    /**
     * Relasi One to Many
     */
    public function detail()
    {
        return $this->hasMany('App\PaymentDetail');
    }

    /**
     * Relasi Many to Many
     */
    public function user()
    {
        return $this->belongsToMany('App\User');
    }

    public function periode()
    {
        return $this->belongsToMany('App\PaymentPeriode','payment_details','payment_id','payment_periode_id');
    }
 
    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }

    public function category()
    {
        return $this->belongsTo('App\FinancingCategory', 'financing_category_id');
    }
}
