<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use App\Expense;
use App\Pencatatan;
use Illuminate\Support\Facades\Session;

class ExpenseController extends Controller
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
        $datas = Expense::orderBy('updated_at', 'desc')->get();
        $no=1;
        return view('pengeluaran.index', compact('datas','no'));
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
            $sql_date = $this->convertDateToSQLDate($request->tanggal);
            $req['tanggal'] = $sql_date;
            $uuid = Uuid::uuid1();
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('foto');
            
            $nama_file = time()."_".$file->getClientOriginalName();
    
            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'nota';
            $file->move($tujuan_upload,$uuid.$nama_file);
            
            Expense::create([
                'id' => null,
                'title' => $req['title'],
                'created_at' => $req['tanggal'],
                'sumber' => $req['sumber'],
                'description' => $req['description'],
                'nominal' => $req['nominal'],
                'foto' => $uuid.$nama_file,
            ]);
            $id = DB::getPdo()->lastInsertId();
            $desc = "Pembelian {$req['title']} oleh {$req['sumber']}";
            Pencatatan::create([
                'id' => null,
                'expense_id' =>$id,
                'payment_id' => 0,
                'debit' => 0,
                'description' => $desc,
                'kredit' =>$req['nominal'],
                'created_at' =>$req['tanggal'],
            ]); 

          return redirect()
              ->route('expense.index')
              ->with('success', 'Data pengeluaran berhasil disimpan!');

        }catch(Exception $e){
          return redirect()
              ->route('expense.create')
              ->with('success', 'Data pengeluaran gagal disimpan!');
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
            $sql_date = $this->convertDateToSQLDate($request->tanggal);
            $req['tanggal'] = $sql_date;
            $data = Expense::findOrFail($id);
            if ($request->file('foto')!='') {
                $file = $request->file('foto');
                $nama_file = time()."_".$file->getClientOriginalName();
                $tujuan_upload = 'nota';
                $file->move($tujuan_upload,$nama_file);
                $data->foto = $nama_file;
            }
            $data->title = $req['title'];
            $data->description = $req['description'];
            $data->sumber = $req['sumber'];
            $data->nominal = $req['nominal'];
            $data->created_at = $req['tanggal'];
            $data->save();

            $desc = "Pembelian {$req['title']} oleh {$req['sumber']}";

            $jur = DB::table('pencatatans')
            ->where('expense_id', $id)
            ->update([
                'kredit' => $req['nominal'],
                'description' => $desc,
                'created_at' => $req['tanggal']
            ]);

          return redirect()
              ->route('expense.index')
              ->with('success', 'Data pengeluaran berhasil diubah!');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('expense.index')
              ->with('error', 'Data pengeluaran gagal diubah!');
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
            Expense::findOrFail($id)->delete();
            DB::table('pencatatans')
            ->where('expense_id', $id)
            ->delete();
            return redirect()
                ->route('expense.index')
                ->with('success', 'Data pengeluaran berhasil dihapus!');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('expense.index')
                ->with('error', 'Data pengeluaran gagal diubah!');
          }
    }
    public function convertDateToSQLDate($date)
    {
        $temp = explode("/",$date);
        return $temp[2]."-".$temp[0]."-".$temp[1];
    }
}
