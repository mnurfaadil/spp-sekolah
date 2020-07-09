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
use App\ViewTunggakan;

use PDF; 
use DB; 
class RekapController extends Controller
{

    public function ulala()
    {
        
        $pdf = PDF::loadView('export.coba');
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

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
        $categorys = FinancingCategory::join('payments','payments.financing_category_id','=','financing_categories.id')
        ->join('payment_details','payment_details.payment_id','=','payments.id')
        ->selectRaw('financing_categories.*')
        ->where('payment_details.status','Nunggak')
        ->groupBy('financing_categories.id')
        ->get();
        $rekap = DB::table('rekap_view')->first();
        $sum = 0;
        $temp = [0,0,0];
        
        $tunggakan = MenuRekapController::nominalRekapTunggakan();
        
        // $rekap->tunggakan = $sum;
        return view('export.index',compact('categorys','rekap','tunggakan'));
    }

    public function ajaxMajor($category, $kelas = '')
    {
        if($kelas != '')
        {
            return FinancingCategory::join('payments','payments.financing_category_id','=','financing_categories.id')
                        ->join('payment_details','payment_details.payment_id','=','payments.id')
                        ->join('students','students.id','=','payments.student_id')
                        ->join('majors','majors.id','=','students.major_id')
                        ->join('angkatans','angkatans.id','=','students.angkatan_id')
                        ->selectRaw('majors.id as major_id, majors.nama')
                        ->where('payment_details.status','Nunggak')
                        ->where('financing_categories.id', $category)
                        ->where('students.kelas', $kelas)
                        ->groupBy('majors.id')
                        ->get();
        }
        return FinancingCategory::join('payments','payments.financing_category_id','=','financing_categories.id')
                    ->join('payment_details','payment_details.payment_id','=','payments.id')
                    ->join('students','students.id','=','payments.student_id')
                    ->join('majors','majors.id','=','students.major_id')
                    ->join('angkatans','angkatans.id','=','students.angkatan_id')
                    ->selectRaw('majors.id as major_id, majors.nama')
                    ->where('payment_details.status','Nunggak')
                    ->where('financing_categories.id', $category)
                    ->groupBy('majors.id')
                    ->get();
    }

