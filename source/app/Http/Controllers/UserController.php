<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
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
        $users = User::orderBy('id', 'desc')->get();
        $no=1;
        return view('master.user.index', compact('users','no'));
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
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            ]);

        $cek = User::where('username', $request->username)->count();
        $cek2 = User::where('email', $request->email)->count();

        if($cek > 0)
        {
            return redirect()
              ->route('user.index')
              ->with('error', 'Username telah digunakan !');
        }
        if($cek2 > 0)
        {
            return redirect()
              ->route('user.index')
              ->with('error', 'Email telah digunakan !');
        }
            
        try {
            $req = $request->all();
            User::create([
                'id' => null,
                'name' => $req['nama'],
                'username' => $req['username'],
                'email' => $req['email'],
                'role' => $req['role'],
                'password' => Hash::make($req['password']),
              ]);
          return redirect()
              ->route('user.index')
              ->with('success', 'User baru telah ditambahkan!');

        }catch(Exception $e){
          return redirect()
              ->route('user.index')
              ->with('error', 'Gagal menambah user!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $this->validate($request,[
            'nama' => 'required',
        ]);

        try {
          $req = $request->all();
          $user = User::findOrFail($id);
          $user->name = $req['nama'];
          $user->save();

          return redirect()
              ->route('user.index')
              ->with('success', 'Data user berhasil diubah!');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('user.index')
              ->with('error', 'Data user gagal diubah!');
        }
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
            'nama' => 'required',
        ]);

        try {
          $req = $request->all();
          $major = User::findOrFail($id);
          $major->name = $req['nama'];
          $major->save();

          return redirect()
              ->route('user.index')
              ->with('success', 'Data user berhasil diubah!');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('user.index')
              ->with('error', 'Data user gagal diubah!');
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
            $user = User::findOrFail($id)->delete();
  
            return redirect()
                ->route('user.index')
                ->with('success', 'Data user berhasil dihapus!');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('user.index')
                ->with('error', 'Data jurusan gagal diubah!');
          }
    }
}
