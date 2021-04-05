<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancingCategoryReset extends Model
{
    /**
     * Nama table yang digunakan
     */
    protected $table = 'financing_category_resets';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "financing_category_id", 
        "besaran",
        "jenis",
    ];

    public function category()
    {
        return $this->belongsTo('App\FinancingCategory', 'financing_category_id');
    }
}
