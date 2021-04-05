<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pencatatan extends Model
{
    /**
     * Nama table yang digunakan
     */
    protected $table = 'pencatatans';

    /**
     * Kolom yang dapat di isi
     */
    protected $fillable = [
        "description",
        "nominal",
        "debit",
        "kredit",
        "expense_id",
        "income_id",
        "created_at"
    ];

    public function pengeluaran()
    {
        return $this->belongsTo('App\Expense', 'expense_id');
    }

    public function pemasukan()
    {
        return $this->belongsTo('App\Income', 'income_id');
    }
}
