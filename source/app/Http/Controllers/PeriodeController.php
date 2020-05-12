<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\FinancingCategory;
use App\FinancingCategoryReset;
use App\Payment;
use App\PaymentDetail;
use App\PaymentPeriode;
use App\PaymentPeriodeDetail;
use App\Student;
use App\Angkatan;
use App\Major;

use DB;

class PeriodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $periodes = PaymentPeriode::select(DB::raw('@row:=@row+1 as rowNumber'),'financing_periodes.*')
                                    ->where('financing_category_id', $id)
                                    ->where('major_id', $category[0]->major->id)
                                    ->orderBy('updated_at','desc')
                                    ->get();
        $angkatans = Angkatan::whereNotIn('id',$id_angkatan)->get();
        return view('master.financingcategory.periode',compact('periodes','category','prev','angkatans'));
    }
    
    /**
     * Start Method
     * Buat menampilkan data nominal pembiayaan
     * Semua Jurusan Semua Angkatan
     */

    public function all($kategori)
    {
        $category = FinancingCategory::where('id',$kategori)->get();
        $periodes = PaymentPeriode::where('financing_category_id',$kategori)
                    ->orderBy('financing_periodes.updated_at','desc')
                    ->groupBy('major_id')->get();
        return view('master.financingcategory.periode_all',compact('periodes','category'));
    }

    public function showAll($kategori, $jurusan)
    {
        $category = FinancingCategory::where('id',$kategori)->get();
        $periodes = PaymentPeriode::where('financing_category_id',$kategori)
                ->orderBy('financing_periodes.updated_at','desc')
                ->where('major_id',$jurusan)->get();
        return view('master.financingcategory.periode_all_setting',compact('periodes','category'));   
    }

    public function showAllUpdate(Request $request, $kategori, $jurusan)
    {
        $periode = PaymentPeriode::findOrFail($request->id);
        $category = FinancingCategory::findOrFail($periode->financing_category_id);
        $temp = $category->nama;
        $category->nama = "";
        $category->save();
        $category->nama = $temp;
        $category->save();  
        $periode->nominal = $request->nominal;
        $periode->save();
        return redirect()
            ->route('periode.all.setting', [$request->kategori, $request->jurusan])
            ->with('success','Nominal berhasil diubah');
    }

    //End Method

    /**
     * Start Method
     * Buat menampilkan data nominal pembiayaan
     * Semua Jurusan Satu Angkatan
     */

    public function showJurusan($kategori)
    {
        $category = FinancingCategory::where('id', $kategori)->get();
        $periodes = PaymentPeriode::where([
                ['financing_category_id','=',$kategori],
            ])->orderBy('financing_periodes.updated_at','desc')
            ->get();
        return view('master.financingcategory.periode_jurusan_setting',compact('periodes','category'));   
    }

    public function showJurusanUpdate(Request $request, $kategori)
    {
        $periode = PaymentPeriode::findOrFail($request->id);
        $category = FinancingCategory::findOrFail($periode->financing_category_id);
        $temp = $category->nama;
        $category->nama = "";
        $category->save();
        $category->nama = $temp;
        $category->save();
        $periode->nominal = $request->nominal;
        $periode->save();
        return redirect()
            ->route('periode.jurusan.setting', [$request->kategori])
            ->with('success','Nominal berhasil diubah');
    }

    //End Method

    /**
     * Start Method
     * Buat menampilkan data nominal pembiayaan
     * Semua Jurusan Satu Angkatan
     */

    public function showAngkatan($kategori)
    {
        $category = FinancingCategory::where('id', $kategori)->get();
        $periodes = PaymentPeriode::where([
                ['financing_category_id','=',$kategori],
            ])->orderBy('financing_periodes.updated_at','desc')
            ->get();
        return view('master.financingcategory.periode_angkatan_setting',compact('periodes','category'));   
    }

    public function showAngkatanUpdate(Request $request, $kategori)
    {
        $periode = PaymentPeriode::findOrFail($request->id);
        $category = FinancingCategory::findOrFail($periode->financing_category_id);
        $temp = $category->nama;
        $category->nama = "";
        $category->save();
        $category->nama = $temp;
        $category->save();
        $periode->nominal = $request->nominal;
        $periode->save();
        return redirect()
            ->route('periode.angkatan.setting', [$request->kategori])
            ->with('success','Nominal berhasil diubah');
    }

    //End Method

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
