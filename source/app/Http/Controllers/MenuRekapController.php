<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentDetail;
use App\Payment;
use App\Pencatatan;
use App\Expense;
use App\Income;
use Auth;
use Illuminate\Support\Facades\DB;
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
        $no = 1;
        $filter = '';
        $pilihan = '';
        if ($stat == 'Siswa')
        {
            $datas = DB::table('payment_details')
                    ->select(DB::raw('financing_categories.id as financing_category_id,
                    payment_details.id, 
                    payment_details.payment_id,
                    payment_details.payment_periode_id,
                    angkatans.id as angkatan_id,
                    majors.id as major_id,
                    students.nama as nama_murid,
                    students.kelas,
                    angkatans.angkatan,
                    angkatans.tahun as tahun_angkatan,
                    majors.inisial as inisial,
                    majors.nama as jurusan,
                    financing_categories.nama, 
                    count(payment_details.status) as banyak_tunggakan,
                    financing_periodes.nominal,
                    getNominalCicilan(payment_details.id) as cicilan_dibayar,
                    payments.jenis_pembayaran,
                    payments.persentase,
                    payment_details.status'))
                    ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                    ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                    ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                    ->join('students', 'students.id', '=', 'payments.student_id')
                    ->join('majors', 'majors.id', '=', 'students.major_id')
                    ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                    ->orderBy('students.id')
                    ->groupBy('payment_details.payment_id')
                    ->where('payment_details.status','<>','Lunas')
                    ->get();
            $kelas = 'all';
            $jurusan = 'all';
            $angkatan = 'all';
            return view('export.menu.tunggakan',compact('no','datas','filter','pilihan', 'stat', 'kelas', 'jurusan', 'angkatan'));
        }
        else
        {
            $datas = DB::table('payment_details')
                    ->select(DB::raw('financing_categories.id as financing_category_id,
                    payment_details.id, 
                    payment_details.payment_id,
                    payment_details.payment_periode_id,
                    angkatans.id as angkatan_id,
                    majors.id as major_id,
                    students.nama as nama_murid,
                    students.kelas,
                    angkatans.angkatan,
                    angkatans.tahun as tahun_angkatan,
                    majors.inisial as inisial,
                    majors.nama as jurusan,
                    financing_categories.nama, 
                    count(payment_details.status) as banyak_tunggakan,
                    financing_periodes.nominal,
                    getNominalCicilan(payment_details.id) as cicilan_dibayar,
                    payments.jenis_pembayaran,
                    payments.persentase,
                    payment_details.status'))
                    ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                    ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                    ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                    ->join('students', 'students.id', '=', 'payments.student_id')
                    ->join('majors', 'majors.id', '=', 'students.major_id')
                    ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                    ->orderBy('financing_categories.id')
                    ->groupBy('payment_details.payment_id')
                    ->where('payment_details.status','<>','Lunas')
                    ->get();
            return view('export.menu.tunggakan_kategori',compact('no','datas','filter','pilihan', 'stat'));
        }
    }

    public function indexTunggakanFilter(Request $request, $stat = 'Siswa')
    {
        $no = 1;
        $filter = $request->filter;
        $pilihan = '';
        if ($stat == 'Siswa')
        {
            $kelas = $request->kelas;
            $jurusan = $request->jurusan;
            $angkatan = $request->angkatan;
            if ($kelas == 'all' && $jurusan == 'all' && $angkatan == 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->get();
            }
            else if ($kelas != 'all' && $jurusan == 'all' && $angkatan == 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('students.kelas','=', $kelas)
                        ->get();
            }
            else if ($kelas == 'all' && $jurusan != 'all' && $angkatan == 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('majors.id','=', $jurusan)
                        ->get();
            }
            else if ($kelas == 'all' && $jurusan == 'all' && $angkatan != 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('angkatans.id','=', $angkatan)
                        ->get();
            }
            else if ($kelas != 'all' && $jurusan != 'all' && $angkatan == 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('students.kelas','=', $kelas)
                        ->where('majors.id','=', $jurusan)
                        ->get();
            }
            else if ($kelas != 'all' && $jurusan == 'all' && $angkatan != 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('angkatans.id','=', $angkatan)
                        ->where('students.kelas','=', $kelas)
                        ->get();
            }
            else if ($kelas == 'all' && $jurusan != 'all' && $angkatan != 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('angkatans.id','=', $angkatan)
                        ->where('majors.id','=', $jurusan)
                        ->get();
            }
            else
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('angkatans.id','=', $angkatan)
                        ->where('students.kelas','=', $kelas)
                        ->where('majors.id','=', $jurusan)
                        ->get();
            }

            return view('export.menu.tunggakan',compact('no','datas','filter','pilihan', 'stat', 'kelas', 'jurusan', 'angkatan'));
        }
        else
        {
            if ($request->filter == 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                        payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('financing_categories.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->get();
            }
            else
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('financing_categories.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('financing_categories.id','=', $request->filter)
                        ->get();
            }
            return view('export.menu.tunggakan_kategori',compact('no','datas','filter','pilihan', 'stat'));
        }
    }

    public function tunggakan(Request $request)
    {
        $stat = $request->stat;
        $no = 1;
        $filter = $request->filter;
        $pilihan = '';
        $t = now(); 

        $t = explode(" ", $t);
        $t = explode("-", $t[0]);
        $tanggal = "{$t[2]} {$t[1]} {$t[0]}";
        $no=1;

        $user= Auth::user()->nama;
        $rincian = "Tunggakan";
        $title = "Laporan Tunggakan";

        // echo '<pre>';
        // var_dump($request->all());die;

        if ($stat == 'Siswa')
        {
            $kelas = $request->kelas;
            $jurusan = $request->jurusan;
            $angkatan = $request->angkatan;
            if ($kelas == 'all' && $jurusan == 'all' && $angkatan == 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->get();
            }
            else if ($kelas != 'all' && $jurusan == 'all' && $angkatan == 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('students.kelas','=', $kelas)
                        ->get();
            }
            else if ($kelas == 'all' && $jurusan != 'all' && $angkatan == 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('majors.id','=', $jurusan)
                        ->get();
            }
            else if ($kelas == 'all' && $jurusan == 'all' && $angkatan != 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('angkatans.id','=', $angkatan)
                        ->get();
            }
            else if ($kelas != 'all' && $jurusan != 'all' && $angkatan == 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('students.kelas','=', $kelas)
                        ->where('majors.id','=', $jurusan)
                        ->get();
            }
            else if ($kelas != 'all' && $jurusan == 'all' && $angkatan != 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('angkatans.id','=', $angkatan)
                        ->where('students.kelas','=', $kelas)
                        ->get();
            }
            else if ($kelas == 'all' && $jurusan != 'all' && $angkatan != 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('angkatans.id','=', $angkatan)
                        ->where('majors.id','=', $jurusan)
                        ->get();
            }
            else
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('students.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('angkatans.id','=', $angkatan)
                        ->where('students.kelas','=', $kelas)
                        ->where('majors.id','=', $jurusan)
                        ->get();
            }

            $pdf = PDF::loadView('export.rekap_tunggakan_siswa',compact('no','title','datas'));
            //$pdf->setPaper('A4', 'landscape');
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream();
        }
        else
        {
            if ($request->filter == 'all')
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                        payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('financing_categories.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->get();
            }
            else
            {
                $datas = DB::table('payment_details')
                        ->select(DB::raw('financing_categories.id as financing_category_id,
                        payment_details.id, 
                        payment_details.payment_id,
                        payment_details.payment_periode_id,
                        angkatans.id as angkatan_id,
                        majors.id as major_id,
                        students.nama as nama_murid,
                        students.kelas,
                        angkatans.angkatan,
                        angkatans.tahun as tahun_angkatan,
                        majors.inisial as inisial,
                        majors.nama as jurusan,
                        financing_categories.nama, 
                        count(payment_details.status) as banyak_tunggakan,
                        financing_periodes.nominal,
                        getNominalCicilan(payment_details.id) as cicilan_dibayar,
                        payments.jenis_pembayaran,
                    payments.persentase,
                        payment_details.status'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
                        ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->orderBy('financing_categories.id')
                        ->groupBy('payment_details.payment_id')
                        ->where('payment_details.status','<>','Lunas')
                        ->where('financing_categories.id','=', $request->filter)
                        ->get();
            }
            $pdf = PDF::loadView('export.rekap_tunggakan_kategori',compact('no','title','datas'));
            //$pdf->setPaper('A4', 'landscape');
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream();
        }
    }

    public function ajaxTunggakan($stat = 'Siswa', $filter = 'Kelas')
    {
        if ($stat == 'Siswa')
        {
            if ($filter == 'Kelas')
            {
                return DB::table('payment_details')
                        ->select(DB::raw('students.kelas as kategori, students.kelas as kategori_value'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->groupBy('students.kelas')
                        ->where('payment_details.status','<>','Lunas')
                        ->get();
                    }
            else if ($filter == 'Jurusan')
            {
                return DB::table('payment_details')
                        ->select(DB::raw('majors.nama as kategori, majors.id as kategori_value'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('majors', 'majors.id', '=', 'students.major_id')
                        ->groupBy('majors.id')
                        ->where('payment_details.status','<>','Lunas')
                        ->get();
            }
            else
            {
                return DB::table('payment_details')
                        ->select(DB::raw('angkatans.angkatan as kategori, angkatans.tahun as tahun, angkatans.id as kategori_value'))
                        ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                        ->join('students', 'students.id', '=', 'payments.student_id')
                        ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                        ->groupBy('angkatans.id')
                        ->where('payment_details.status','<>','Lunas')
                        ->get();
            }
        }
        else
        {
            return DB::table('payment_details')
            ->select(DB::raw('financing_categories.id as kategori_value,
            financing_categories.nama as kategori'))
            ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
            ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
            ->orderBy('financing_categories.id')
            ->groupBy('financing_categories.id')
            ->where('payment_details.status','<>','Lunas')
            ->get();
        }
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
