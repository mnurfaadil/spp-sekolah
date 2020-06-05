<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentDetail;
use App\Payment;
use App\Pencatatan;
use App\Expense;
use App\Income;
use Auth;
use PDF;

class MenuRekapController extends Controller
{
    public function indexPemasukan()
    {
        $no = 1;
        $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
            ->join('incomes','incomes.id','=','pencatatans.income_id')
            ->where([
                ['debit','<>','0'],
            ])->get();
        $filter = '';
        $pilihan = '';
        return view('export.menu.pemasukan',compact('no','datas', 'filter', 'pilihan'));
    }

    public function indexPemasukanFilter(Request $request)
    {
        $no = 1;
        $filter = $request->filter;
        $pilihan = $request->pilihan;
        switch ($request->filter) {
            case 'harian':
                //Query Filter Harian
                $datas = Pencatatan::orderBy('incomes.updated_at', 'desc')
                    ->join('incomes','incomes.id','=','pencatatans.income_id')
                    ->whereDate('incomes.created_at', $request->pilihan)
                    ->get();
                break;

            case 'bulanan':
                //Query Filter Bulanan
                $temp = $request->pilihan;
                $_temp = explode('-', $temp);
                $datas = Pencatatan::orderBy('incomes.updated_at', 'desc')
                    ->join('incomes','incomes.id','=','pencatatans.income_id')
                    ->whereMonth('incomes.created_at', $_temp[1])
                    ->whereYear('incomes.created_at', $_temp[0])
                    ->get();
                break;

            case 'tahunan':
                //Query Filter Tahun
                $datas = Pencatatan::orderBy('incomes.updated_at', 'desc')
                    ->join('incomes','incomes.id','=','pencatatans.income_id')
                    ->whereYear('incomes.created_at', '=', $request->pilihan)
                    ->where([
                        ['debit','<>','0'],
                    ])
                    ->get();
                break;
            
            default:
                //Query Filter Tahun
                $datas = Pencatatan::orderBy('incomes.updated_at', 'desc')
                    ->join('incomes','incomes.id','=','pencatatans.income_id')
                    ->where([
                        ['debit','<>','0'],
                    ])
                    ->get();
        }
        return view('export.menu.pemasukan',compact('no','datas', 'filter', 'pilihan'));
    }
    
    public function indexPengeluaran()
    {
        $no = 1;
        $datas = Expense::orderBy('expenses.updated_at', 'desc')
            ->get();
        $filter = '';
        $pilihan = '';
        return view('export.menu.pengeluaran',compact('no','datas','filter','pilihan'));
    }

    public function indexPengeluaranFilter(Request $request)
    {
        $no = 1;
        switch ($request->filter) {
            case 'harian':
                //Query Filter Harian
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->whereDate('expenses.created_at', $request->pilihan)
                    ->get();
                break;

            case 'bulanan':
                //Query Filter Bulanan
                $temp = $request->pilihan;
                $_temp = explode('-', $temp);
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->whereMonth('expenses.created_at', $_temp[1])
                    ->whereYear('expenses.created_at', $_temp[0])
                    ->get();
                break;

            case 'tahunan':
                //Query Filter Tahun
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->whereYear('expenses.created_at', '=', $request->pilihan)
                    ->get();
                break;
            default:
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->get();
        }
        $filter = $request->filter;
        $pilihan = $request->pilihan;
        return view('export.menu.pengeluaran',compact('no','datas','filter','pilihan'));
    }

    public function indexTunggakan($stat = 'Siswa')
    {
        $datas = Payment::
                // join('payments', 'payments.id', '=', 'payment_details.payment_id')
                join('students', 'students.id', '=', 'payments.student_id')
                ->join('payment_details', 'payment_details.payment_id', '=', 'payments.id')
                ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                ->orderBy('students.id')
                // ->groupBy('payments.financing_category_id')
                // ->groupBy('students.id')
                ->where('jenis_pembayaran','<>','Tunai')
                ->where('payment_details.status','<>','Lunas')->get();
                // ->where('status','<>','Lunas')->get();
        $temp = $datas[0];
        echo '<pre>';
        $no = 1;
        echo '<pre>';
        // var_dump($temp);die;
        foreach ($datas as $key => $value) {
            printf("%u | %s | %s | %s | %s | %s | %s <hr>", $no, $value->student->nama, $value->category->nama, $value->bulan, $value->nominal, $value->jenis_pembayaran, $value->status);
            // printf("%u\t| %s | %s | %s | %s | %s | %s %s | %s. <hr>", $no, $value->status, $value->payment->student->nama, $value->payment->student->kelas, $value->payment->student->major->nama, $value->payment->student->angkatans->angkatan, $value->payment->category->nama, $value->bulan, $value->periode->nominal);
            $no++;
        }
        die;
        if ($stat == 'Siswa')
        {

        }
        else
        {

        }
        $no = 1;
        switch ($request->filter) {
            case 'harian':
                //Query Filter Harian
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->whereDate('expenses.created_at', $request->pilihan)
                    ->get();
                break;

            case 'bulanan':
                //Query Filter Bulanan
                $temp = $request->pilihan;
                $_temp = explode('-', $temp);
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->whereMonth('expenses.created_at', $_temp[1])
                    ->whereYear('expenses.created_at', $_temp[0])
                    ->get();
                break;

            case 'tahunan':
                //Query Filter Tahun
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->whereYear('expenses.created_at', '=', $request->pilihan)
                    ->get();
                break;
            default:
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->get();
        }
        $filter = $request->filter;
        $pilihan = $request->pilihan;
        return view('export.menu.pengeluaran',compact('no','datas','filter','pilihan'));
    }