    public function ajaxKelas($category, $major = '')
    {
        if($major != '')
        {
            return FinancingCategory::join('payments','payments.financing_category_id','=','financing_categories.id')
                        ->join('payment_details','payment_details.payment_id','=','payments.id')
                        ->join('students','students.id','=','payments.student_id')
                        ->join('majors','majors.id','=','students.major_id')
                        ->join('angkatans','angkatans.id','=','students.angkatan_id')
                        ->selectRaw('students.kelas')
                        ->where('payment_details.status','Nunggak')
                        ->where('financing_categories.id', $category)
                        ->where('majors.id', $major)
                        ->groupBy('students.kelas')
                        ->get();
        }
        return FinancingCategory::join('payments','payments.financing_category_id','=','financing_categories.id')
                    ->join('payment_details','payment_details.payment_id','=','payments.id')
                    ->join('students','students.id','=','payments.student_id')
                    ->join('majors','majors.id','=','students.major_id')
                    ->join('angkatans','angkatans.id','=','students.angkatan_id')
                    ->selectRaw('students.kelas')
                    ->where('payment_details.status','Nunggak')
                    ->where('financing_categories.id', $category)
                    ->groupBy('students.kelas')
                    ->get();

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
            if($request->tanggal)
            {
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                    ->join('incomes','incomes.id','=','pencatatans.income_id')
                    ->where([
                        ['debit','<>','0'],
                        // ['incomes.created_at','=', $request->tanggal]
                    ])
                    ->whereDate('incomes.created_at', '=', $request->tanggal)->get();
            }
            else
            {
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                        ->join('incomes','incomes.id','=','pencatatans.income_id')
                        ->where([
                            ['debit','<>','0'],
                        ])->get();
            }
            $rincian = "Pemasukan";
            $title = "Laporan Pemasukan";
            $pdf = PDF::loadView('export.pemasukan',compact('tanggal','user','rincian','datas','no','title'));
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream();
            //filter bulan dan tahun
            if(isset($request->bulan) && isset($request->tahun)){
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                        ->join('incomes','incomes.id','=','pencatatans.income_id')
                        ->whereMonth('incomes.created_at',$request->bulan)
                        ->whereYear('incomes.created_at',$request->tahun)
                        ->where([
                            ['debit','<>','0']
                        ])->get();
            }
            elseif(isset($request->tahun)){   
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                        ->join('incomes','incomes.id','=','pencatatans.income_id')
                        ->whereYear('incomes.created_at',$request->tahun)
                        ->where([
                            ['debit','<>','0']
                        ])->get();
            }
            elseif(isset($request->bulan)){
                $datas = Pencatatan::orderBy('pencatatans.updated_at', 'desc')
                        ->join('incomes','incomes.id','=','pencatatans.income_id')
                        ->whereMonth('incomes.created_at',$request->bulan)
                        ->where([
                            ['debit','<>','0']
                        ])->get();
            }else{
                $datas = Pencatatan::join('incomes','incomes.id','=','pencatatans.income_id')
                        ->where([
                            ['debit','<>','0']
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
            $title = "Buku Besar";
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

        $keterangan = $data->keterangan == "" ? "Pribadi" : $data->keterangan;

        $d = "Pembayaran {$data->payment->category->nama} untuk periode {$data->bulan} dari Uang {$keterangan}";
        
        $data['tanggal'] = $this->getTanggalHariIni();
        $data['waktu'] = $this->getWaktuHariIni();
        $data['desc'] = $d;
        
        $pdf = PDF::loadView('export.kwitansi_bulanan_satuan',compact('user','siswa','data','no'));
        //$pdf->setPaper('A4', 'landscape');
        $pdf->setPaper(array(0,0,300,500));
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

        if (!isset($request->jenis_kategori)) {
            return redirect()
                ->route('rekap.index')
                ->with('error', 'Filter data ada yang kosong');
        }

        return redirect()
                ->route('rekap.tunggakan', $request->jenis_kategori);

        //Its Useless
        $req = $request->all(); 

        $kategori = FinancingCategory::findOrFail($request->jenis_kategori);
        

        $no =1;
        $title="Rekapitulasi Tunggakan {$kategori['nama']}";
        
        if($kategori['jenis']=="Bayar per Bulan"){
            $datas = Payment::
            where('financing_category_id', $kategori->id)
            ->orderBy('updated_at','desc')->get();
            $datas = ViewTunggakan::where('financing_category_id', $kategori->id)->get();

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
                        ->join('payment_details','payment_details.payment_id','=','payments.id')
                        ->where('payment_details.status', '=', 'Nunggak')
                        ->where('payments.financing_category_id', $request->jenis_kategori)
                        ->get();
            if($req['major_id']!="all" && $req['kelas']!="all"){
                $payments = Payment::join('students','students.id','=','payments.student_id')
                        ->join('payment_details','payment_details.payment_id','=','payments.id')
                        ->where('payment_details.status', '=', 'Nunggak')
                        ->where('students.major_id', $req['major_id'])
                        ->where('students.kelas', $req['kelas'])
                        ->where('financing_category_id', $req['jenis_kategori'])
                        ->get();
            }elseif($req['kelas']!="all"){
                $payments = Payment::join('students','students.id','=','payments.student_id')
                ->join('payment_details','payment_details.payment_id','=','payments.id')
                ->where('payment_details.status', '=', 'Nunggak')->where('students.kelas', $req['kelas'])
                ->where('financing_category_id', $req['jenis_kategori'])
                ->get();
            }elseif($req['major_id']!="all"){
                $payments = Payment::join('students','students.id','=','payments.student_id')
                        ->join('payment_details','payment_details.payment_id','=','payments.id')
                        ->where('payment_details.status', '=', 'Nunggak')->where('students.major_id', $req['major_id'])
                        ->where('financing_category_id', $req['jenis_kategori'])
                        ->get();
            }
            $datas = Payment::all();

            $filter = $datas->where('financing_category_id', $req['jenis_kategori']);
            
            $datas = $filter;
            

            // echo '<pre>';
            // var_dump ($req); echo"<hr>";
            // var_dump($filter->first()->detail);die;

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
        // if($request->akt==NULL){
        //     $request->akt = '';
        // }
        // if($request->id_jur==NULL){
        //     $request->id_jur = '';
        // }
        // if($request->kls==NULL){
        //     $request->kls = '';
        // }
        
        // $request->kelas = $request->kls;
        // $request->jurusan = $request->id_jur;
        // $request->angkatan = $request->akt;

        // echo '<pre>';
        // var_dump($request->all());die;

        $id = $request->id;
        
        try {
            $kelas = $request->kls == "all" ? "" : $request->kls;
        } catch (\Throwable $th) {
            $kelas = "";
        }
        try {
            $jurusan = $request->id_jur == "all" ? "" : $request->id_jur;
        } catch (\Throwable $th) {
            $jurusan = "";
        }
        try {
            $angkatan = $request->akt == "all" ? "" : $request->akt;
        } catch (\Throwable $th) {
            $angkatan = "";
        }
        if ($kelas != "" && $jurusan != "" && $angkatan != "") {
            $datas = Payment::
                selectRaw('
                    students.nama, 
                    students.kelas, 
                    majors.inisial as jurusan,
                    financing_periodes.nominal,
                    financing_categories.jenis, 
                    payments.persentase,
                    payments.jenis_pembayaran,
                    getPaymentDetailsId(payments.id) as payment_detail_tunai,
                    getNominalCicilan(getPaymentDetailsId(payments.id)) as cicilan,
                    students.id as student_id,
                    financing_categories.id as financing_category_id,
                    payments.id,
                    payments.jenis_potongan,
                    payments.nominal_potongan
                ')
                ->join('students','payments.student_id','=','students.id')
                ->join('majors','majors.id','=','students.major_id')
                ->join('financing_categories','financing_categories.id','=','payments.financing_category_id')
                ->join('payment_details','payment_details.payment_id','=','payments.id')
                ->leftJoin('cicilans','cicilans.payment_detail_id','=','payment_details.id')
                ->join('financing_periodes','financing_periodes.id','=','payment_details.payment_periode_id')
                ->where('financing_categories.id',$id)
                ->where('students.kelas', $kelas)
                ->where('students.major_id', $jurusan)
                ->where('students.angkatan_id', $angkatan)
                ->groupBy('students.id')
                ->orderBy('payments.updated_at','desc')
                ->get();
        } 
        elseif ($kelas == "" && $jurusan != "" && $angkatan != "") {
            $datas = Payment::
                selectRaw('
                    students.nama, 
                    students.kelas, 
                    majors.inisial as jurusan,
                    financing_periodes.nominal,
                    financing_categories.jenis, 
                    payments.persentase,
                    payments.jenis_pembayaran,
                    getPaymentDetailsId(payments.id) as payment_detail_tunai,
                    getNominalCicilan(getPaymentDetailsId(payments.id)) as cicilan,
                    students.id as student_id,
                    financing_categories.id as financing_category_id,
                    payments.id,
                    payments.jenis_potongan,
                    payments.nominal_potongan
                ')
                ->join('students','payments.student_id','=','students.id')
                ->join('majors','majors.id','=','students.major_id')
                ->join('financing_categories','financing_categories.id','=','payments.financing_category_id')
                ->join('payment_details','payment_details.payment_id','=','payments.id')
                ->leftJoin('cicilans','cicilans.payment_detail_id','=','payment_details.id')
                ->join('financing_periodes','financing_periodes.id','=','payment_details.payment_periode_id')
                ->where('financing_categories.id',$id)
                ->where('students.major_id', $jurusan)
                ->where('students.angkatan_id', $angkatan)
                ->groupBy('students.id')
                ->orderBy('payments.updated_at','desc')
                ->get();
        } 
        elseif ($kelas == "" && $jurusan != "" && $angkatan == "") {
            $datas = Payment::
                selectRaw('
                    students.nama, 
                    students.kelas, 
                    majors.inisial as jurusan,
                    financing_periodes.nominal,
                    financing_categories.jenis, 
                    payments.persentase,
                    payments.jenis_pembayaran,
                    getPaymentDetailsId(payments.id) as payment_detail_tunai,
                    getNominalCicilan(getPaymentDetailsId(payments.id)) as cicilan,
                    students.id as student_id,
                    financing_categories.id as financing_category_id,
                    payments.id,
                    payments.jenis_potongan,
                    payments.nominal_potongan
                ')
                ->join('students','payments.student_id','=','students.id')
                ->join('majors','majors.id','=','students.major_id')
                ->join('financing_categories','financing_categories.id','=','payments.financing_category_id')
                ->join('payment_details','payment_details.payment_id','=','payments.id')
                ->leftJoin('cicilans','cicilans.payment_detail_id','=','payment_details.id')
                ->join('financing_periodes','financing_periodes.id','=','payment_details.payment_periode_id')
                ->where('financing_categories.id',$id)
                ->where('students.major_id', $jurusan)
                ->groupBy('students.id')
                ->orderBy('payments.updated_at','desc')
                ->get();
        } 
        elseif ($kelas != "" && $jurusan == "" && $angkatan != "") {
            $datas = Payment::
                selectRaw('
                    students.nama, 
                    students.kelas, 
                    majors.inisial as jurusan,
                    financing_periodes.nominal,
                    financing_categories.jenis, 
                    payments.persentase,
                    payments.jenis_pembayaran,
                    getPaymentDetailsId(payments.id) as payment_detail_tunai,
                    getNominalCicilan(getPaymentDetailsId(payments.id)) as cicilan,
                    students.id as student_id,
                    financing_categories.id as financing_category_id,
                    payments.id,
                    payments.jenis_potongan,
                    payments.nominal_potongan
                ')
                ->join('students','payments.student_id','=','students.id')
                ->join('majors','majors.id','=','students.major_id')
                ->join('financing_categories','financing_categories.id','=','payments.financing_category_id')
                ->join('payment_details','payment_details.payment_id','=','payments.id')
                ->leftJoin('cicilans','cicilans.payment_detail_id','=','payment_details.id')
                ->join('financing_periodes','financing_periodes.id','=','payment_details.payment_periode_id')
                ->where('financing_categories.id',$id)
                ->where('students.kelas', $kelas)
                ->where('students.angkatan_id', $angkatan)
                ->groupBy('students.id')
                ->orderBy('payments.updated_at','desc')
                ->get();
        } 
        elseif ($kelas != "" && $jurusan == "" && $angkatan == "") {
            $datas = Payment::
                selectRaw('
                    students.nama, 
                    students.kelas, 
                    majors.inisial as jurusan,
                    financing_periodes.nominal,
                    financing_categories.jenis, 
                    payments.persentase,
                    payments.jenis_pembayaran,
                    getPaymentDetailsId(payments.id) as payment_detail_tunai,
                    getNominalCicilan(getPaymentDetailsId(payments.id)) as cicilan,
                    students.id as student_id,
                    financing_categories.id as financing_category_id,
                    payments.id,
                    payments.jenis_potongan,
                    payments.nominal_potongan
                ')
                ->join('students','payments.student_id','=','students.id')
                ->join('majors','majors.id','=','students.major_id')
                ->join('financing_categories','financing_categories.id','=','payments.financing_category_id')
                ->join('payment_details','payment_details.payment_id','=','payments.id')
                ->leftJoin('cicilans','cicilans.payment_detail_id','=','payment_details.id')
                ->join('financing_periodes','financing_periodes.id','=','payment_details.payment_periode_id')
                ->where('financing_categories.id',$id)
                ->where('students.kelas', $kelas)
                ->groupBy('students.id')
                ->orderBy('payments.updated_at','desc')
                ->get();

        } 
        elseif ($kelas != "" && $jurusan != "" && $angkatan == "") {
            $datas = Payment::
                selectRaw('
                    students.nama, 
                    students.kelas, 
                    majors.inisial as jurusan,
                    financing_periodes.nominal,
                    financing_categories.jenis, 
                    payments.persentase,
                    payments.jenis_pembayaran,
                    getPaymentDetailsId(payments.id) as payment_detail_tunai,
                    getNominalCicilan(getPaymentDetailsId(payments.id)) as cicilan,
                    students.id as student_id,
                    financing_categories.id as financing_category_id,
                    payments.id,
                    payments.jenis_potongan,
                    payments.nominal_potongan
                ')
                ->join('students','payments.student_id','=','students.id')
                ->join('majors','majors.id','=','students.major_id')
                ->join('financing_categories','financing_categories.id','=','payments.financing_category_id')
                ->join('payment_details','payment_details.payment_id','=','payments.id')
                ->leftJoin('cicilans','cicilans.payment_detail_id','=','payment_details.id')
                ->join('financing_periodes','financing_periodes.id','=','payment_details.payment_periode_id')
                ->where('financing_categories.id',$id)
                ->where('students.kelas', $kelas)
                ->where('students.major_id', $jurusan)
                ->groupBy('students.id')
                ->orderBy('payments.updated_at','desc')
                ->get();
        }
        else {
            $datas = Payment::
                selectRaw('
                    students.nama, 
                    students.kelas, 
                    majors.inisial as jurusan,
                    financing_periodes.nominal,
                    financing_categories.jenis, 
                    payments.persentase,
                    payments.jenis_pembayaran,
                    getPaymentDetailsId(payments.id) as payment_detail_tunai,
                    getNominalCicilan(getPaymentDetailsId(payments.id)) as cicilan,
                    students.id as student_id,
                    financing_categories.id as financing_category_id,
                    payments.id,
                    payments.jenis_potongan,
                    payments.nominal_potongan
                ')
                ->join('students','payments.student_id','=','students.id')
                ->join('majors','majors.id','=','students.major_id')
                ->join('financing_categories','financing_categories.id','=','payments.financing_category_id')
                ->join('payment_details','payment_details.payment_id','=','payments.id')
                ->leftJoin('cicilans','cicilans.payment_detail_id','=','payment_details.id')
                ->join('financing_periodes','financing_periodes.id','=','payment_details.payment_periode_id')
                ->where('financing_categories.id',$id)
                ->groupBy('students.id')
                ->orderBy('payments.updated_at','desc')
                ->get();
        }
        
        $cek = FinancingCategory::findOrFail($request->id);

        $periode = PaymentPeriode::where('financing_category_id',$request->id)->count(); 
        
        // $payments = Payment::join('students','payments.student_id','=','students.id')
        // ->where('financing_category_id', $request->id)
        // ->orderBy('payments.updated_at', 'desc')
        // ->get();
        
        // if($request->kelas=='' && $request->jurusan!='' && $request->angkatan==''){
        //     $payments = Payment::join('students','payments.student_id','=','students.id')->where([
        //         ['financing_category_id', '=',$request->id],
        //         ['students.major_id', '=',$request->jurusan],
        //     ])->orderBy('payments.updated_at', 'desc')
        //     ->selectRaw('payments.*')
        //     ->get();
        // }elseif ($request->jurusan=='' && $request->kelas!='' && $request->angkatan=='') {
        //     $payments = Payment::join('students','payments.student_id','=','students.id')->where([
        //         ['financing_category_id', '=',$request->id],
        //         ['students.kelas', '=',$request->kelas],
        //     ])->orderBy('payments.updated_at', 'desc')
        //     ->selectRaw('payments.*')
        //     ->get();
        // }elseif ($request->jurusan=='' && $request->kelas=='' && $request->angkatan!='') {
        //     $payments = Payment::join('students','payments.student_id','=','students.id')->where([
        //         ['financing_category_id', '=',$request->id],
        //         ['students.angkatan_id', '=',$request->angkatan],
        //     ])->orderBy('payments.updated_at', 'desc')
        //     ->selectRaw('payments.*')
        //     ->get();
        // }elseif ($request->jurusan!='' && $request->kelas!='' && $request->angkatan=='') {
        //     $payments = Payment::join('students','payments.student_id','=','students.id')->where([
        //         ['financing_category_id', '=',$request->id],
        //         ['students.kelas', '=',$request->kelas],
        //         ['students.major_id', '=',$request->jurusan],
        //     ])->orderBy('payments.updated_at', 'desc')
        //     ->selectRaw('payments.*')
        //     ->get();
        // }elseif ($request->jurusan=='' && $request->kelas!='' && $request->angkatan!='') {
        //     $payments = Payment::join('students','payments.student_id','=','students.id')->where([
        //         ['financing_category_id', '=',$request->id],
        //         ['students.kelas', '=',$request->kelas],
        //         ['students.angkatan_id', '=',$request->angkatan],
        //     ])->orderBy('payments.updated_at', 'desc')
        //     ->selectRaw('payments.*')
        //     ->get();
        // }elseif ($request->jurusan!='' && $request->kelas=='' && $request->angkatan!='') {
        //     $payments = Payment::join('students','payments.student_id','=','students.id')->where([
        //         ['financing_category_id', '=',$request->id],
        //         ['students.major_id', '=',$request->jurusan],
        //         ['students.angkatan_id', '=',$request->angkatan],
        //     ])->orderBy('payments.updated_at', 'desc')
        //     ->selectRaw('payments.*')
        //     ->get();
        // }elseif ($request->jurusan!='' && $request->kelas!='' && $request->angkatan!='') {
        //     $payments = Payment::join('students','payments.student_id','=','students.id')->where([
        //         ['financing_category_id', '=',$request->id],
        //         ['students.kelas', '=',$request->kelas],
        //         ['students.major_id', '=',$request->jurusan],
        //         ['students.angkatan_id', '=',$request->angkatan],
        //     ])->orderBy('payments.updated_at', 'desc')
        //     ->selectRaw('payments.*')
        //     ->get();
        // }else{
        //     $payments = Payment::join('students','payments.student_id','=','students.id')->where('financing_category_id', $request->id)
        //     ->selectRaw('payments.*')
        //     ->orderBy('payments.updated_at', 'desc')->get();
        // }

        // $datas = $payments;

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
        $keterangan = $data->keterangan; 
        if ($data->keterangan == "")
        {
            $keterangan = $data->detail->payment->keterangan == "" ? "Pribadi" : $data->detail->payment->keterangan;
        }
        $d = "Pembayaran {$data->detail->payment->category->nama} ({$keterangan})";
        if($stat=="tunai"){
            $d = "Pembayaran {$data->detail->payment->category->nama} secara Tunai  ({$keterangan})";
        }
        $idx_bulan = $this->convertSqlDateToMonth($data['tgl_dibayar']);
        $bulan=$this->convertToBulan($idx_bulan);
        
        
        $data['tanggal'] = $this->getTanggalHariIni();
        $data['waktu'] = $this->getWaktuHariIni();
        $data['desc'] = $d;

        $pdf = PDF::loadView('export.kwitansi_sekali_satuan',compact('user','siswa','data','no'));
        $pdf->setPaper('A4', 'potrait');
        // $pdf->setPaper('A4', 'potrait');
        $pdf->setPaper(array(0,0,300,500));
        return $pdf->stream();
    }

    public function kwitansiSesekali($siswa, $payment, $category)
    {
        $no = 1;
        $user= Auth::user()->name;
        $siswa = Student::where('id',$siswa)->first();
        $cek = PaymentDetail::select('id')->where('payment_id', $payment)->first();
        // $datas = PaymentDetail::where([
        //     ['payment_id','=',$payment],
        //     ['status','<>',"Waiting"]
        // ])->get();
        $datas = Cicilan::where('payment_detail_id', $cek->id)->get();
        $source = Cicilan::where('payment_detail_id', $cek->id)->first();
        
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
            $data['keterangan'] = $source->detail->payment->keterangan;
        } catch (Throwable $th) {
            abort(500);
        }
        
        $pdf = PDF::loadView('export.kwitansi_sekali_rekap', compact('user','siswa','data','no','datas'));
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
