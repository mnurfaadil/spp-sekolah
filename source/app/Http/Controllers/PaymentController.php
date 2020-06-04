<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Redirector;
use App\FinancingCategory;
use App\Payment;
use App\Student;
use App\PaymentPeriodeDetail;
use App\PaymentPeriode; 
use App\PaymentDetail;
use App\PaymentView;
use App\Major;
use App\Pencatatan;
use App\Income;
use App\Cicilan;
use DB;

class PaymentController extends Controller
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
        
        $datas = FinancingCategory::selectRaw('financing_categories.*, getJumlahTunggakanKategori(financing_categories.id) as tunggakan, 
        getCountNunggakPeriodeUseKategori(financing_categories.id) as tunggakan_periode')
                ->orderBy('updated_at','desc')->get();
        $no = 1;
        return view('pembayaran.index', compact('datas', 'no'));
    }

    public function indexKategori($id)
    {
        $students = Student::all();
        $no=1;
        $jml = Major::count();
        $majors = Major::all();
        return view('pembayaran.siswa', compact('students','no','jml','majors'));

        $siswa = $id;
        $datas = FinancingCategory::all();
        $no = 1;
        return view('pembayaran.index', compact('datas', 'no','siswa'));
    }

    public function indexKategori2($siswa)
    {
        $category = Student::all();
        $siswa = Student::where('id', $siswa)->get();
        $siswa = $siswa[0];
        DB::statement(DB::raw('set @row:=0'));
        $periodes = PaymentPeriode::select(DB::raw('@row:=@row+1 as rowNumber'),'payment_periodes.*')
                                    ->where('financing_category_id','2')
                                    ->get();
        
        return view('pembayaran.kategori',compact('periodes','category','siswa'));
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
        $this->validate($request,[
            'nama' => 'required',
            'besaran' => 'required',
        ]);

        try {
            $req = $request->all();
            FinancingCategory::create([
                'id' => null,
                'nama' => $req['nama'],
                'besaran' => $req['besaran'],
            ]);
            $id = DB::getPdo()->lastInsertId();
            //untuk history perubahan harga
            FinancingCategoryReset::create([
                'id' => null,
                'financing_category_id' => $id,
                'besaran' => $req['besaran'],
            ]);

        return redirect()
            ->route('financing.index')
            ->with('success', 'Data jurursan berhasil disimpan!');

        }catch(Exception $e){
        return redirect()
            ->route('financing.create')
            ->with('error', 'Data jurursan gagal disimpan!');
        }
        
    }

    /**
     * Display the specified resource.
    *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //numbering
        $no = 1;
        //data siswa
        //cek jenis kategori
        $cek = FinancingCategory::findOrFail($id);
        if($cek->jenis=="Bayar per Bulan")
        {
           
            // $datas=DB::table('students')
            //             ->selectRaw('students.*,getNominalTerbayarBulanan(payments.id) AS terbayar, getCountBulananTidakTerbayar(payments.id) AS bulan_tidak_bayar, getCountNunggak(payments.id) as cekNunggak, getCountWaiting(payments.id) AS cekWaiting, majors.nama AS jurusan, getAkumulasiPerBulan(payments.id) AS akumulasi, financing_categories.`nama` AS financing_nama, financing_categories.id AS financing_id, payments.`id` AS payment_id, payments.`jenis_pembayaran`')
            //             ->leftJoin('majors','majors.id','=','students.major_id')
            //             ->leftJoin('payments','payments.student_id','=','students.id')
            //             ->leftJoin('financing_categories','financing_categories.id','=','payments.financing_category_id')
            //             ->leftJoin('payment_details','payment_details.payment_id','=','payments.id')
            // $datas = Student::selectRaw('students.*, payments.*, financing_categories.id as financing_category_id, financing_categories.nama as kategori, financing_categories.jenis    ')
            //                 ->join('payments','payments.student_id','=','students.id')
            //                 ->join('financing_categories','financing_categories.id','=','payments.financing_category_id')
            //                 ->groupBy('students.id')
            //                 ->where('financing_categories.id',$cek->id)->get();

            $payments = Payment::where('financing_category_id', $id)->orderBy('updated_at','desc')->get();
            
            $datas = $payments;

            $financing = $cek;
            
            $periode = PaymentPeriode::where('financing_category_id',$id)->count(); 
            
            $payments = Payment::where('financing_category_id', $id)->get();
            
            return view('pembayaran.show2', compact('datas','financing','periode','no'));
        }else{

            $financing = $cek;

            $periode = PaymentPeriode::where('financing_category_id',$id)->count(); 
            
            $payments = Payment::where('financing_category_id', $id)->orderBy('updated_at','desc')->get();
            
            $datas = $payments;

            $payment_details = PaymentDetail::all();
            $cicilans = Cicilan::all();
            
            $fil = '';
            $fil2 = '';
            $kls = '';

            $majors = PaymentPeriode::select('major_id')->where('financing_category_id',$id)->groupBy('major_id')->get();
            $angkatan = PaymentPeriode::select('angkatan_id')->where('financing_category_id',$id)->groupBy('angkatan_id')->get();

            return view('pembayaran.show_sekali_bayar', compact('datas','financing','periode','no','payment_details','cicilans','majors','angkatan','fil','fil2','kls'));
        }
    }

    //Show filter Data 

    public function showFilter(Request $request)
    {
        
        $cek = FinancingCategory::findOrFail($request->id_kategori);

        if($request->kelas=="all"){
            $request->kelas = '';
        }
        if($request->jurusan=="all"){
            $request->jurusan = '';
        }
        if($request->angkatan=="all"){
            $request->angkatan = '';
        }

        $financing = $cek;

        $periode = PaymentPeriode::where('financing_category_id',$request->id_kategori)->count(); 
        
        $payments = Payment::join('students','payments.student_id','=','students.id')->where('financing_category_id', $request->id_kategori)->orderBy('payments.updated_at', 'desc')->get();
        
        if($request->kelas=='' && $request->jurusan!='' && $request->angkatan==''){
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id_kategori],
                ['students.major_id', '=',$request->jurusan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan=='' && $request->kelas!='' && $request->angkatan=='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id_kategori],
                ['students.kelas', '=',$request->kelas],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan=='' && $request->kelas=='' && $request->angkatan!='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id_kategori],
                ['students.angkatan_id', '=',$request->angkatan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan!='' && $request->kelas!='' && $request->angkatan=='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id_kategori],
                ['students.kelas', '=',$request->kelas],
                ['students.major_id', '=',$request->jurusan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan=='' && $request->kelas!='' && $request->angkatan!='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id_kategori],
                ['students.kelas', '=',$request->kelas],
                ['students.angkatan_id', '=',$request->angkatan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan!='' && $request->kelas=='' && $request->angkatan!='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id_kategori],
                ['students.major_id', '=',$request->jurusan],
                ['students.angkatan_id', '=',$request->angkatan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }elseif ($request->jurusan!='' && $request->kelas!='' && $request->angkatan!='') {
            $payments = Payment::join('students','payments.student_id','=','students.id')->where([
                ['financing_category_id', '=',$request->id_kategori],
                ['students.kelas', '=',$request->kelas],
                ['students.major_id', '=',$request->jurusan],
                ['students.angkatan_id', '=',$request->angkatan],
            ])->orderBy('payments.updated_at', 'desc')->get();
        }else{
            $payments = Payment::join('students','payments.student_id','=','students.id')
            ->where('financing_category_id', $request->id_kategori)
            ->orderBy('payments.updated_at', 'desc')->get();
        }

        $datas = $payments;

        $payment_details = PaymentDetail::all();
        $cicilans = Cicilan::all();
        
        $fil = $request->jurusan;
        $fil2 = $request->angkatan;
        $kls = $request->kelas;
        $no = 1;

        $majors = PaymentPeriode::select('major_id')->where('financing_category_id',
        $request->id_kategori)->groupBy('major_id')->get();
        $angkatan = PaymentPeriode::select('angkatan_id')->where('financing_category_id',
        $request->id_kategori)->groupBy('angkatan_id')->get();

        return view('pembayaran.show_sekali_bayar', compact('datas','financing','periode',
        'no','payment_details','cicilans','majors','angkatan','fil','fil2','kls'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $this->validate($request,[
            'nama' => 'required',
            'besaran' => 'required',
        ]);

        try {
          $req = $request->all();
          $data = FinancingCategory::findOrFail($id);
          $data->nama = $req['nama'];
          $data->besaran = $req['besaran'];
          $data->save();
          FinancingCategoryReset::create([
            'id' => null,
            'financing_category_id' => $id,
            'besaran' => $req['besaran'],
        ]);

          return redirect()
              ->route('financing.index')
              ->with('success', 'Data telah diubah!');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('financing.index')
              ->with('error', 'Data gagal diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cek = FinancingCategory::findOrFail($id);
            FinancingCategory::destroy($id);
            FinancingCategoryReset::where('financing_category_id', $id)->delete();
            $payments = Payment::where('financing_category_id', $id)->get();
            if($cek->jenis=="Bayar per Bulan"){
                PaymentPeriode::where('financing_category_id', $id)->delete();
                for ($i=0; $i < $payments->count(); $i++) { 
                    PaymentPeriodeDetail::where('payment_id', $payments[$i]->id)->delete();
                }
            }else{
                for ($i=0; $i < $payments->count(); $i++) { 
                    PaymentDetail::where('payment_id', $payments[$i]->id)->delete();
                }
            }
            Payment::where('financing_category_id', $id)->delete();
            return redirect()
            ->route('financing.index')
            ->with('success', 'Berhasil dihapus!');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('financing.index')
                ->with('error', 'Gagal dihapus!');
      }
        
    } 

    public function history($id)
    {
        DB::statement(DB::raw('set @row:=0'));
        return FinancingCategoryReset::select(DB::raw('@row:=@row+1 as rowNumber, format(besaran,0) as besaran'),'created_at')
                                    ->where('financing_category_id',$id)
                                    ->get();;
    }
    
    /**
     * @description Mencari nilai besaran pada kategori pembiayaan tertentu
     * 
     * @param id FinancingCategory kategori pembiayaan sebagai kata kunci
     * @return {int} mengembalikan nilai besaran
     */
    public function getBesaranBiayaKategoriPembiayaan($id)
    {
        $data = FinancingCategory::select('besaran')
                                ->where('id',$id)
                                ->get();
        return $data[0]->besaran;
    }

    /**
     * @description Mencari nilai besaran biaya telah terbayar
     * 
     * @param id Student
     * @param id Category dari FinancingCategory
     * @return {int} nominal biaya telah dibayar
     */
    public function getBesaranBiayaTerbayar($id_student, $id_category)
    {
        $data = PaymentDetail::selectRaw('sum(nominal) as nominal')
                            ->join('payments','payment_details.payment_id','=','payments.id')
                            ->join('students','payments.student_id','=','students.id')
                            ->where([
                                ['students.id','=',$id_student],
                                ['payments.financing_category_id','=',$id_category]
                            ])
                            ->get();
        return intval($data[0]->nominal);
    }

    public function storeMetodePembayaran(Request $request)
    {
        $req = $request->all();
        $req['date'] = date('Y-m-d', time());
        $req['user_id'] = Auth::user()->id;
        $obj = Student::where('id',$req['student_id'])->first();
        $percent = (int) $req['persentase'];
        $nominal = intval($req['dump'])-((intval($req['dump'])*$percent)/100);
        if($req['metode_pembayaran']=='Tunai')
        {
            $cek = json_decode($req['data']);
            $date = $this->convertToCorrectDateValue($request->tanggal_bayar);
            $penerima = Auth::user()->name;
            if($obj['kelas']=='ALUMNI')
            {
                $desc = "Pembayaran Tunai ".$req['financing_category']." dari ".$obj['nama']." ".$obj['kelas']." ( ".$obj->major->nama." )"." diterima oleh ".$penerima;
            }else
            {
                $desc = "Pembayaran Tunai ".$req['financing_category']." dari ".$obj['nama']." kelas ".$obj['kelas']." ( ".$obj->major->nama." )"." diterima oleh ".$penerima;
            }
            
            $payment = Payment::findOrFail($req['payment_id']);
            $detail_new = PaymentDetail::findOrFail($payment->detail->first()->id);

            $payment->jenis_pembayaran = "Tunai";
            $payment->persentase = $percent;
            $payment->save();
            
            $detail_new->tgl_dibayar = $date;
            $detail_new->nominal = $nominal;
            $detail_new->bulan = $date;
            $detail_new->user_id = $req['user_id'];
            $detail_new->status = "Lunas";
            $detail_new->save();

            $cicilan_new = Cicilan::create([
                'id' => null,
                'payment_detail_id' => $detail_new->id,
                'tgl_dibayar' => $date,
                'nominal' => $nominal,
                'user_id' => Auth::user()->id,
            ]);
                
            $title = "Pembayaran Tunai {$req['financing_category']} {$obj['nama']}";
            Income::create([
                'id' => null,
                'payment_detail_id' => $detail_new->id,
                'cicilan_id' => $cicilan_new->id,
                'title' => $title,
                'description' => $desc,
                'sumber' => "Siswa",
                'nominal' => $nominal,
            ]);
            
            $id = DB::getPdo()->lastInsertId();

            Pencatatan::create([
                'id' => null,
                'expense_id' => 0,
                'income_id' => $id,
                'debit' => $nominal,
                'description' => $desc,
                'kredit' => 0,
            ]);
                
            if($request->set_simpanan == "1"){
                $simpan = intval($request->dump) - intval($request->nominal);
                $obj->simpanan += $simpan;
                $obj->save();
            }

            return redirect()
            ->route('payment.show', $req['financing_category_id'])
            ->with('success', 'Lunas!');
        }
        elseif($req['metode_pembayaran']=='Nunggak'){
            $cek = Payment::where('id',$req['payment_id'])->first();
            $cek->jenis_pembayaran="Nunggak";
            $cek->save();
            $cek = PaymentDetail::where('payment_id',$req['payment_id'])->first();
            $cek->status="Nunggak";
            $cek->save();
            return redirect()
            ->route('payment.show', $req['financing_category_id'])
            ->with('success', 'Status pembayaran disimpan!');
        }else
        {
            $cek = Payment::where('id',$req['payment_id'])->first();
            if($cek->jenis_pembayaran!="Tunai"){
                $cek->jenis_pembayaran="Cicilan";
                $cek->persentase = $percent;
                $cek->save();
                return redirect()
                    ->route('payment.details.cicilan', [$req['financing_category_id'], $req['student_id'], $cek->id])
                    ->with('success', 'Metode Pembayaran disimpan!');
            }
            return redirect()
                ->route('payment.show', $req['financing_category_id'])
                ->with('error', 'Metode Pembayaran telah di isi');
        }
    }

    /**
     * @description me
     */
    public function details($id, $id_siswa, $id_payment)
    {
        //numbering
        $no = 1;
        //data siswa
        $datas=Student::selectRaw('students.*, payments.jenis_pembayaran,`getBesaranBiayaTerbayar`(students.id, '.$id.') AS terbayar')
                ->leftJoin('payments','payments.student_id','=','students.id')
                ->leftJoin('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                ->leftJoin('payment_details','payment_details.payment_id','=','payments.id')
                ->groupBy('students.id')
                ->where('students.id', $id_siswa)
                ->get();
        //data master show data untuk header
        $financing = FinancingCategory::findOrFail($id)
                    // ->selectRaw('*, (getBesaranBiayaKategoriPembiayaan(financing_categories.id)) as besaran, (financing_categories.`besaran` - ((select persentase from payments p2 where p2.id = '.$id_payment.')*financing_categories.besaran)/100) AS akumulasi')
                    ->where('id',$id)
                    ->get();
        $financing = $financing[0];
        //data Pembiayaan
        $payments = Payment::where('id',$id_payment)->first();
        $payment_details = PaymentDetail::where('payment_id',$id_payment)->get();
        
        //Untuk penghitung banyak periode pembayaran
        $periode = PaymentPeriode::where('financing_category_id',$id)->count(); 
        
        $cicilans = Cicilan::where('payment_detail_id', $payment_details[0]->id)->get();

        $footer['total'] = $payments->periode[0]->nominal;
        $footer['terbayar'] = $cicilans->sum('nominal');
        $footer['potongan'] = floor(intval($payments->periode[0]->nominal)*intval($payments->persentase)/100);
        $footer['sisa'] = $footer['total'] - $footer['potongan'] - $footer['terbayar'];
        if ($periode==0 && $financing->nama=="Bayar per Bulan") {
            return redirect()
                ->route('payment.index')
                ->with('error', 'Periode pembiayaan kosong. Untuk Pembiayaan dengan jenis per Bulan, periode harus dicantumkan!');
        }

        $date = $this->getTanggalHariIni();
        
        return view('pembayaran.cicilan2', compact('datas','financing','payments', 'payment_details','periode','no','date','cicilans','footer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cicilanStore(Request $request)
    {

        $request = $request->all();
        
        $sudah_dibayar = Cicilan::where('payment_detail_id', $request['payment_detail_id'])->sum('nominal');
        $tamp = Cicilan::where('payment_detail_id', $request['payment_detail_id'])->count();

        $hitungan = $tamp+1;
        $total = floor($request['sisa']);
        $bayar = intval($request['nominal']);
        $digunakan = $bayar - intval($request['uang']);
        $selisih = $total - $bayar;
        $simpan = $bayar - $total;
        $nominal = $bayar;
        $status="Nunggak";
        //
        /**
         * Total 400.000
         * sudah dibayar 0
         * selisih = 400.000 - (0 + 5000000) = -100.000
         * sisa= 500.000 - 100.000 = 400.000
         * 
         */
        if($selisih<0){
            $nominal = $total;
            $status = 'Lunas';
        }elseif($selisih==0){
            $status='Lunas';
        }
        $penerima=Auth::user()->name;
        $siswa=Student::where('id',$request['student_id'])->first();
        $category=FinancingCategory::where('id',$request['financing_category_id'])->first();
        $desc = "Penerimaan pembayaran cicilan ke {$hitungan} untuk {$category['nama']} dari {$siswa['nama']} kelas {$siswa['kelas']} {$siswa->major->nama} diterima oleh {$penerima}";
        $date = $this->convertToCorrectDateValue($request['calendar']);
        Cicilan::create([
            'id' => null,
            'payment_detail_id' => $request['payment_detail_id'],
            'tgl_dibayar' => $date,
            'nominal' => $nominal,
            'user_id' => Auth::user()->id,
        ]);

        $last_id = DB::getPdo()->lastInsertId();
        
        $title = "CICILAN {$category['nama']} {$siswa['nama']}";
        Income::create([
            'id' => null,
            'cicilan_id' => $last_id,
            'title' => $title,
            'description' => $desc,
            'sumber' => "Siswa",
            'nominal' => $nominal,
        ]);
            
        $last_id = DB::getPdo()->lastInsertId();
        
        if($request['gunakan_simpanan']=="1"){
            $siswa['simpanan'] = $siswa['simpanan'] + $simpan - $digunakan;
            $siswa->save();
        }elseif($request['set_simpanan']=="1"){
            $siswa['simpanan'] = $siswa['simpanan'] + $simpan;
            $siswa->save();
        }
        if($status=="Lunas"){
            $details = PaymentDetail::where('payment_id', $request['payment_id'])->get();
            foreach ($details as $d) {
                $d->status=$status;
                $d->save();
            }
        }
        Pencatatan::create([
            'id' => null,
            'expense_id' => 0,
            'income_id' => $last_id,
            'debit' => $nominal,
            'description' => $desc,
            'kredit' => 0,
        ]);
        return redirect()
                ->route('payment.details.cicilan', [$request['financing_category_id'], $request['student_id'], $request['payment_id']])
                ->with('success', 'Pembayaran disimpan!');
    }


    

    // ================================== Method Pembayaran Per Bulan ===================================== //
    /**
     * menampilkan data siswa dalam kategori pembayaran bulanan
     * 
     * @param int id kategori pembayaran
     * 
     */
    public function showBulanan($id)
    {
        
        
        //numbering
        $no = 1;
        //data siswa
        $datas=Student::selectRaw('students.*, payments.jenis_pembayaran,`getBesaranBiayaTerbayar`(students.id, '.$id.') AS terbayar')
                ->leftJoin('payments','payments.student_id','=','students.id')
                ->leftJoin('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
                ->leftJoin('payment_details','payment_details.payment_id','=','payments.id')
                ->groupBy('students.id')
                ->get();

        //data master show data untuk header
        $financing = FinancingCategory::findOrFail($id)
                    ->selectRaw('*, getBesaranBiayaKategoriPembiayaan(financing_categories.id) as besaran')
                    ->where('id',$id)
                    ->get();
        $financing = $financing[0];
        //Untuk penghitung banyak periode pembayaran
        $periode = PaymentPeriode::where('financing_category_id',$id)->count(); 
        // $students = Student::all();
        if ($periode==0 && $financing->nama=="Bayar per Bulan") {
            return redirect()
                ->route('payment.index')
                ->with('error', 'Periode pembiayaan kosong. Untuk Pembiayaan dengan jenis per Bulan, periode harus dicantumkan!');
        }
        // echo "<pre>";
        // var_dump($datas);
        return view('pembayaran.perbulan', compact('datas','financing','periode','no'));
    }

    public function showBulananDetail($payment, $id_student, $category)
    {
        $financing = FinancingCategory::where('id',$category)->get();
        $financing = $financing[0];
        
        //Untuk penghitung banyak periode pembayaran
        $periode = PaymentPeriode::where('financing_category_id',$category)->count(); 
    
        if ($periode==0 && $financing->nama=="Bayar per Bulan") {
            return redirect()
                ->route('payment.index')
                ->with('error', 'Periode pembiayaan kosong. Untuk Pembiayaan dengan jenis per Bulan, periode harus dicantumkan!');
        }

        //numbering
        $no = 1;
        //data Pembiayaan
        $payments = Payment::where('id',$payment)->first();
        $payment_details = PaymentDetail::where('payment_id',$payment)->orderBy('bulan')->get();

        $date = $this->getTanggalHariIni();
        
        return view('pembayaran.detail_bulanan2', compact('financing','no','date','payment_details'));
    }

    public function bulananStore(Request $request)
    {
        $this->validate($request,[
            'status' => 'required',
            'payment_id' => 'required',
        ]);
        $req = $request->all();
        try {
            $siswa = Student::findOrFail($req['siswa']);
            $bulan = $this->convertToBulan($req['bulan']);
            $desc = "Penerimaan pembayaran {$req['pembayaran']} untuk bulan {$bulan} {$req['tahun']} dari {$siswa->nama} kelas {$siswa->kelas} {$siswa->major->nama} diterima oleh {$req['penerima']}";
            //Update data Pembayaran
            $pembayaran = PaymentPeriodeDetail::findOrFail($req['payment_id']);
            $pembayaran->status = $req['status'];
            $pembayaran->save();
            if($req['status']=="Lunas"){
                //Pencatatan Pemasukan
                Pencatatan::create([
                    'id' => null,
                    'expense_id' => 0,
                    'payment_id' => $pembayaran->id,
                    'debit' => $req['nominal'],
                    'description' => $desc,
                    'kredit' => 0,
                ]);
            }
            return redirect()
                ->route('payment.monthly.show.detail',[$pembayaran->payment_id,$req['siswa']])
                ->with('success', 'Status disimpan!');
        }catch(Exception $e){
        return redirect()
            ->route('payment.monthly.show.detail',[$pembayaran->payment_id,$req['siswa']])
            ->with('error', 'Pembayaran gagal!');
        }
    }

    public function convertToBulan($id=1)
    {
        $bulan = ['',"Januari", "Februari", "Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        return $bulan[$id];
    }
    /**
     * 
     * @return string tanggal dalam format dd/mm/yyyy
     */
    public function getTanggalHariIni()
    {
        $date = now();
        $date = explode(" ", $date);
        $date = $date[0];
        $date = explode("-", $date);
        $date = $date[2]."/".$date[1]."/".$date[0];
        return $date;
    }
    /**
     * 
     * @param string invalid format
     * @return string tanggal dalam format dd/mm/yyyy
     */
    public function convertToCorrectDateValue($date)
    {
        $date = explode("/", $date);
        $date = $date[2]."-".$date[1]."-".$date[0];
        return $date;
    }

    /**
     * Update status untuk pembayaran dengan kategori bayar per bulan
     */
    public function updateStatusBulanan(Request $request)
    {
        $req = $request->all();
        if($req['status']=="Lunas"){   
            $user = Auth::user()->id;
            $penerima = Auth::user()->name;
            $category = FinancingCategory::findOrFail($req['category_id']);
            $student = Student::findOrFail($req['student_id']);
            $data = PaymentDetail::findOrFail($req['id']);
            $bulan = $this->convertToCorrectDateValue($req['calendar']);
            $desc = "Pembayaran {$category->nama} untuk periode {$data->bulan} dari {$student->nama} kelas {$student->kelas} ( {$student->major->nama} ) dibayar pada {$bulan} diterima oleh {$penerima}";
            $title = "{$category->nama} {$student->nama} periode {$data->bulan}";
            
            $data->user_id = $user;
            $data->tgl_dibayar = $bulan;
            $data->nominal = $req['nominal_bayar'];
            $data->status = $req['status'];
            $data->save();

            if($req['set_simpanan']=="1" && $req['gunakan_simpanan']=="1"){
                $student->simpanan = (intval($req['nominal']) - intval($req['nominal_bayar'])); 
            }elseif($req['set_simpanan']=="1"){
                $student->simpanan += (intval($req['nominal']) - intval($req['nominal_bayar'])); 
            }elseif($req['gunakan_simpanan']=="1"){
                $student->simpanan = 0;
            }
            $student->save();

            Income::create([
                'id' => null,
                'payment_detail_id' => $req['id'],
                'title' => $title,
                'description' => $desc,
                'sumber' => 'Siswa',
                'nominal' => $req['nominal_bayar']
            ]);

            $last_id = DB::getPdo()->lastInsertId();

            Pencatatan::create([
                'id' => null,
                'expense_id' => 0,
                'income_id' => $last_id,
                'payment_id' => $data->payment_id,
                'debit' => $req['nominal_bayar'],
                'description' => $desc,
                'kredit' => 0,
            ]);
        }else{
            $data = PaymentPeriodeDetail::findOrFail($req['id']);
            $data->status = $req['status'];
            $data->save();
        }
        return redirect()
        ->route('payment.monthly.show.detail',[$req['payment_id'],$req['student_id'],$req['category_id']])
        ->with('success', 'Periode pembayaran ditambah!');
    }

    /**
     * Menambah periode pembayaran dengan kategori bayar per bulan
     */
    public function addPeriodeBulanan(Request $request)
    {
        $req = $request->all();
        $status = "Waiting";
        PaymentPeriodeDetail::create([
            'payment_id' => $req['payment_id'],
            'payment_periode_id' => $req['periode'],
            'user_id' => 0,
            'status' => $status,
        ]);

        return redirect()
        ->route('payment.monthly.show.detail',[$req['payment_id'],$req['student_id'],$req['category_id']])
        ->with('success', 'Periode pembayaran ditambah!');
    }
}
