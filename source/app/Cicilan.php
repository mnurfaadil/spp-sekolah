<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cicilan extends Model
{
    /**
     * Nama table yang digunakan
     */
    protected $table = 'cicilans';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "payment_detail_id", 
        "user_id", 
        "simpanan", 
        "tunai", 
        "nominal", 
        "keterangan", 
        "created_at",
        "tgl_dibayar"
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function detail()
    {
        return $this->belongsTo('App\PaymentDetail', 'payment_detail_id');
    }

    public function pemasukan()
    {
        return $this->hasMany('App\Income');
    }
}
