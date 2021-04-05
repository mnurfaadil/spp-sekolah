<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    /**
     * Nama table yang digunakan
     */
    protected $table = 'angkatans';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "angkatan",
        "tahun",
        "status",
    ];
    
    /**
     * Relasi One to Many
     */ 
    public function students()
    {
        return $this->hasMany('App\Student');
    }

    public function periode_pembayaran()
    {
        return $this->hasMany('App\PaymentPeriode');
    }
}
