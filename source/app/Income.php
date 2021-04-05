<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    /**
     * Nama table yang digunakan
     */
    protected $table = 'incomes';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "title",
        "description",
        "sumber",
        "foto",
        "nominal",
        "created_at",
        "tipe",
        "payment_detail_id",
        "cicilan_id"
    ];

    public function pencatatan()
    {
        return $this->hasMany('App\Pencatatan');
    }

    public function detail()
    {
        return $this->belongsTo('App\PaymentDetail', 'payment_detail_id');
    }

    public function cicilan()
    {
        return $this->belongsTo('App\Cicilan', 'cicilan_id');
    }
}
