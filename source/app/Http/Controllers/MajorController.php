<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Major;
use App\PaymentPeriode;
use App\FinancingCategory;
use DB;

class MajorController extends Controller
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
        $majors = Major::orderBy('updated_at','desc')->get();
        $no=1;
        return view('master.major.index', compact('majors','no'));
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
            'jurusan' => 'required',
            'alias' => 'required',
        ]);

        try {
            $req = $request->all();
            Major::create([
                'id' => null,
                'nama' => $req['jurusan'],
                'inisial' => $req['alias'],
            ]);
            $id = DB::getPdo()->lastInsertId();
            $categories = FinancingCategory::join('financing_periodes','financing_periodes.financing_category_id','=','financing_categories.id')->join('angkatans','angkatans.id','=','financing_periodes.angkatan_id')->groupBy(['financing_categories.id','financing_periodes.angkatan_id'])->selectRaw('financing_categories.*, financing_periodes.id as periode_id, financing_periodes.major_id, financing_periodes.angkatan_id, financing_periodes.nominal, angkatans.status')->get();
            foreach ($categories as $category) {
                $count_jurusan = $category->periode->groupBy('major_id')->count();
                if($count_jurusan>1){
                    PaymentPeriode::create([
                        'id' => null,
                        'financing_category_id' => $category->id,
                        'angkatan_id' => $category->angkatan_id,
                        'major_id' => $id
                    ]);
                }
            }
            return redirect()->route('majors.index')->with('success', 'Data jurusan berhasil disimpan!');

        }catch(Exception $e){
          return redirect()->route('majors.create')->with('error', 'Data jurusan gagal disimpan!');
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
            'jurusan' => 'required',
        ]);

        try {
            $req = $request->all();
            $major = Major::findOrFail($id);
            $major->nama = $req['jurusan'];
            $major->inisial = $req['alias'];
            $major->save();

            return redirect()->route('majors.index')->with('success', 'Data jurusan berhasil diubah!');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()->route('majors.index')->with('error', 'Data jurusan gagal diubah!');
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
            $major = Major::findOrFail($id);
            $ids = PaymentPeriode::select('financing_category_id')->groupBy('financing_category_id')->where('major_id', $id)->get();
            foreach ($ids as $key) {
                FinancingCategory::find($key->financing_category_id)->delete();
            }
            $major->delete();
            return redirect()->route('majors.index')->with('success', 'Data jurusan berhasil dihapus!');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()->route('majors.index')->with('error', 'Data jurusan gagal dihapus!');
          }
    }
}
