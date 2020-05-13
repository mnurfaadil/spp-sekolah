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
use App\Cicilan;

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
        $sum = 0;
        
        $payments = PaymentDetail::where('status','Nunggak')->get();

        $filter = true;
        foreach ($payments as $k) {
            $nominal = intval($k->periode->nominal);
            $terbayar = intval($k->cicilan->sum('nominal'));
            $potongan  = intval($k->payment->persentase)*$nominal/100;
            $sisa = $nominal - ($terbayar + $potongan);
            $sum += $sisa;
        }
        $rekap->tunggakan = $sum;
        return view('export.index',compact('categorys','majors','rekap'));
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
                        ->whereMonth('incomes.created_at',$request->bulan)
                        ->whereYear('incomes.created_at',$request->tahun)
                        ->where([
                            ['debit','<>','0'],
                            ['sumber','<>','Siswa']
                        ])->get();
            }
            elseif(isset($request->tahun)){   
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                        ->join('incomes','incomes.id','=','pencatatans.income_id')
                        ->whereYear('incomes.created_at',$request->tahun)
                        ->where([
                            ['debit','<>','0'],
                            ['sumber','<>','Siswa']
                        ])->get();
            }
            elseif(isset($request->bulan)){
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                        ->join('incomes','incomes.id','=','pencatatans.income_id')
                        ->whereMonth('incomes.created_at',$request->bulan)
                        ->where([
                            ['debit','<>','0'],
                            ['sumber','<>','Siswa']
                        ])->get();
            }else{
                $datas = Pencatatan::join('incomes','incomes.id','=','pencatatans.income_id')
                        ->where([
                            ['debit','<>','0'],
                            ['sumber','<>','Siswa']
                        ])->orderBy('pencatatans.updated_at', 'desc')
                        ->get();
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
                    ->whereYear('expenses.created_at',$request->tahun)
                    ->where('pencatatans.kredit','<>','0')
                    ->get();
            }elseif ($request->bulan != '' && $request->tahun=='') {
                $datas = Expense::orderBy('expenses.updated_at', 'desc')
                    ->join('pencatatans','expenses.id','=','pencatatans.expense_id')
                    ->whereMonth('expenses.created_at',$request->bulan)
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
                    ->whereMonth('expenses.created_at',$request->bulan)
                    ->whereYear('expenses.created_at',$request->tahun)
                    ->where([
                        ['pencatatans.kredit','<>','0'],
                    ])->get();
            }
            $pdf = PDF::loadView('export.pengeluaran',compact('tanggal','user','rincian','datas','no','title'));
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream();

        }else{
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
        $datas = Payment::where('financing_category_id', $id)->get();
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
        $data = PaymentDetail::where('id',$detail)->first();
        $d = "Pembayaran {$data->payment->category->nama} untuk periode {$data->bulan}";
        
        $data['tanggal'] = $this->getTanggalHariIni();
        $data['waktu'] = $this->getWaktuHariIni();
        $data['desc'] = $d;
        
        $pdf = PDF::loadView('export.kwitansi_bulanan_satuan',compact('user','siswa','data','no'));
        //$pdf->setPaper('A4', 'landscape');
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
    
    public function kwitansiBulanan($siswa, $payment, $category)
    {
        $no = 1;
        $user= Auth::user()->name;
        $siswa = Student::where('id',$siswa)->first();
        $datas = PaymentDetail::where([
            ['payment_id','=',$payment],
            ['status','=',"Lunas"]
        ])->join('financing_periodes','financing_periodes.id','payment_details.payment_periode_id')
        ->orderBy('payment_details.bulan','asc')
        ->get();
        if($datas->count()<1){
            return redirect()
                ->route('payment.monthly.show.detail',[$payment, $siswa, $category])
                ->with('error','Belum ada data yg lunas');
        }
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

        // echo '<pre>';
        // var_dump($datas);die;
        
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
                ->leftJoin('payment_details','payment_details.payment_id','=','payments.id')
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

            $sum = 0;
            $no = 1;
            $payments = Payment::join('students','students.id','=','payments.student_id')
                        ->join('payment_details','payment_details.id','=','payments.id')
                        ->where('payment_details.status', '=', 'Nunggak')
                        ->get();
            if($req['major_id']!="all" && $req['kelas']!="all"){
                $payments = Payment::join('students','students.id','=','payments.student_id')
                        ->join('payment_details','payment_details.id','=','payments.id')
                        ->where('payment_details.status', '=', 'Nunggak')
                        ->where('students.major_id', $req['major_id'])
                        ->where('students.kelas', $req['kelas'])
                        ->where('financing_category_id', $req['jenis_kategori'])
                        ->get();
            }elseif($req['kelas']!="all"){
                $payments = Payment::join('students','students.id','=','payments.student_id')
                ->join('payment_details','payment_details.id','=','payments.id')
                ->where('payment_details.status', '=', 'Nunggak')->where('students.kelas', $req['kelas'])
                ->where('financing_category_id', $req['jenis_kategori'])
                ->get();
            }elseif($req['major_id']!="all"){
                $payments = Payment::join('students','students.id','=','payments.student_id')
                        ->join('payment_details','payment_details.id','=','payments.id')
                        ->where('payment_details.status', '=', 'Nunggak')->where('students.major_id', $req['major_id'])
                        ->where('financing_category_id', $req['jenis_kategori'])
                        ->get();
            }
            $datas = $payments;
            $pdf = PDF::loadView('export.tunggakan_sekali',compact('no','title','datas'));
            //$pdf->setPaper('A4', 'landscape');
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream();
        }
    }
    //Method untuk pencetakan laporan kategori sekali bayar
    public function rekapSesekali(Request $request)
    {
        $no = 1;
        if($request->akt==NULL){
            $request->akt = '';
        }
        if($request->id_jur==NULL){
            $request->id_jur = '';
        }
        if($request->kls==NULL){
            $request->kls = '';
        }
        
        $request->kelas = $request->kls;
        $request->jurusan = $request->id_jur;
        $request->angkatan = $request->akt;

        
        $cek = FinancingCategory::findOrFail($request->id);

        $periode = PaymentPeriode::where('financing_category_id',$request->id)->count(); 
        
        $payments = Payment::join('students','payments.student_id','=','students.id')->where('financing_category_id', $request->id)->orderBy('payments.updated_at', 'desc')->get();
        
        if($request->kelas=='' && $request->jurusan!='' && $request->angkatan==''){
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id],
                ['students.major_id', '=',$request->jurusan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan=='' && $request->kelas!='' && $request->angkatan=='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id],
                ['students.kelas', '=',$request->kelas],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan=='' && $request->kelas=='' && $request->angkatan!='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id],
                ['students.angkatan_id', '=',$request->angkatan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan!='' && $request->kelas!='' && $request->angkatan=='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id],
                ['students.kelas', '=',$request->kelas],
                ['students.major_id', '=',$request->jurusan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan=='' && $request->kelas!='' && $request->angkatan!='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id],
                ['students.kelas', '=',$request->kelas],
                ['students.angkatan_id', '=',$request->angkatan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan!='' && $request->kelas=='' && $request->angkatan!='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id],
                ['students.major_id', '=',$request->jurusan],
                ['students.angkatan_id', '=',$request->angkatan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan!='' && $request->kelas!='' && $request->angkatan!='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id],
                ['students.kelas', '=',$request->kelas],
                ['students.major_id', '=',$request->jurusan],
                ['students.angkatan_id', '=',$request->angkatan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }else{
            $payments = Payment::join('students','payments.student_id','=','students.id')->where('financing_category_id', $request->id)->orderBy('payments.updated_at', 'desc')->get();
        }

        $datas = $payments;

        $title="Rekapitulasi Pembiayaan {$cek->nama}";
        $pdf = PDF::loadView('export.rekap_sekali',compact('no','title','datas'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    /**
     * Pencetakan Bukti Pembayaran (kwitansi) kategori Sekali Bayar
     */
    public function kwitansiSesekaliSatuan($siswa, $detail, $stat=1)
    {
        $no = 1;
        $user= Auth::user()->name;
        $siswa = Student::where('id',$siswa)->first();
        $data = Cicilan::where('id',$detail)->first();
        if($stat=="tunai"){
            $find = Cicilan::where('payment_detail_id', $detail)->first();
            $data = Cicilan::where('id',$find->id)->first();
        }
        $d = "Pembayaran {$data->detail->payment->category->nama}";
        if($stat=="tunai"){
            $d = "Pembayaran {$data->detail->payment->category->nama} secara Tunai";
        }
        $idx_bulan = $this->convertSqlDateToMonth($data['tgl_dibayar']);
        $bulan=$this->convertToBulan($idx_bulan);
        
        
        $data['tanggal'] = $this->getTanggalHariIni();
        $data['waktu'] = $this->getWaktuHariIni();
        $data['desc'] = $d;

        $pdf = PDF::loadView('export.kwitansi_sekali_satuan',compact('user','siswa','data','no'));
        //$pdf->setPaper('A4', 'landscape');
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    public function kwitansiSesekali($siswa, $payment, $category)
    {
        $no = 1;
        $user= Auth::user()->name;
        $siswa = Student::where('id',$siswa)->first();
        // $datas = PaymentDetail::where([
        //     ['payment_id','=',$payment],
        //     ['status','<>',"Waiting"]
        // ])->get();
        $datas = Cicilan::where('payment_detail_id', $payment)->get();
        $source = Cicilan::where('payment_detail_id', $payment)->first();
        if($datas->count()<1){
            return redirect()
                ->route('payment.details.cicilan',[$category, $siswa, $payment])
                ->with('error','Belum ada data cicilan');
        }
        try {
            $data['tanggal'] = $this->getTanggalHariIni();
            $data['waktu'] = $this->getWaktuHariIni();
            $data['nis'] = $source->detail->payment->student->nis;
            $data['nama'] = $source->detail->payment->student->nama;
            $data['kelas'] = $source->detail->payment->student->kelas;
            $data['jurusan'] = $source->detail->payment->student->major->nama;
            $data['kategori'] = $source->detail->payment->category->nama;
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
