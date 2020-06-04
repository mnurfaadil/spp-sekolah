<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Major;
use App\Student;
use App\FinancingCategory;
use App\Payment;
use App\PaymentPeriodeDetail;
use App\PaymentDetail;
use App\Angkatan;
use Illuminate\Support\Facades\Session;

use DB;

class StudentController extends Controller
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
        // $angkatan = Angkatan::where('status','<>','ALUMNI')->get();
        $angkatan = Angkatan::all();
        $students = Student::orderBy('updated_at','desc')->get();
        $no=1;
        $fil = '';
        $fil2 = '';
        $kls = '';
        $majors = Major::all();
        $jml = $majors->count();

        return view('master.student.index', compact('students','no','jml','majors','fil','kls','angkatan','fil2'));
    }

    public function filter(Request $request)
    {
        $master = Student::all();
        $request->kelas = $request->kelas == "all" ? "" : $request->kelas;
        $request->jurusan = $request->jurusan == "all" ? "" : $request->jurusan;
        $request->angkatan = $request->angkatan == "all" ? "" : $request->angkatan;

        if($request->kelas=='' && $request->jurusan!='' && $request->angkatan==''){
            $students = $master->where('major_id', $request->jurusan)->sortBy('kelas');
        }elseif ($request->jurusan=='' && $request->kelas!='' && $request->angkatan=='') {
            $students = $master->where('kelas', $request->kelas)->sortBy('kelas');
        }elseif ($request->jurusan=='' && $request->kelas=='' && $request->angkatan!='') {
            $students = $master->where('angkatan_id', $request->angkatan)->sortBy('kelas');
        }elseif ($request->jurusan!='' && $request->kelas!='' && $request->angkatan=='') {
            $students = $master->where('kelas', $request->kelas)
                        ->where('major_id', $request->jurusan)
                        ->sortBy('kelas');
        }elseif ($request->jurusan=='' && $request->kelas!='' && $request->angkatan!='') {
            $students = $master->where('kelas', $request->kelas)
                        ->where('angkatan_id', $request->angkatan)
                        ->sortBy('kelas');
        }elseif ($request->jurusan!='' && $request->kelas=='' && $request->angkatan!='') {
            $students = $master->where('major_id', $request->jurusan)
                        ->where('angkatan_id', $request->angkatan)
                        ->sortBy('kelas');
        }elseif ($request->jurusan!='' && $request->kelas!='' && $request->angkatan!='') {
            $students = $master->where('kelas', $request->kelas)
                        ->where('angkatan_id', $request->angkatan)
                        ->where('major_id', $request->jurusan)
                        ->sortBy('kelas');
        }else{
            $students = $master->sortBy('kelas');
        }
        $no=1;
        $kls=$request->kelas;
        $fil= $request->jurusan;
        $fil2=$request->angkatan;
        $jml = Major::count();
        $majors = Major::all();
        $angkatan = Angkatan::all();
        return view('master.student.index', compact('students','no','jml','majors','fil','fil2','kls','angkatan'));
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
        try {
            $req = $request->all();
            $cek = Student::where('nis',$req['nis'])
                ->count();
                
            if($cek > 0){
                return redirect()
                    ->route('students.index')
                    ->with('error','Data Sudah Ada!!');
            }
            $date = $this->convertDateToSQLDate($req['tgl_masuk']);
            if ($req['alamat']==null) {
                $req['alamat'] = '';
            }
            if ($req['phone'] == null) {
                $req['phone'] = '';
            }
            if ($req['email'] == null) {
                $req['email'] = '';
            }
            if ($req['simpanan'] == null) {
                $req['simpanan'] = 0;
            }
            $categories = FinancingCategory::join('financing_periodes','financing_periodes.financing_category_id','=','financing_categories.id')
                            ->where('financing_periodes.major_id', $request->major_id)
                            ->where('financing_periodes.angkatan_id', $request->angkatan)
                            ->groupBy('financing_categories.id')
                            ->selectRaw('financing_categories.*, financing_periodes.id as periode_id, financing_periodes.major_id, financing_periodes.angkatan_id, 
                            financing_periodes.nominal')
                            ->get();
            $student = Student::create([
                'id' => null,
                'nis' => $req['nis'],
                'nama' => $req['nama'],
                'jenis_kelamin' => $req['jenis_kelamin'],
                'major_id' => $req['major_id'],
                'phone' => $req['phone'],
                'angkatan_id' => $req['angkatan'],
                'email' => $req['email'],
                'simpanan' => $req['simpanan'],
                'alamat' => $req['alamat'],
                'tgl_masuk' => $date,
                'kelas' => $req['kelas'],
            ]);
            $id = DB::getPdo()->lastInsertId();
            foreach ($categories as $category) {
                $payment = Payment::create([
                    'financing_category_id' => $category->id,
                    'student_id' => $id,
                    'jenis_pembayaran' => "Waiting",
                ]);
                if($category->jenis=="Bayar per Bulan"){
                    $temp = explode("-", $date);
                    $thn = $temp[0];
                    $tgl_hitung = "{$thn}-07-01";
                    $time = strtotime($tgl_hitung);
                    for ($j=0, $count=0; $j < 36; $j++) {
                        $inc = "+{$j} month"; 
                        $final = date("Y-m-d", strtotime($inc, $time));
                        $status = "Waiting";
                        PaymentDetail::create([
                            'id' => null,
                            'payment_id' => $payment->id,
                            'payment_periode_id' => $category->periode_id,
                            'bulan' => $final,
                            'user_id' => 0,
                            'status' => $status,
                        ]);
                        if($j%12==0){
                            $count++;
                        }
                    }
                }else{
                    PaymentDetail::create([
                        'id' => null,
                        'payment_id' => $payment->id,
                        'payment_periode_id' => $category->periode_id,
                        'user_id' => 0,
                        'status' => "Waiting"
                    ]);
                }
            }
          return redirect()
            ->route('students.index')
            ->with('success', 'Data siswa berhasil disimpan!');
        }catch(Exception $e){
          return redirect()
            ->route('students.index')
            ->with('error', 'Data siswa gagal disimpan!');
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
        
        try {
            $req = $request->all();
            if ($req['alamat']==null) {
                $req['alamat'] = '';
            }
            if ($req['phone'] == null) {
                $req['phone'] = '';
            }
            if ($req['email'] == null) {
                $req['email'] = '';
            }
            if ($req['simpanan'] == null) {
                $req['simpanan'] = 0;
            }
            $student = Student::findOrFail($id);
            $student->nama = $req['nama'];
            $student->nis = $req['nis'];
            $student->jenis_kelamin = $req['jenis_kelamin'];
            $student->major_id = $req['major_id'];
            $student->kelas = $req['kelas'];
            $student->phone = $req['phone'];
            $student->email = $req['email'];
            $student->alamat = $req['alamat'];
            $student->simpanan = $req['simpanan'];
            $student->tgl_masuk = $req['tgl_masuk'];
            $student->save();

          return redirect()
              ->route('students.index')
              ->with('success', 'Data siswa berhasil diubah!');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('students.index')
              ->with('error', 'Data siswa gagal diubah!');
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
            $Student = Student::findOrFail($id)->delete();
  
            return redirect()
                ->route('students.index')
                ->with('success', 'Data siswa berhasil dihapus!');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('students.index')
                ->with('error', 'Data siswa gagal diubah!');
          }
    }

    public function convertDateToSQLDate($date)
    {
        $temp = explode("/",$date);
        return $temp[2]."-".$temp[0]."-".$temp[1];
    }
}
