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
    ];
    
    /**
     * Relasi One to Many
     */
    public function students()
    {
        return $this->hasMany('App\Student', 'angkatan_id');
    }
}
