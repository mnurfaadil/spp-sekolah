<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\PaymentDetail;
use App\PaymentPeriode;

class PenyesuaianController extends Controller
{
    public function index()
    {
        $cat = 50;
        //Penyesuaian Nominal
        $payments = Payment::where('financing_category_id', $cat)->get();
        
        foreach ($payments as $i => $payment)
        {
            $detail = PaymentDetail::where('payment_id', $payment->id)
                        ->orderBy('bulan')->get();
            $len = count($detail);
            $nominal = 0;
            for ( $j=0; $j<$len; $j++)
            {
                if ($j==0) {
                    $nominal = $detail[$j]->periode->kelas_x;        
                } else if ($j==12) {
                    $nominal = $detail[$j]->periode->kelas_xi;        
                } else if ($j==24) {
                    $nominal = $detail[$j]->periode->kelas_xii;        
                }
                $detail[$j]->nominal_bayar = $nominal;
                $detail[$j]->save();
            }
        }
        $periodes = PaymentPeriode::where('financing_category_id', $cat)
                ->orderBy('financing_periodes.updated_at','desc')
                ->get();
        //penyesuaian nominal
        foreach ($periodes as $key => $value) {
            $value->kelas_x = $value->nominal;
            $value->kelas_xi = $value->nominal;
            $value->kelas_xii = $value->nominal;
            $value->save();
        }

        return "succes";
    }
}
