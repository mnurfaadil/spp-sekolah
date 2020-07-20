<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Angkatan;
use App\PaymentPeriode;
use App\FinancingCategory;
use DB;

class AngkatanController extends Controller
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
        $no = 1;
        $angkatan = Angkatan::orderBy('updated_at','desc')->get();
        return view('master.angkatan.index',compact('angkatan','no'));
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
            'angkatan' => 'required|numeric',
            'tahun' => 'required|numeric',
        ]);

        try {
            $req = $request->all();
            $cek = Angkatan::where('angkatan',$req['angkatan'])->count();
            $cek2 = Angkatan::where('tahun',$req['tahun'])->count();
            $cek3 = Angkatan::where('status',$req['status'])->count();
            
            if($cek > 0 || $cek2 > 0 ){
                return redirect()
                    ->route('angkatan.index')
                    ->with('error', 'Angkatan atau tahun angkatan sudah ada!');
            }
            if($cek3 > 0 && $req['status']!="ALUMNI"){
                return redirect()
                    ->route('angkatan.index')
                    ->with('error', 'Kelas sudah terisi!');
            }
            Angkatan::create([
                'id' => null,
                'angkatan' => $req['angkatan'],
                'tahun' => $req['tahun'],
                'status' => $req['status'],
            ]);
            $id = DB::getPdo()->lastInsertId();
            $categories = FinancingCategory::join('financing_periodes','financing_periodes.financing_category_id','=','financing_categories.id')
                            ->groupBy(['financing_categories.id','financing_periodes.major_id'])
                            ->selectRaw('financing_categories.*, financing_periodes.id as periode_id, financing_periodes.major_id, financing_periodes.angkatan_id, 
                            financing_periodes.nominal')
                            ->get();
            foreach ($categories as $category) {
                $count_angkatan = $category->periode->groupBy('angkatan_id')->count();
                if($count_angkatan>1){
                    PaymentPeriode::create([
                        'id' => null,
                        'financing_category_id' => $category->id,
                        'angkatan_id' => $id,
                        'major_id' => $category->major_id
                    ]);
                }
            }
            return redirect()
                ->route('angkatan.index')
                ->with('success', 'Data angkatan berhasil disimpan!');
        }catch(Exception $e){
          return redirect()
              ->route('angkatan.create')
              ->with('error', 'Data angkatan gagal disimpan!');
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
        $this->validate($request,[
            'angkatan2' => 'required',
            'tahun2' => 'required',
        ]);

        try {
            $req = $request->all();
            $angkatan = Angkatan::findOrFail($id);
            $angkatan->angkatan = $req['angkatan2'];
            $angkatan->tahun = $req['tahun2'];
            $angkatan->status = $req['status'];
            $angkatan->save();
            $siswa = Student::where('angkatan_id', $angkatan->id)->get();
            foreach ($siswa as $key => $value) {
                $value->kelas = $angkatan->status;
                $value->save();
            }

          return redirect()
              ->route('angkatan.index')
              ->with('success', 'Data angkatan berhasil diubah!');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('angkatan.index')
              ->with('error', 'Data angkatan gagal diubah!');
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
        //
    }
}
