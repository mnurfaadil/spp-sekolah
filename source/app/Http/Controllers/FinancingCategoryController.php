<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FinancingCategory;
use App\FinancingCategoryReset;
use App\Payment;
use App\PaymentDetail;
use App\PaymentPeriode;
use App\PaymentPeriodeDetail;
use App\Student;
use App\Angkatan;
use App\Major;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use DB;

class FinancingCategoryController extends Controller
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
        $datas = FinancingCategory::orderBy('updated_at','desc')
            ->get();
        $majors = Major::all();
        $angkatans = Angkatan::where('status','<>','ALUMNI')
                    ->orderBy('status')->get();
        $no = 1;
        return view('master.financingcategory.index', compact('datas', 'no', 'majors','angkatans'));
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
        $this->validate($request, [
            'nama' => 'required',
            'besaran' => 'required',
            'jenis' => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required'
        ]);
        
        $is_perbulan = FinancingCategory::where('jenis','Bayar per Bulan')->count();

        if($request->jenis=="Bayar per Bulan" && $is_perbulan > 0){
            return redirect()
                ->route('financing.index')
                ->with('error', 'Jenis pembayaran per bulan hanya bisa satu');
        }

        $req = $request->all();
        
        $angkatan = Angkatan::all();
        $jurusan = Major::all();
        $murid = Student::all();

        $filter_angkatan = $angkatan->where('status','<>','ALUMNI');
    
        if($req['jurusan']=="all"){
            $req['jurusan']=0;
        }
        if($req['angkatan']=="all"){
            $req['angkatan']=0;
        }

        try {

            $create = FinancingCategory::create([
                'id' => null,
                'nama' => $req['nama'],
                'jenis' => $req['jenis'],
            ]);

            $id = DB::getPdo()->lastInsertId();

            FinancingCategoryReset::create([
                'id' => null,
                'financing_category_id' => $id,
                'besaran' => $req['besaran'],
                'jenis' => $req['jenis'],
            ]);

            if($req['jurusan']==0 && $req['angkatan']==0){

                foreach ($jurusan as $jurusan_obj) {
                    foreach ($filter_angkatan as $angkatan_obj) {
                        PaymentPeriode::create([
                            'id' => null,
                            'financing_category_id' => $id,
                            'angkatan_id' => $angkatan_obj->id,
                            'major_id' => $jurusan_obj->id,
                            'nominal' => $req['besaran'],
                        ]);
                    }
                }

                foreach ($murid as $murid_obj) { 
                    Payment::create([
                        'id' => null,
                        'student_id' => $murid_obj->id,
                        'financing_category_id' => $id,
                        'persentase' => 0,
                        'jenis_pembayaran' => "Waiting",
                    ]);
                }
                
                if($req['jenis'] == "Bayar per Bulan"){   
                    $payment = Payment::all();

                    $filter_payment = $payment->where('financing_category_id',$id);
 
                    foreach ($filter_angkatan as $obj) {
                        foreach ($obj->students as $murid_obj) {
                            $periode_input = PaymentPeriode::where([
                                ['financing_category_id','=',$id],
                                ['angkatan_id','=',$murid_obj->angkatans->id],
                                ['major_id','=',$murid_obj->major->id],
                            ])->first();
                            
                            $payment_input = Payment::where('student_id',$murid_obj->id)
                                            ->where('financing_category_id', $id)->first();
                            
                            $periode_id = $periode_input['id'];
                            $payment_id = $payment_input['id'];
                            $start_loop = 0;

                            // if($murid_obj->angkatans->status == "XI"){
                            //     $start_loop = 12;
                            // }elseif($murid_obj->angkatans->status == "XII"){
                            //     $start_loop = 24;
                            // }

                            $thn = intval($murid_obj->angkatans->tahun);
                            $tgl_hitung = "{$thn}-07-01";
                            $time = strtotime($tgl_hitung);
                            
                            for ($j=$start_loop, $count=0; $j < 36; $j++) {
                                $inc = "+{$j} month"; 
                                $final = date("Y-m-d", strtotime($inc, $time));
                                $status = "Waiting";
                                PaymentPeriodeDetail::create([
                                    'id' => null,
                                    'payment_id' => $payment_id,
                                    'payment_periode_id' => $periode_id,
                                    'bulan' => $final,
                                    'user_id' => 0,
                                    'status' => $status,
                                ]);
                                if($j%12==0){
                                    $count++;
                                }
                            }
                        }
                    }
                }else{
                    $payment = Payment::all();

                    $filter_payment = $payment->where('financing_category_id',$id);
 
                    foreach ($filter_angkatan as $obj) {
                        foreach ($obj->students as $murid_obj) {
                            $periode_input = PaymentPeriode::where([
                                ['financing_category_id','=',$id],
                                ['angkatan_id','=',$murid_obj->angkatans->id],
                                ['major_id','=',$murid_obj->major->id],
                            ])->first();
                            
                            $payment_input = Payment::where('student_id',$murid_obj->id)
                                            ->where('financing_category_id', $id)->first();
                            
                            $periode_id = $periode_input['id'];
                            $payment_id = $payment_input['id'];
                            
                            $status = "Waiting";
                            PaymentPeriodeDetail::create([
                                'id' => null,
                                'payment_id' => $payment_id,
                                'payment_periode_id' => $periode_id,
                                'bulan' => "",
                                'user_id' => 0,
                                'status' => $status,
                            ]);
                        }
                    }
                }
            
            }elseif($req['jurusan']==0){
                
                foreach ($jurusan as $jurusan_obj) {
                    PaymentPeriode::create([
                        'id' => null,
                        'financing_category_id' => $id,
                        'angkatan_id' => $req['angkatan'],
                        'major_id' => $jurusan_obj->id,
                        'bulan' => 0,
                        'tahun' => 0,
                        'nominal' => $req['besaran'],
                    ]);
                }

                $filter_murid = $murid->where('angkatan_id', $req['angkatan']);

                foreach ($filter_murid as $murid_obj) { 
                    Payment::create([
                        'id' => null,
                        'student_id' => $murid_obj->id,
                        'financing_category_id' => $id,
                        'persentase' => 0,
                        'jenis_pembayaran' => "Waiting",
                    ]);
                }

                $payment = Payment::all();

                $filter_payment = $payment->where('financing_category_id',$id);

                foreach ($filter_murid as $murid_obj) {
                    $periode_input = PaymentPeriode::where([
                        ['financing_category_id','=',$id],
                        ['angkatan_id','=',$murid_obj->angkatans->id],
                        ['major_id','=',$murid_obj->major->id],
                    ])->first();
                    
                    $payment_input = Payment::where('student_id',$murid_obj->id)
                                    ->where('financing_category_id', $id)->first();
                    
                    $periode_id = $periode_input['id'];
                    $payment_id = $payment_input['id'];
                    
                    $status = "Waiting";
                    PaymentPeriodeDetail::create([
                        'id' => null,
                        'payment_id' => $payment_id,
                        'payment_periode_id' => $periode_id,
                        'bulan' => "",
                        'user_id' => 0,
                        'status' => $status,
                    ]);
                }


            }elseif($req['angkatan']==0){

                $is_angkatan = [];

                foreach ($filter_angkatan as $angkatan_obj) {
                    PaymentPeriode::create([
                        'id' => null,
                        'financing_category_id' => $id,
                        'angkatan_id' => $angkatan_obj->id,
                        'major_id' => $req['jurusan'],
                        'bulan' => 0,
                        'tahun' => 0,
                        'nominal' => $req['besaran'],
                    ]);
                    $is_angkatan[] = $angkatan_obj->id;
                }
                
                $filter_murid = $murid->where('major_id', $req['jurusan'])->whereIn('angkatan_id', $is_angkatan);

                foreach ($filter_murid as $murid_obj) {
                    Payment::create([
                        'id' => null,
                        'student_id' => $murid_obj->id,
                        'financing_category_id' => $id,
                        'persentase' => 0,
                        'jenis_pembayaran' => "Waiting",
                    ]);
                }

                $payment = Payment::all();

                $filter_payment = $payment->where('financing_category_id',$id);

                foreach ($filter_murid as $murid_obj) {
                    $periode_input = PaymentPeriode::where([
                        ['financing_category_id','=',$id],
                        ['angkatan_id','=',$murid_obj->angkatans->id],
                        ['major_id','=',$murid_obj->major->id],
                    ])->first();
                    
                    $payment_input = Payment::where('student_id',$murid_obj->id)
                                    ->where('financing_category_id', $id)->first();
                    
                    $periode_id = $periode_input['id'];
                    $payment_id = $payment_input['id'];
                    
                    $status = "Waiting";
                    PaymentPeriodeDetail::create([
                        'id' => null,
                        'payment_id' => $payment_id,
                        'payment_periode_id' => $periode_id,
                        'bulan' => "",
                        'user_id' => 0,
                        'status' => $status,
                    ]);
                }

            }else{
                $filter_murid = $murid->where('major_id', $req['jurusan'])->where('angkatan_id', $req['angkatan']);

                foreach ($filter_murid as $murid_obj) {
                    Payment::create([
                        'id' => null,
                        'student_id' => $murid_obj->id,
                        'financing_category_id' => $id,
                        'persentase' => 0,
                        'jenis_pembayaran' => "Waiting",
                    ]);
                }
                PaymentPeriode::create([
                    'id' => null,
                    'financing_category_id' => $id,
                    'angkatan_id' => $req['angkatan'],
                    'major_id' => $req['jurusan'],
                    'bulan' => 0,
                    'tahun' => 0,
                    'nominal' => $req['besaran'],
                ]);

                $payment = Payment::all();

                $filter_payment = $payment->where('financing_category_id',$id);

               foreach ($filter_murid as $murid_obj) {
                    $periode_input = PaymentPeriode::where([
                        ['financing_category_id','=',$id],
                        ['angkatan_id','=',$murid_obj->angkatans->id],
                        ['major_id','=',$murid_obj->major->id],
                    ])->first();
                    
                    $payment_input = Payment::where('student_id',$murid_obj->id)
                                    ->where('financing_category_id', $id)->first();
                    
                    $periode_id = $periode_input['id'];
                    $payment_id = $payment_input['id'];
                    
                    $status = "Waiting";
                    PaymentPeriodeDetail::create([
                        'id' => null,
                        'payment_id' => $payment_id,
                        'payment_periode_id' => $periode_id,
                        'bulan' => "",
                        'user_id' => 0,
                        'status' => $status,
                    ]);
                }
            }
            
            return redirect()
                ->route('financing.index')
                ->with('success', 'Data berhasil disimpan!');

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
          
          $periodes = $data->periode->where('nominal', $req['besaran_old']);
          foreach ($periodes as $periode) {
              $periode->nominal = $req['besaran'];
              $periode->save();
          }
          $data->save();
          FinancingCategoryReset::create([
            'id' => null,
            'financing_category_id' => $id,
            'besaran' => $req['besaran'],
            'jenis' => $req['edit_jenis'],
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
        $cek = FinancingCategory::where('id', $id)->first();
        try {
            FinancingCategoryReset::where('financing_category_id', $id)->delete();
            PaymentPeriode::where('financing_category_id', $id)->delete();
            FinancingCategory::destroy($id);
            $p = Payment::where('financing_category_id', $id)->get();
            Payment::where('financing_category_id', $id)->delete();
            if($cek['jenis']=="Bayar per Bulan"){
                // Hapus PaymentPeriodeDetail aka Bayaran bayar per bulan
                for ($i=0; $i < $p->count(); $i++) { 
                    PaymentPeriodeDetail::where('payment_id',$p[$i]->id)->delete();
                }
            }else{
                //Hapus PaymentDetail aka Bayaran sekali bayar yang dicicil
                for ($i=0; $i < $p->count(); $i++) { 
                    PaymentDetail::where('payment_id',$p[$i]->id)->delete();
                }
            }
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
        return FinancingCategoryReset::select(DB::raw('@row:=@row+1 as rowNumber, format(besaran,0) as besaran'), 'jenis','created_at')
                                    ->where('financing_category_id',$id)
                                    ->orderBy('updated_at','desc')
                                    ->get();
    }

    public function periode_ajax($id = null)
    {
        return PaymentPeriode::all();
    }
    
    public function periode($id)
    {
        $prev = Auth::user();
        $prev = $prev['_previous']['url'];

        $category = FinancingCategory::where('id',$id)->get();
        $id_angkatan = PaymentPeriode::select('angkatan_id')
                        ->where('financing_category_id', $id)
                        ->where('major_id', $category[0]->major->id)->get();
        DB::statement(DB::raw('set @row:=0'));
        $periodes = PaymentPeriode::select(DB::raw('@row:=@row+1 as rowNumber'),'payment_periodes.*')
                                    ->where('financing_category_id', $id)
                                    ->where('major_id', $category[0]->major->id)
                                    ->orderBy('updated_at','desc')
                                    ->get();
        $angkatans = Angkatan::whereNotIn('id',$id_angkatan)->get();
        return view('master.financingcategory.periode',compact('periodes','category','prev','angkatans'));
    }

    /**
     * store
     */
    public function periode_store(Request $req)
    {
        $bulan = ["Desember","Januari", "Februari", "Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November"];
        $d =$req->all();
        try {
            $cek = PaymentPeriode::where([
                ['financing_category_id','=',$d['id']],
                ['angkatan_id','=',$d['angkatan']],
                ['major_id','=',$d['jurusan']],
            ])->get()->count();
            if($cek==0){
                PaymentPeriode::create([
                    'id' => null,
                    'financing_category_id' => $d['id'], 
                    'nominal' => $d['nominal'], 
                    'angkatan_id' => $d['angkatan'], 
                    'major_id' => $d['jurusan'],
                ]);
                $id = DB::getPdo()->lastInsertId(); 
                $payment = Payment::where('financing_category_id',$d['id'])->get();
                $status = "Waiting";
                for ($i=0; $i < $payment->count(); $i++) { 
                    PaymentPeriodeDetail::create([
                        'payment_periode_id' => $id,
                        'payment_id' => $payment[$i]->id,
                        'user_id' => 0,
                        'status' => $status,
                    ]);
                }
                return redirect()
                        ->route('financing.periode',$d['id'])
                        ->with('success','Berhasil ditambahkan!');
            }
            return redirect()
                    ->route('financing.periode',$d['id'])
                    ->with('error','Periode pembayaran sudah ada!');
        } catch (Throwable $th) {
            return redirect()
                    ->route('financing.periode',$d['id'])
                    ->with('error','Gagal ditambahkan!');
        }
    }

    /**
     * update periode
     */
    public function periode_update(Request $req, $id)
    {
        $bulan = ["Desember","Januari", "Februari", "Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November"];
        $d =$req->all();
        try {
            $cek = PaymentPeriode::findOrFail($d['id_periode']);
            $cek->nominal = $d['nominal'];
            $cek->save();
            $fin = FinancingCategory::findOrFail($d['id']);
            $fin->besaran=$d['nominal'];
            $fin->save();
            FinancingCategoryReset::create([
                'id'=>null,
                'financing_category_id' => $d['id'],
                'besaran' => $d['nominal'],
                'jenis' => $fin->jenis,
            ]);
            return redirect()
                    ->route('financing.periode',$d['id'])
                    ->with('success','Berhasil diubah!');
        } catch (Throwable $th) {
            return redirect()
                    ->route('financing.periode',$d['id'])
                    ->with('error','Gagal diubah!');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function periode_destroy($id,$kategori)
    {
        try {
            PaymentPeriodeDetail::where('payment_periode_id',$id)->delete();
            PaymentPeriode::destroy($id);
            return redirect()
                    ->route('financing.periode',$kategori)
                    ->with('success','Periode Pembayaran telah dihapus!');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                    ->route('financing.periode',$kategori)
                    ->with('success','Periode Pembayaran gagal dihapus!');
      }
        
    }
    
    public function showForm($id = "0")
    {
        return view('master.financingcategory.ajax.form_perbulan');
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
     * 
     * @param string invalid format for mysql
     * @return array tanggal
     */
    public function convertToArrayDateValue($date)
    {
        return explode("/", $date);
    }

    /**
     * Date time to Date array
     * 
     * @param string datetime
     * @return array tanggal
     */
    public function convertToDateArrayFromDateTime($datetime)
    {
        $data = explode(" ", $datetime);
        return explode("-",$data[0]);
    }
    
}