    public function indexBB()
    {
        $no = 1;
        $datas = Pencatatan::all();
        $filter = '';
        $pilihan = '';
        return view('export.menu.buku_besar',compact('no','datas','filter','pilihan'));
    }

    public function indexBukuBesarFilter(Request $request)
    {
        $no = 1;
        switch ($request->filter) {
            case 'harian':
                //Query Filter Harian
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                    ->whereDate('pencatatans.created_at', $request->pilihan)
                    ->get();
                break;
            case 'bulanan':
                //Query Filter Bulanan
                $temp = $request->pilihan;
                $_temp = explode('-', $temp);
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                    ->whereMonth('pencatatans.created_at', $_temp[1])
                    ->whereYear('pencatatans.created_at', $_temp[0])
                    ->get();
                break;
            case 'tahunan':
                //Query Filter Tahun
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                    ->whereYear('pencatatans.created_at', '=', $request->pilihan)
                    ->get();
                break;
            default:
                $datas = Pencatatan::all();
        }
        $filter = $request->filter;
        $pilihan = $request->pilihan;
        return view('export.menu.buku_besar',compact('no','datas','filter','pilihan'));
    }

    /**
     * Report Pengeluaran
     */
    public function pengeluaran(Request $request)
    {
        $t = now(); 

        $t = explode(" ", $t);
        $t = explode("-", $t[0]);
        $tanggal = "{$t[2]} {$t[1]} {$t[0]}";
        $no=1;

        $user= Auth::user()->nama;
        $rincian = "Pengeluaran";
        $title = "Laporan Pengeluaran";
        switch ($request->filter) {
            case 'harian':
                //Query Filter Harian
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->whereDate('expenses.created_at', $request->pilihan)
                    ->get();
                break;

            case 'bulanan':
                //Query Filter Bulanan
                $temp = $request->pilihan;
                $_temp = explode('-', $temp);
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->whereMonth('expenses.created_at', $_temp[1])
                    ->whereYear('expenses.created_at', $_temp[0])
                    ->get();
                break;

            case 'tahunan':
                //Query Filter Tahun
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->whereYear('expenses.created_at', '=', $request->pilihan)
                    ->get();
                break;
            default:
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->get();
        }
        $pdf = PDF::loadView('export.pengeluaran',compact('tanggal','user','rincian','datas','no','title'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    /**
     * Report Pemasukan
     */
    public function pemasukan(Request $request)
    {
        $t = now(); 

        $t = explode(" ", $t);
        $t = explode("-", $t[0]);
        $tanggal = "{$t[2]} {$t[1]} {$t[0]}";
        $no=1;

        $user= Auth::user()->nama;

        switch ($request->filter) {
            case 'harian':
                //Query Filter Harian
                $datas = Pencatatan::orderBy('incomes.updated_at', 'desc')
                    ->join('incomes','incomes.id','=','pencatatans.income_id')
                    ->whereDate('incomes.created_at', $request->pilihan)
                    ->get();
                break;

            case 'bulanan':
                //Query Filter Bulanan
                $temp = $request->pilihan;
                $_temp = explode('-', $temp);
                $datas = Pencatatan::orderBy('incomes.updated_at', 'desc')
                    ->join('incomes','incomes.id','=','pencatatans.income_id')
                    ->whereMonth('incomes.created_at', $_temp[1])
                    ->whereYear('incomes.created_at', $_temp[0])
                    ->get();
                break;

            case 'tahunan':
                //Query Filter Tahun
                $datas = Pencatatan::orderBy('incomes.updated_at', 'desc')
                    ->join('incomes','incomes.id','=','pencatatans.income_id')
                    ->whereYear('incomes.created_at', '=', $request->pilihan)
                    ->where([
                        ['debit','<>','0'],
                    ])
                    ->get();
                break;
            
            default:
                //Query Filter Tahun
                $datas = Pencatatan::orderBy('incomes.updated_at', 'desc')
                    ->join('incomes','incomes.id','=','pencatatans.income_id')
                    ->where([
                        ['debit','<>','0'],
                    ])
                    ->get();
        }
        $rincian = "Pemasukan";
        $title = "Laporan Pemasukan";
        $pdf = PDF::loadView('export.pemasukan',compact('tanggal','user','rincian','datas','no','title'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    /**
     * Report Buku Besar
     */
    public function bukuBesar(Request $request)
    {
        $t = now(); 

        $t = explode(" ", $t);
        $t = explode("-", $t[0]);
        $tanggal = "{$t[2]} {$t[1]} {$t[0]}";
        $no=1;

        $user= Auth::user()->nama;
        switch ($request->filter) {
            case 'harian':
                //Query Filter Harian
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                    ->whereDate('pencatatans.created_at', $request->pilihan)
                    ->get();
                break;

            case 'bulanan':
                //Query Filter Bulanan
                $temp = $request->pilihan;
                $_temp = explode('-', $temp);
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                    ->whereMonth('pencatatans.created_at', $_temp[1])
                    ->whereYear('pencatatans.created_at', $_temp[0])
                    ->get();
                break;

            case 'tahunan':
                //Query Filter Tahun
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                    ->whereYear('pencatatans.created_at', '=', $request->pilihan)
                    ->get();
                break;
            default:
                $datas = Pencatatan::all();
        }
        $rincian = "Buku Besar";
        $title = "Buku Besar";
        $pdf = PDF::loadView('export.bukubesar',compact('tanggal','user','rincian','datas','no','title'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    /**
     * Filtering untuk kategori pengeluaran
     * @return Expense
     */
    public function ajaxPengeluaran($stat)
    {
        switch ($stat) {
            case 'harian':
                //Filter Tanggal Pengeluaran
                return Expense::selectRaw('DATE_FORMAT(created_at, "%W, %d-%M-%Y") as tanggal, DATE(created_at) as tanggal_value')
                    ->groupBy('tanggal_value')
                    ->orderBy('created_at','DESC')
                    ->get();
                break;
            case 'bulanan':
                //Filter Bulan Pengeluaran
                return Expense::selectRaw('DATE_FORMAT(created_at, "%M-%Y") as tanggal, DATE_FORMAT(created_at, "%Y-%m") as tanggal_value')
                    ->groupBy('tanggal_value')
                    ->orderBy('created_at','DESC')
                    ->get();
                break;
            case 'tahunan':
                //Filter Tahun Pengeluaran
                return Expense::selectRaw('DATE_FORMAT(created_at, "%Y") as tanggal, DATE_FORMAT(created_at, "%Y") as tanggal_value')
                    ->groupBy('tanggal_value')
                    ->orderBy('created_at','DESC')
                    ->get();
                break;
        }   
    }

    /**
     * Filtering untuk kategori pemasukan
     * @return Income
     */
    public function ajaxPemasukan($stat)
    {
        switch ($stat) {
            case 'harian':
                //Filter Tanggal Pengeluaran
                return Income::selectRaw('DATE_FORMAT(created_at, "%W, %d-%M-%Y") as tanggal, DATE(created_at) as tanggal_value')
                    ->groupBy('tanggal_value')
                    ->orderBy('created_at','DESC')
                    ->get();
                break;
            case 'bulanan':
                //Filter Bulan Pengeluaran
                return Income::selectRaw('DATE_FORMAT(created_at, "%M-%Y") as tanggal, DATE_FORMAT(created_at, "%Y-%m") as tanggal_value')
                    ->groupBy('tanggal_value')
                    ->orderBy('created_at','DESC')
                    ->get();
                break;
            case 'tahunan':
                //Filter Tahun Pengeluaran
                return Income::selectRaw('DATE_FORMAT(created_at, "%Y") as tanggal, DATE_FORMAT(created_at, "%Y") as tanggal_value')
                    ->groupBy('tanggal_value')
                    ->orderBy('created_at','DESC')
                    ->get();
                break;
        }   
    }

    /**
     * Filtering untuk kategori Buku Besar
     * @return Pencatatan
     */
    public function ajaxBukuBesar($stat)
    {
        switch ($stat) {
            case 'harian':
                //Filter Tanggal Pengeluaran
                return Pencatatan::selectRaw('DATE_FORMAT(created_at, "%W, %d-%M-%Y") as tanggal, DATE(created_at) as tanggal_value')
                    ->groupBy('tanggal_value')
                    ->orderBy('created_at','DESC')
                    ->get();
                break;
            case 'bulanan':
                //Filter Bulan Pengeluaran
                return Pencatatan::selectRaw('DATE_FORMAT(created_at, "%M-%Y") as tanggal, DATE_FORMAT(created_at, "%Y-%m") as tanggal_value')
                    ->groupBy('tanggal_value')
                    ->orderBy('created_at','DESC')
                    ->get();
                break;
            case 'tahunan':
                //Filter Tahun Pengeluaran
                return Pencatatan::selectRaw('DATE_FORMAT(created_at, "%Y") as tanggal, DATE_FORMAT(created_at, "%Y") as tanggal_value')
                    ->groupBy('tanggal_value')
                    ->orderBy('created_at','DESC')
                    ->get();
                break;
        }   
    }
}
