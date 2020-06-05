<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use App\Income;
use App\Pencatatan;
use Illuminate\Support\Facades\Session;

use Storage;

class IncomeController extends Controller
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
        $datas = Income::orderBy('updated_at', 'desc')
                ->where('sumber','<>','Siswa')->get();
        $no=1;
        $bulan = Income::selectRaw('MONTH(created_at) AS bulan')
                ->groupBy('bulan')
                ->orderBy('bulan')
                // ->get();
                ->where('sumber','<>','Siswa')->get();
        $tahun = Income::selectRaw('YEAR(created_at) AS tahun')
                ->groupBy('tahun')
                ->orderBy('tahun')
                // ->get();
                ->where('sumber','<>','Siswa')->get();
        $tanggals = Income::selectRaw('DATE_FORMAT(created_at, "%W, %d-%M-%Y") as tanggal, DATE(created_at) as tanggal_value')
                ->groupBy('tanggal_value')
                ->orderBy('created_at','DESC')
                // ->whereNull('payment_detail_id')
                // ->whereNull('cicilan_id')
                ->get();
        $report['bulan'] = "";
        $report['tahun'] = "";
        return view('pemasukan.index', compact('datas','no','bulan','tahun', 'report','tanggals'));
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
        $req = $request->all();
        try {
            $sql_date = $this->convertDateToSQLDate($request->tanggal);
            $req['tanggal'] = $sql_date;
            # code...
            // menyimpan data file yang diupload ke variabel $file
            $uuid = Uuid::uuid1();
            $file = $request->file('foto');
            
            $hasil = '';
            $tipe = '';
            if (isset($file)) {
                
                $nama_file = time()."_".$file->getClientOriginalName();
                
                //cek type file
                $tipe = $file->getMimeType()=="application/pdf"?"pdf":"img";
                
                // isi dengan nama folder tempat kemana file diupload
                $tujuan_upload = 'nota';
                if($tipe=="pdf"){
                    $tujuan_upload = 'source/public/nota/';
                }
                $file->move($tujuan_upload,$uuid.$nama_file);
                $hasil = $uuid.$nama_file;
            }
            
            Income::create([
                'id' => null,
                'created_at' => $req['tanggal'],
                'title' => $req['title'],
                'description' => $req['description'],
                'sumber' => $req['sumber' ],
                'nominal' => $req['nominal'],
                'foto' => $hasil,
                'tipe' => $tipe,
            ]);
            $id = DB::getPdo()->lastInsertId();
            $desc = "Pemasukan {$req['title']} dari {$req['sumber']}";
            Pencatatan::create([
                'id' => null,
                'income_id' =>$id,
                'expense_id' =>0,
                'debit' => $req['nominal'],
                'description' => $desc,
                'kredit' => 0,
                'created_at' =>$req['tanggal'],
            ]);
          return redirect()
              ->route('income.index')
              ->with('success', 'Data Pemasukan berhasil disimpan!');

        }catch(Exception $e){
          return redirect()
              ->route('income.create')
              ->with('success', 'Data pengeluaran gagal disimpan!');
        }
    }

    public function filter(Request $request)
    {
        if(isset($request->bulan) && isset($request->tahun)){
            $datas = Income::orderBy('updated_at', 'desc')
                    ->whereMonth('created_at','=',$request->bulan)
                    ->whereYear('created_at','=',$request->tahun)
                    ->where('sumber','<>','Siswa')->get();
        }
        elseif(isset($request->tahun)){
            $datas = Income::orderBy('updated_at', 'desc')
                    ->whereYear('created_at','=',$request->tahun)
                    ->where('sumber','<>','Siswa')->get();
        }
        elseif(isset($request->bulan)){
            $datas = Income::orderBy('updated_at', 'desc')
                    ->whereMonth('created_at','=',$request->bulan)
                    ->where('sumber','<>','Siswa')->get();
        }else{
            return redirect()
                    ->route('income.index');
        }

        $no=1;
        $bulan = Income::selectRaw('MONTH(created_at) AS bulan')
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->where('sumber','<>','Siswa')->get();
        $tahun = Income::selectRaw('YEAR(created_at) AS tahun')
                ->groupBy('tahun')
                ->orderBy('tahun')
                ->where('sumber','<>','Siswa')->get();
        $report['bulan'] = $request->bulan;
        $report['tahun'] = $request->tahun;
        return view('pemasukan.index', compact('datas','no','bulan','tahun', 'report'));
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
            $sql_date = $this->convertDateToSQLDate($request->tanggal);
            $req['tanggal'] = $sql_date;
            // echo '<pre>';
            // var_dump($req);die;
            $data = Income::findOrFail($id);
            if ($request->file('foto')!='') {
                $file = $request->file('foto');
                $nama_file = time()."_".$file->getClientOriginalName();
                $tipe = $file->getMimeType()=="application/pdf"?"pdf":"img";
                $tujuan_upload = 'nota';
                if($tipe=="pdf"){
                    $tujuan_upload = 'source/public/nota/';
                }
                $file->move($tujuan_upload,$nama_file);
                $data->tipe = $tipe;
                $data->foto = $nama_file;
                
              }
            $data->title = $req['title'];
            $data->description = $req['description'];
            $data->sumber = $req['sumber'];
            $data->nominal = $req['nominal'];
            $data->created_at = $req['tanggal'];
            $data->save();

            $desc = "Pemasukan {$req['title']} dari {$req['sumber']}";

            $jur = DB::table('pencatatans')
            ->where('income_id', $id)
            ->update([
                'debit' => $req['nominal'],
                'description' => $desc,
                'created_at' => $req['tanggal']
            ]);

          return redirect()
              ->route('income.index')
              ->with('success', 'Data pemasukan berhasil diubah!');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('income.index')
              ->with('error', 'Data pemasukan gagal diubah!');
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
            Income::findOrFail($id)->delete();
            DB::table('pencatatans')
            ->where('income_id', $id)
            ->delete();
            return redirect()
                ->route('income.index')
                ->with('success', 'Data pemasukan berhasil dihapus!');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('income.index')
                ->with('error', 'Data pemasukan gagal dihapus!');
          }
    }

    public function download($path)
    {
        $pathToFile = public_path().'/nota/'.$path;
        return response()->download($pathToFile);
    }

    public function convertDateToSQLDate($date)
    {
        $temp = explode("/",$date);
        return $temp[2]."-".$temp[0]."-".$temp[1];
    }
}
