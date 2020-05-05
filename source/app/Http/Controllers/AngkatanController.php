<?php

namespace App\Http\Controllers;
use App\Angkatan;
use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;
        $angkatan = Angkatan::all();
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
            if($cek > 0 || $cek2 > 0 ){
                return redirect()
                    ->route('angkatan.index')
                    ->with('error', 'Angkatan atau tahun angkatan sudah ada!');
            }
            Angkatan::create([
                'id' => null,
                'angkatan' => $req['angkatan'],
                'tahun' => $req['tahun'],
              ]);
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
          $angkatan->save();

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
