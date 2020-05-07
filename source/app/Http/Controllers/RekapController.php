<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Pencatatan;
use App\Student;
use App\FinancingCategory; 
use App\Payment; 
use App\PaymentDetail;
use App\PaymentPeriode;
use App\PaymentPeriodeDetail;
use App\Major;
use App\Expense;

use PDF; 
use DB; 
class RekapController extends Controller
{
    public function __construct()
    { 
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = FinancingCategory::all();
        $majors = Major::all();
        $rekap = DB::table('rekap_view')->first();
        return view('export.index',compact('categorys','majors','rekap'));
    }


    // public function getTerbilang($nominal)
    // {
    //     echo strlen($nominal);
    // }

    public function FunctionName(Type $var = null)
    {
        # code...
    }

    public function print(Request $request) 
    {
        $req= $request->all();
        $t = now();

        $t = explode(" ", $t);
        $t = explode("-", $t[0]);
        $tanggal = "{$t[2]} {$t[1]} {$t[0]}";
        $no=1;

        $user= Auth::user()->nama;
        if($request->id=="pemasukan"){ 
            $rincian = "Pemasukan";
            if(isset($request->bulan) && isset($request->tahun)){
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                        ->join('incomes','incomes.id','=','pencatatans.income_id')
                        ->whereMonth('incomes.updated_at','=',$request->bulan)
                        ->whereYear('incomes.updated_at','=',$request->year)
                        ->where('debit','<>','0')->get();
            }
            elseif(isset($request->tahun)){   
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                        ->join('incomes','incomes.id','=','pencatatans.income_id')
                        ->whereYear('incomes.updated_at','=',$request->year)
                        ->where('debit','<>','0')->get();
            }
            elseif(isset($request->bulan)){
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                        ->join('incomes','incomes.id','=','pencatatans.income_id')
                        ->whereMonth('incomes.updated_at','=',$request->bulan)
                        ->where('debit','<>','0')->get();
            }else{
                $datas = Pencatatan::where('debit','<>','0')
                        ->orderBy('id', 'desc')
                        ->where('debit','<>','0')->get();
            }
            $title = "Laporan Pemasukan";
            $pdf = PDF::loadView('export.pemasukan',compact('tanggal','user','rincian','datas','no','title'));
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream();
        }elseif($request->id=="pengeluaran"){
            $rincian = "Pengeluaran";
            $title = "Laporan Pengeluaran";

            if ($request->bulan == '' && $request->tahun!='') {
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->join('pencatatans','expenses.id','=','pencatatans.expense_id')
                    ->whereYear('expenses.expenses.updated_at',$request->tahun)
                    ->where('pencatatans.kredit','<>','0')
                    ->get();
            }elseif ($request->bulan != '' && $request->tahun=='') {
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->join('pencatatans','expenses.id','=','pencatatans.expense_id')
                    ->whereMonth('expenses.updated_at',$request->bulan)
                    ->where('pencatatans.kredit','<>','0')
                    ->get();
            }elseif ($request->bulan == '' && $request->tahun=='') {
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->join('pencatatans','expenses.id','=','pencatatans.expense_id')
                    ->where('pencatatans.kredit','<>','0')
                    ->get();
            }else{
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                ->join('pencatatans','expenses.id','=','pencatatans.expense_id')
                    ->whereMonth('expenses.updated_at',$request->bulan)
                    ->whereYear('expenses.updated_at',$request->tahun)
                    ->where('pencatatans.kredit','<>','0')
                    ->get();
            }
            $pdf = PDF::loadView('export.pengeluaran',compact('tanggal','user','rincian','datas','no','title'));
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream();

        }elseif($request->id=="Buku Besar"){
            $rincian = "Buku Besar";
            $title = "Laporan Keuangan";
            $datas = Pencatatan::all();
            $pdf = PDF::loadView('export.bukubesar',compact('tanggal','user','rincian','datas','no','title'));
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream();
        }
    }

    public function kwitansi()
    {
        $pdf = PDF::loadView('export.siswa');
        return $pdf->stream();
    }

