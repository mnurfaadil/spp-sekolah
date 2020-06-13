<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use App\Income;


class HistoryController extends Controller
{
    /**
     * Display a listing of the resource of Students.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;
        $today = date("Y-m-d");
        $students = Income::join('cicilans', 'cicilans.id', '=', 'incomes.cicilan_id')
                ->select(DB::raw('
                incomes.created_at,
                students.id,
                students.nama,
                students.kelas,
                majors.nama as jurusan,
                majors.inisial,
                angkatans.angkatan,
                angkatans.tahun as tahun_angkatan,
                getNominalPembayaranHariIni(students.id, "'.$today.'") as total_pembayaran
                '))
                ->join('payment_details', 'payment_details.id', '=', 'cicilans.payment_detail_id')
                ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                ->join('students', 'students.id', '=', 'payments.student_id')
                ->join('majors', 'majors.id', '=', 'students.major_id')
                ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
                ->where('sumber', 'Siswa')
                ->whereDate('incomes.created_at', $today)
                ->groupBy('students.id')
                ->get();
        return view('histori.index',compact('no','students'));
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
        $no =1;
        $today = date("Y-m-d");
        $bigDatas = Income::join('cicilans', 'cicilans.id', '=', 'incomes.cicilan_id')
                ->join('payment_details', 'payment_details.id', '=', 'cicilans.payment_detail_id')
                ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                ->join('students', 'students.id', '=', 'payments.student_id')
                ->select(DB::raw('
                incomes.created_at,
                incomes.nominal,
                incomes.title
                '))
                ->where('sumber', 'Siswa')
                ->where('students.id', $request->data)
                ->whereDate('incomes.created_at', $today)
                ->get();
        $datas = [$request->tanggal,$request->nama,$request->kelas,$request->angkatan];
        $pdf = PDF::loadView('export.history',compact('bigDatas','no','datas'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $today = date("Y-m-d");
        return Income::join('cicilans', 'cicilans.id', '=', 'incomes.cicilan_id')
                ->join('payment_details', 'payment_details.id', '=', 'cicilans.payment_detail_id')
                ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
                ->join('students', 'students.id', '=', 'payments.student_id')
                ->select(DB::raw('
                incomes.created_at,
                incomes.nominal,
                incomes.title
                '))
                ->where('sumber', 'Siswa')
                ->where('students.id', $id)
                ->whereDate('incomes.created_at', $today)
                ->get();
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
        //
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
