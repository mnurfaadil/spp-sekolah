<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * Nama table yang digunakan
     */
    protected $table = 'students';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "nis",
        "nama",
        "jenis_kelamin",
        "kelas",
        "major_id",
        "phone",
        "angkatan_id",
        "email",
        "alamat",
        "tgl_masuk",
        "simpanan",
    ];

    /**
     * Relasi Many to One
     */
    public function major()
    {
        return $this->belongsTo('App\Major','major_id');
    }

    public function angkatans()
    {
        return $this->belongsTo('App\Angkatan','angkatan_id');
    }

    /**
     * Relasi Many to Many
     */
    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function category()
    {
        return $this->belongsToMany('App\FinancingCategory');
    }
}
