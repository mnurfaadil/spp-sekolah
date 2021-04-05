<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\PaymentDetail;
use App\PaymentPeriode;
use App\Expense;

class PenyesuaianController extends Controller
{

    public function index()
    {
        return view('penyesuaian.index');
    }
    public function ajax()
    {
        if ($_GET)
        {
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'title';
            $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
            $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
            $data = Expense::limit($limit)
                        ->where('title',"like", "%{$search}%")
                        ->offset($offset)
                        ->orderBy($sort, $order)
                        ->orderBy('updated_at', 'desc')
                        ->get()
                        ->toArray();
            $total = Expense::count();
            return array(
                'total' => $total,
                'rows'  => $data
            );
        }
        return array(
            'total' => 0,
            'rows'  => [],
        );
    }
    public function nominal()
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