    public function rekapSiswa(Request $request)
    {
        $kls = $request->kls;
        $jur = $request->id_jur;
        $akt = $request->akt;

        if($kls=='' && $jur!='' && $akt==''){
            $students = DB::table('students')
                ->select('students.*','angkatans.*')
                ->join('angkatans','students.angkatan_id','=','angkatans.id')
                ->where('students.major_id',$jur)->get();
        }elseif ($jur=='' && $kls!='' && $akt=='') {
            $students = DB::table('students')
                ->select('students.*','angkatans.*')
                ->join('angkatans','students.angkatan_id','=','angkatans.id')
                ->where('students.kelas',$kls)->get();
        }elseif ($jur=='' && $kls=='' && $akt!='') {
            $students = DB::table('students')
                ->select('students.*','angkatans.*')
                ->join('angkatans','students.angkatan_id','=','angkatans.id')
                ->where('students.angkatan_id',$akt)->get();
        }elseif ($jur!='' && $kls!='' && $akt=='') {
            $students = DB::table('students')
                ->select('students.*','angkatans.*')
                ->join('angkatans','students.angkatan_id','=','angkatans.id')
                ->where('students.kelas',$kls)
                ->where('students.major_id',$jur)
                ->get();
        }elseif ($jur=='' && $kls!='' && $akt!='') {
            $students = DB::table('students')
                ->select('students.*','angkatans.*')
                ->join('angkatans','students.angkatan_id','=','angkatans.id')
                ->where('students.angkatan_id',$akt)
                ->where('students.kelas',$kls)
                ->get();
        }elseif ($jur!='' && $kls=='' && $akt!='') {
            $students = DB::table('students')
                ->select('students.*','angkatans.*')
                ->join('angkatans','students.angkatan_id','=','angkatans.id')
                ->where('students.angkatan_id',$akt)
                ->where('students.major_id',$jur)
                ->get();
        }elseif ($jur!='' && $kls!='' && $akt!='') {
            $students = DB::table('students')
                ->select('students.*','angkatans.*')
                ->join('angkatans','students.angkatan_id','=','angkatans.id')
                ->where('students.angkatan_id',$akt)
                ->where('students.major_id',$jur)
                ->where('students.kelas',$kls)
                ->get();
        }else{
            $students = DB::table('students')
                ->select('students.*','angkatans.*')
                ->join('angkatans','students.angkatan_id','=','angkatans.id')
                ->get();
        }

        $no = 1;
        $title = "Data Siswa";
        $majors = Major::where('id',$jur)->first();
        $pdf = PDF::loadView('export.siswa',compact('students','no','title','kls','jur','majors'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    public function listdata()
    {
        $pdf = PDF::loadView('export.kwitansi');
        // $pdf->setPaper('A4', 'landscape');
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    public function rekapBulanan($kategori, $id, $filter = null)
    {
        $no = 1;
        if(!$filter){
        $datas=DB::table('students')
            ->selectRaw('students.*,getNominalTerbayarBulanan(payments.id) AS terbayar, getCountBulananTidakTerbayar(payments.id) AS bulan_tidak_bayar, getCountNunggak(payments.id) as cekNunggak, getCountWaiting(payments.id) AS cekWaiting, majors.nama AS jurusan, getAkumulasiPerBulan(payments.id) AS akumulasi, financing_categories.`nama` AS financing_nama, financing_categories.id AS financing_id, payments.`id` AS payment_id, payments.`jenis_pembayaran`')
            ->leftJoin('majors','majors.id','=','students.major_id')
            ->leftJoin('payments','payments.student_id','=','students.id')
            ->leftJoin('financing_categories','financing_categories.id','=','payments.financing_category_id')
            ->leftJoin('payment_details','payment_details.payment_id','=','payments.id')
            ->where('financing_categories.id',$id)->get();
        }else{
        $datas=DB::table('students')
            ->selectRaw('students.*,getNominalTerbayarBulanan(payments.id) AS terbayar, getCountBulananTidakTerbayar(payments.id) AS bulan_tidak_bayar, getCountNunggak(payments.id) as cekNunggak, getCountWaiting(payments.id) AS cekWaiting, majors.nama AS jurusan, getAkumulasiPerBulan(payments.id) AS akumulasi, financing_categories.`nama` AS financing_nama, financing_categories.id AS financing_id, payments.`id` AS payment_id, payments.`jenis_pembayaran`')
            ->leftJoin('majors','majors.id','=','students.major_id')
            ->leftJoin('payments','payments.student_id','=','students.id')
            ->leftJoin('financing_categories','financing_categories.id','=','payments.financing_category_id')
            ->leftJoin('payment_details','payment_details.payment_id','=','payments.id')
            ->where([
                ['financing_categories.id','=',$id],
                ['majors.id','=',$filter],
            ])->get();
        }
        $title="Rekapitulasi Pembiayaan {$kategori}";
        $pdf = PDF::loadView('export.rekap_bulanan',compact('no','title','datas'));
        //$pdf->setPaper('A4', 'landscape');
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    public function kwitansiBulananSatuan($siswa, $detail)
    {
        $no = 1;
        $user= Auth::user()->name;
        $siswa = Student::where('id',$siswa)->first();
        $data = PaymentPeriodeDetail::where('id',$detail)->first();
        $bulan=$this->convertToBulan($data['periode']->bulan);
        $d = "Pembayaran {$data['periode']->financingCategory->nama} untuk periode bulan {$bulan} tahun {$data['periode']->tahun}";
        
        $data['tanggal'] = $this->getTanggalHariIni();
        $data['waktu'] = $this->getWaktuHariIni();
        $data['desc'] = $d;

        
        
        
        $pdf = PDF::loadView('export.kwitansi_bulanan_satuan',compact('user','siswa','data','no'));
        //$pdf->setPaper('A4', 'landscape');
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
    
    public function kwitansiBulanan($siswa, $payment)
    {
        $no = 1;
        $user= Auth::user()->name;
        $siswa = Student::where('id',$siswa)->first();
        $datas = PaymentPeriodeDetail::where([
            ['payment_id','=',$payment],
            ['status','=',"Lunas"]
        ])->join('payment_periodes','payment_periodes.id','payment_periode_details.payment_periode_id')
        ->orderBy('payment_periodes.bulan','asc')
        ->orderBy('payment_periodes.tahun','asc')
        ->get();
        try {
            $data['tanggal'] = $this->getTanggalHariIni();
            $data['waktu'] = $this->getWaktuHariIni();
            $data['nis'] = $datas[0]->payment->student->nis;
            $data['nama'] = $datas[0]->payment->student->nama;
            $data['kelas'] = $datas[0]->payment->student->kelas;
            $data['jurusan'] = $datas[0]->payment->student->major->nama;
        } catch (Throwable $th) {
            abort(500);die;
        }
        
        $pdf = PDF::loadView('export.kwitansi_rekap',compact('user','siswa','data','no','datas'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!isset($request->jenis_kategori) || !isset($request->major_id) || !isset($request->kelas)) {
            abort(404);
        }

        $req = $request->all();

        $kategori = FinancingCategory::findOrFail($request->jenis_kategori);
        
        $no =1;
        $title="Rekapitulasi Tunggakan {$kategori['nama']}";
        
        if($kategori['jenis']=="Bayar per Bulan"){
            $datas=DB::table('students')
                ->selectRaw('students.*,getNominalTerbayarBulanan(payments.id) AS terbayar, getCountBulananTidakTerbayar(payments.id) AS bulan_tidak_bayar, getCountNunggak(payments.id) as cekNunggak, getCountWaiting(payments.id) AS cekWaiting, majors.nama AS jurusan, getAkumulasiPerBulan(payments.id) AS akumulasi, financing_categories.`nama` AS financing_nama, financing_categories.id AS financing_category_id, payments.`id` AS payment_id, payments.`jenis_pembayaran`')
                ->leftJoin('majors','majors.id','=','students.major_id')
                ->leftJoin('payments','payments.student_id','=','students.id')
                ->leftJoin('financing_categories','financing_categories.id','=','payments.financing_category_id')
                ->leftJoin('payment_periode_details','payment_periode_details.payment_id','=','payments.id')
                ->get();
            if($req['jenis_kategori'] != "all"){
                $datas = $datas->where('financing_category_id', $req['jenis_kategori']);
            }
            if($req['major_id'] != "all"){
                $datas = $datas->where('major_id', $req['major_id']);
            }
            if($req['kelas'] != "all"){
                $datas = $datas->where('kelas', $req['kelas']);
            }
            $pdf = PDF::loadView('export.tunggakan',compact('no','title','datas'));
            //$pdf->setPaper('A4', 'landscape');
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream();
        }else{
            $datas = DB::table('students')
                        ->selectRaw('financing_categories.id as financing_category_id, students.id as student_id, payments.id as payment_id, majors.id as major_id, payment_details.id as payment_detail_id, students.nama, students.`kelas`, majors.`nama` AS jurusan, financing_categories.`besaran` AS akumulasi, (SELECT SUM(nominal) FROM payment_details pd2 WHERE pd2.`id` = payment_details.id ) AS terbayar,(SELECT jenis_pembayaran FROM payments p2 WHERE p2.id = payments.id) AS metode')
                        ->join('majors','majors.id','=','students.major_id')
                        ->join('payments','payments.student_id','=','students.id')
                        ->join('financing_categories','financing_categories.id','=','payments.financing_category_id')
                        ->join('payment_details','payment_details.payment_id','=','payments.id')
                        ->orderBy
                        ->get();
            if($req['jenis_kategori'] != "all"){
                $datas = $datas->where('financing_category_id', $req['jenis_kategori']);
            }
            if($req['major_id'] != "all"){
                $datas = $datas->where('major_id', $req['major_id']);
            }
            if($req['kelas'] != "all"){
                $datas = $datas->where('kelas', $req['kelas']);
            }
            $pdf = PDF::loadView('export.tunggakan_sekali',compact('no','title','datas'));
            //$pdf->setPaper('A4', 'landscape');
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream();
        }
    }
    //Method untuk pencetakan laporan kategori sekali bayar
    public function rekapSesekali($kategori, $id, $filter = null)
    {
        $no = 1;
        $datas=DB::table('students')
            ->selectRaw('students.*,getNominalSekaliBayarTerbayar(students.id,financing_categories.id) AS terbayar, getCountBulananTidakTerbayar(payments.id) AS bulan_tidak_bayar, getCountNunggak(payments.id) as cekNunggak, getCountWaiting(payments.id) AS cekWaiting, majors.nama AS jurusan, financing_categories.besaran AS akumulasi, financing_categories.`nama` AS financing_nama, financing_categories.id AS financing_id, payments.`id` AS payment_id, payments.`jenis_pembayaran`')
            ->leftJoin('majors','majors.id','=','students.major_id')
            ->leftJoin('payments','payments.student_id','=','students.id')
            ->leftJoin('financing_categories','financing_categories.id','=','payments.financing_category_id')
            ->leftJoin('payment_details','payment_details.payment_id','=','payments.id')
            ->where([
                ['financing_categories.id','=',$id],
            ])->get();
        $title="Rekapitulasi Pembiayaan {$kategori}";
        $pdf = PDF::loadView('export.rekap_sekali',compact('no','title','datas'));
        //$pdf->setPaper('A4', 'landscape');
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    /**
     * Pencetakan Bukti Pembayaran (kwitansi) kategori Sekali Bayar
     */
    public function kwitansiSesekaliSatuan($siswa, $detail)
    {
        $no = 1;
        $user= Auth::user()->name;
        $siswa = Student::where('id',$siswa)->first();
        $data = PaymentDetail::where('id',$detail)->first();
        $idx_bulan = $this->convertSqlDateToMonth($data['tgl_dibayar']);
        $bulan=$this->convertToBulan($idx_bulan);
        $d = "Pembayaran {$data['payment']->category->nama}";
        
        $data['tanggal'] = $this->getTanggalHariIni();
        $data['waktu'] = $this->getWaktuHariIni();
        $data['desc'] = $d;

        $pdf = PDF::loadView('export.kwitansi_sekali_satuan',compact('user','siswa','data','no'));
        //$pdf->setPaper('A4', 'landscape');
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    public function kwitansiSesekali($siswa, $payment)
    {
        $no = 1;
        $user= Auth::user()->name;
        $siswa = Student::where('id',$siswa)->first();
        $datas = PaymentDetail::where([
            ['payment_id','=',$payment],
            ['status','<>',"Waiting"]
        ])->get();
        try {
            $data['tanggal'] = $this->getTanggalHariIni();
            $data['waktu'] = $this->getWaktuHariIni();
            $data['nis'] = $datas[0]->payment->student->nis;
            $data['nama'] = $datas[0]->payment->student->nama;
            $data['kelas'] = $datas[0]->payment->student->kelas;
            $data['jurusan'] = $datas[0]->payment->student->major->nama;
        } catch (Throwable $th) {
            abort(500);die;
        }
        
        $pdf = PDF::loadView('export.kwitansi_sekali_rekap',compact('user','siswa','data','no','datas'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTanggalHariIni()
    {
        $t = now();
        $t = explode(" ",$t);
        $t = explode("-", $t[0]);
        $d = intval($t[2]);
        return $d." ".$this->convertToBulan($t[1])." ".$t[0];
    }

    public function getWaktuHariIni()
    {
        $t = now();
        $t = explode(" ",$t);
        return $t[1];
    }

    public function convertSqlDateToIdDate($sql)
    {
        $t = explode(" ",$sql);
        $t = explode("-", $t[0]);
        $d = intval($t[2]);
        return $d." ".$this->convertToBulan($t[1])." ".$t[0];
    }

    public function convertSqlDateToHour($sql)
    {
        $t = explode(" ",$sql);
        return $t[1];
    }
    
    public function convertSqlDateToMonth($sql)
    {
        $t = explode("-",$sql);
        return $t[1];
    }

    public function convertToBulan($id=1)
    {
        $id=intval($id);
        $bulan = ['',"Januari", "Februari", "Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        return $bulan[$id];
    }
}
