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
        $datas = FinancingCategory::orderBy('created_at','desc')
            ->orderBy('updated_at','desc')
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


        $this->validate($request,[
            'nama' => 'required',
            'besaran' => 'required',
            'jenis' => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required'
        ]);

        try {
            $req = $request->all();
            $students = Student::all();
            $req['angkatan'] = "2";
            for ($i=0; $i < $students->count(); $i++) { 
                if($req['jurusan']=="all" && $req['angkatan']=="all"){
                    echo "semua masuk <hr>";
                }elseif($req['jurusan']=="all"){
                    if(isset($students[$i]->angkatans) && $req['angkatan']==$students[$i]->angkatans->id){
                        echo "tambah data | semua jurusan beda angkatan<hr>";
                    }
                }elseif($req['angkatan']=="all"){
                    if(isset($students[$i]->major) && $req['jurusan']==$students[$i]->major->id){
                        echo "tambah data | semua angkatan beda jurusan <hr>";
                    }
                }else{
                    if(isset($students[$i]->major) && isset($students[$i]->angkatans) && $req['angkatan']==$students[$i]->angkatans->id && $req['jurusan']==$students[$i]->major->id){
                        echo "tambah data | hanya angkatan dan jurusan tertentu <hr>";
                    }
                }
            }
            $angkatans = Angkatan::where('id',$req['angkatan'])->first();
            $thn = intval($angkatans['tahun']);
            $time_start = strtotime($thn);
            $start_loop = 0;
            if($angkatans->status=="X"){
                // $thn+=3;
            }elseif($angkatans->status=="XI"){
                // $thn+=2;
                $start_loop = 12;
            }elseif($angkatans->status=="XII"){
                $start_loop = 24;
                // $thn+=1;
            }else{
                $start_loop = 36;
                echo "ALUMNI";
            }
            $tgl_hitung = "{$thn}-07-01";
            $time = strtotime($tgl_hitung);
            $final = $time;
            for ($i=$start_loop, $count=0; $i < 36; $i++) {
                $inc = "+{$i} month"; 
                $final = date("Y-m-d", strtotime($inc, $time));
                if($i%12==0){
                    $count++;
                    echo "naik kelas ";
                }
                echo "$final <hr>";
            }
            echo '<pre>';
            echo $thn."<hr>";
            
            $time_end = date($time_start);
            $selisih = $time_end - $time_start;
            echo $time_start."<hr>";
            echo $time_end."<hr>";
            echo $selisih."<hr>";
            $temp = intval(($time_end - $time_start)/(60));
            echo "$temp bulan <hr>";
            echo $thn."<hr>";
            var_dump($req);die;
            // var_dump($cek[0]->angkatans->status);die;
            $create = FinancingCategory::create([
                'id' => null,
                'nama' => $req['nama'],
                'besaran' => $req['besaran'],
                'jenis' => $req['jenis'],
                'angkatan_id' => $req['angkatan'],
                'major_id' => $req['major'],
            ]);
            $id = DB::getPdo()->lastInsertId();
            $students = Student::all();
            for ($i=0; $i < $students->count(); $i++) {
                if($req['jurusan']=="all" && $req['angkatan']=="all"){
                    Payment::create([
                        'financing_category_id' => $id,
                        'student_id' => $students[$i]->id,
                        'jenis_pembayaran' => "Waiting",
                    ]);
                }elseif($req['jurusan']=="all"){
                    if(isset($students[$i]->angkatans) && $req['angkatan']==$students[$i]->angkatans->id){
                        Payment::create([
                            'financing_category_id' => $id,
                            'student_id' => $students[$i]->id,
                            'jenis_pembayaran' => "Waiting",
                        ]);
                    }
                }elseif($req['angkatan']=="all"){
                    if(isset($students[$i]->major) && $req['jurusan']==$students[$i]->major->id){
                        Payment::create([
                            'financing_category_id' => $id,
                            'student_id' => $students[$i]->id,
                            'jenis_pembayaran' => "Waiting",
                        ]);
                    }
                }else{
                    if(isset($students[$i]->major) && isset($students[$i]->angkatans) && $req['angkatan']==$students[$i]->angkatans->id && $req['jurusan']==$students[$i]->major->id){
                        Payment::create([
                            'financing_category_id' => $id,
                            'student_id' => $students[$i]->id,
                            'jenis_pembayaran' => "Waiting",
                        ]);
                    }
                }
            }
            //untuk history perubahan harga
            FinancingCategoryReset::create([
                'id' => null,
                'financing_category_id' => $id,
                'besaran' => $req['besaran'],
                'jenis' => $req['jenis'],
                ]);
            $date = $this->convertToDateArrayFromDateTime($create->created_at);
            if($req['jenis']=="Bayar per Bulan"){
                $periode = PaymentPeriode::create([
                    "financing_category_id" => $id,
                    'angkatan_id' => $req['angkatan'],
                    'major_id' => $req['jurusan'],
                    "nominal" => $create->besaran,
                ]);
                $payments = Payment::where('financing_category_id', $id)->get();
                $status = "Waiting";
                for ($i=0; $i < $payments->count() ; $i++) { 
                    for ($i=0; $i < 12; $i++) { 
                        # code...
                    }
                    PaymentPeriodeDetail::create([
                        'payment_periode_id' => $periode->id,
                        'payment_id' => $payments[$i]->id,
                        'user_id' => 0,
                        'status' => $status,
                    ]);
                }
            }
            return redirect()
                ->route('financing.index')
                ->with('success', 'Data jurusan berhasil disimpan!');

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
            'jenis' => 'required'
        ]);

        try {
          $req = $request->all();
          $data = FinancingCategory::findOrFail($id);
          $data->nama = $req['nama'];
          $data->besaran = $req['besaran'];
          $data->jenis = $req['jenis'];
          $data->save();
          FinancingCategoryReset::create([
            'id' => null,
            'financing_category_id' => $id,
            'besaran' => $req['besaran'],
            'jenis' => $req['jenis'],
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
