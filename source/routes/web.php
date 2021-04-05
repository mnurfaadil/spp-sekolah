<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * @description Route home
 *  
 */
Route::get('/', function () {
    return redirect()->route('home');
});

 Route::get('home', 'HomeController@index')->name('home');

//============================MASTER=================

//majors
Route::resource('/majors', 'MajorController')->middleware('cekstatus');
//angkatan
Route::resource('/angkatan', 'AngkatanController')->middleware('cekstatus');
//student
Route::get('students/naik_kelas', 'StudentController@naikKelas')->name('students.naikkelas')->middleware('cekstatus');
Route::get('students/turun_kelas', 'StudentController@turunKelas')->name('students.turunkelas')->middleware('cekstatus');
Route::post('students_filter', 'StudentController@filter')->name('students.filter')->middleware('cekstatus');
Route::resource('students', 'StudentController')->middleware('cekstatus');

/**
 * Route resource untuk User
 */
Route::resource('user', 'UserController');

/**
 * Route resource untuk User
 */
Route::resource('history', 'HistoryController');

/**
 * Route resource untuk Kategori Pembiayaan
 */
Route::resource('financing', 'FinancingCategoryController')->middleware('cekstatus');
Route::get('financing/history/{id}', 'FinancingCategoryController@history')->middleware('cekstatus');
Route::get('financing/ajax/periode/{id}', 'FinancingCategoryController@periode_ajax')->middleware('cekstatus');
Route::get('financing/ajax/form/{id}', 'FinancingCategoryController@showForm')->middleware('cekstatus');
Route::get('periode/{id}','PeriodeController@periode')->middleware('cekstatus');
Route::get('periode/ajax/{id}','PeriodeController@ajax')->middleware('cekstatus');
Route::get('periode/all/{category}','PeriodeController@all')->name('periode.all')->middleware('cekstatus');
Route::get('periode/all/{category}/{jurusan}','PeriodeController@showAll')->name('periode.all.setting')->middleware('cekstatus');
Route::put('periode/all/{category}/{jurusan}','PeriodeController@showAllUpdate')->name('periode.all.setting.update')->middleware('cekstatus');
Route::get('periode/jurusan/{category}','PeriodeController@showJurusan')->name('periode.jurusan.setting')->middleware('cekstatus');
Route::put('periode/jurusan/{category}','PeriodeController@showJurusanUpdate')->name('periode.jurusan.setting.update')->middleware('cekstatus');
Route::get('periode/angkatan/{category}','PeriodeController@showAngkatan')->name('periode.angkatan.setting')->middleware('cekstatus');
Route::put('periode/angkatan/{category}','PeriodeController@showAngkatanUpdate')->name('periode.angkatan.setting.update')->middleware('cekstatus');

/**
 * Route Periode Pembayaran
 */
Route::get('financing/periode/{id}', 'FinancingCategoryController@periode')->name('financing.periode')->middleware('cekstatus');
Route::put('financing/periode/{id}', 'FinancingCategoryController@periode_update')->name('periode.update')->middleware('cekstatus');
Route::post('financing/periode/store', 'FinancingCategoryController@periode_store')->name('periode.store')->middleware('cekstatus');
Route::delete('financing/periode/destroy/{id}/{kategori}', 'FinancingCategoryController@periode_destroy')->name('periode.destroy')->middleware('cekstatus');
 
/**
 * Route resource untuk Pembayaran
 */
Route::resource('payment', 'PaymentController')->middleware('cekstatus');
Route::post('payment/filter', 'PaymentController@showFilter')->name('payment.filter')->middleware('cekstatus');
Route::get('payment/category/{id}', 'PaymentController@indexKategori2')->name('payment.category')->middleware('cekstatus');
Route::get('payment/ajax/{id}', 'PaymentController@ajaxIndex')->name('payment.category.ajax')->middleware('cekstatus');
Route::get('payment/ajax_perbulan/{id}', 'PaymentController@ajaxIndexPerbulan')->name('payment.category.ajax.perbulan')->middleware('cekstatus');
/**
 * Route pembayaran jenis "sekali bayar"
 */
Route::post('payment/metode','PaymentController@storeMetodePembayaran')->name('payment.storeMethod')->middleware('cekstatus');
Route::get('payment/details/{id_category}/{id_siswa}/{id_payment}','PaymentController@details')->name('payment.details.cicilan')->middleware('cekstatus');
Route::post('payment/details/store','PaymentController@cicilanStore')->name('payment.details.cicilan.store')->middleware('cekstatus');
/**
 * Route pembayaran jenis "per bulan"
 */
Route::get('payment/perbulan/{id}', 'PaymentController@showBulanan')->name('payment.monthly.show')->middleware('cekstatus');
Route::get('payment/perbulan/detail/{payment}/{student}/{category}', 'PaymentController@showBulananDetail')->name('payment.monthly.show.detail')->middleware('cekstatus');
Route::get('payment/perbulan/detail/ajax/{periode}', 'PaymentController@ajaxBulananDetail')->name('payment.monthly.ajax.detail')->middleware('cekstatus');
Route::post('payment/perbulan/detail/','PaymentController@bulananStore')->name('payment.monthly.detail.store')->middleware('cekstatus');
Route::put('payment/perbulan/detail/update','PaymentController@updateStatusBulanan')->name('payment.monthly.detail.update')->middleware('cekstatus');
Route::post('payment/perbulan/detail/add','PaymentController@addPeriodeBulanan')->name('payment.monthly.detail.add')->middleware('cekstatus');
Route::get('payment/perbulan/detail/delete/{id}','PaymentController@deletePeriodeBulanan')->name('payment.monthly.detail.delete')->middleware('cekstatus');
Route::get('payment/detail/delete/{id}','PaymentController@deletePeriode')->name('payment.detail.delete')->middleware('cekstatus');
Route::get('payment/cicilan/delete/{id}/{payment}','PaymentController@deleteCicilan')->name('payment.cicilan.delete')->middleware('cekstatus');
/**
 * Route resource untuk Pengeluaran 
 */
Route::resource('expense', 'ExpenseController')->middleware('cekstatus');
Route::post('expense/filter', 'ExpenseController@filter')->name('expense.filter')->middleware('cekstatus');
Route::get('expense/download/{path}', 'ExpenseController@download')->name('expense.download')->middleware('cekstatus');

/**
 * Route resource untuk Pembayaran
 */ 
Route::resource('rekap', 'RekapController');
Route::get('rekap/ajax/custom_tunggakan', 'MenuRekapController@nominalRekapTunggakanArray');

/**
 * Route resource untuk Pembayaran
 */
Route::resource('income', 'IncomeController')->middleware('cekstatus');
Route::post('income/filter', 'IncomeController@filter')->name('income.filter')->middleware('cekstatus');
Route::get('income/download/{path}', 'IncomeController@download')->name('income.download')->middleware('cekstatus');

/**
 * Route Login
 */
 Auth::routes();
Route::get('/change', 'HomeController@edit')->name('password.edit');
Route::post('/change', 'HomeController@update')->name('password.ubah');

/**
 * Route Print
 */
Route::get('export','RekapController@index')->name('pdf');
Route::post('export','RekapController@print')->name('pdf.print');
Route::get('export_kwitansi','RekapController@listdata')->name('pdf.print.kwitansi');
Route::get('export/bulanan/{nama}/{id}','RekapController@rekapBulanan')->name('pdf.print.rekap.bulanan');
Route::post('export/siswa/','RekapController@rekapSiswa')->name('pdf.print.rekap.siswa');
//untuk jenis pembayaran bayar per bulan
Route::get('export/bulanan/rekap/{nama}/{id}/{filter?}','RekapController@rekapBulanan')->name('pdf.print.rekap.bulanan');
Route::get('export/bulanan/onepage/{nama}/{payment}/{kategori}','RekapController@kwitansiBulanan')->name('pdf.print.bulanan');
Route::get('export/bulanan/detail/{nama}/{payment}','RekapController@kwitansiBulananSatuan')->name('pdf.print.bulanan.detail');
//untuk jenis pembayaran sekali bayar
Route::post('export/sesekali/rekap/','RekapController@rekapSesekali')->name('pdf.print.rekap.sesekali');
Route::get('export/sesekali/onepage/{siswa}/{payment}/{kategory}','RekapController@kwitansiSesekali')->name('pdf.print.sesekali');
Route::get('export/sesekali/detail/{nama}/{payment}/{stat?}','RekapController@kwitansiSesekaliSatuan')->name('pdf.print.sesekali.detail');
//ajax
Route::get('export/ajax/major/{category}/{kelas?}','RekapController@ajaxMajor')->name('rekap.ajax.major');
Route::get('export/ajax/kelas/{category}/{major?}','RekapController@ajaxKelas')->name('rekap.ajax.kelas');

Route::get('laporan_bos','RekapController@ulala');
/**
 * Route Simpanan
 */
 Route::get('simpanan', 'SimpananController@index')->name('simpanan')->middleware('cekstatus');
 Route::post('simpanan/filter', 'SimpananController@filter')->name('simpanan.filter')->middleware('cekstatus');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/rekap_Pemasukan', 'MenuRekapController@indexPemasukan')->name('rekap.pemasukan');
Route::get('/rekap_Pengeluaran', 'MenuRekapController@indexPengeluaran')->name('rekap.pengeluaran');
Route::get('/rekap_bukbes', 'MenuRekapController@indexBB')->name('rekap.bukbes');
Route::get('/rekap_tunggakan/{stat?}', 'MenuRekapController@indexTunggakan')->name('rekap.tunggakan');

Route::post('/rekap_Pemasukan', 'MenuRekapController@indexPemasukanFilter')->name('rekap.pemasukan.filter');
Route::post('/rekap_Pengeluaran', 'MenuRekapController@indexPengeluaranFilter')->name('rekap.pengeluaran.filter');
Route::post('/rekap_bukbes', 'MenuRekapController@indexBukuBesarFilter')->name('rekap.bukbes.filter');
Route::post('/rekap_tunggakan/{stat?}', 'MenuRekapController@indexTunggakanFilter')->name('rekap.tunggakan.filter');

Route::get('/rekap_Pemasukan/ajax/{stat}', 'MenuRekapController@ajaxPemasukan')->name('rekap.pemasukan.ajax');
Route::get('/rekap_Pengeluaran/ajax/{stat}', 'MenuRekapController@ajaxPengeluaran')->name('rekap.pengeluaran.ajax');
Route::get('/rekap_bukbes/ajax/{stat}', 'MenuRekapController@ajaxBukuBesar')->name('rekap.bukbes.ajax');
Route::get('/rekap_tunggakan/ajax/{stat?}/{filter?}', 'MenuRekapController@ajaxTunggakan')->name('rekap.tunggakan.ajax');
Route::get('/rekap_tunggakan/ajax/{id_siswa}', 'MenuRekapController@ajaxTunggakanSiswa')->name('rekap.tunggakan.ajax.siswa');
Route::get('/rekap_tunggakan/_ajax/data/{keyword?}', 'MenuRekapController@ajaxTunggakanView')->name('rekap.tunggakan.ajax.view');
Route::get('/rekap_tunggakan/_ajax_kategori/data/{keyword?}', 'MenuRekapController@ajaxTunggakanKategoriView')->name('rekap.tunggakan.ajax.view');
Route::get('/rekap_tunggakan/data_master/{stat?}', 'MenuRekapController@ajaxTunggakanMaster')->name('rekap.tunggakan.ajax.master');

Route::post('/rekap_Pemasukan/export', 'MenuRekapController@pemasukan')->name('rekap.pemasukan.export');
Route::post('/rekap_Pengeluaran/export', 'MenuRekapController@pengeluaran')->name('rekap.pengeluaran.export');
Route::post('/rekap_bukbes/export', 'MenuRekapController@bukuBesar')->name('rekap.bukbes.export');
Route::post('/rekap_tunggakan_export', 'MenuRekapController@tunggakan')->name('rekap.tunggakan.export');

Route::get('penyesuaian', 'PenyesuaianController@index');
Route::get('penyesuaian/ajax', 'PenyesuaianController@ajax');


use Illuminate\Support\Facades\DB;
Route::get('penyesuaian/print', function() {
    $title = "Laporan Tunggakan";
    $datas = DB::table('payment_details')
            ->select(DB::raw('students.nama as nama_murid,
            financing_categories.nama as nama_kategori,
	financing_categories.id as financing_category_id,
	financing_categories.jenis as jenis_kategori,
            payment_details.id, 
            payment_details.payment_id,
            payment_details.payment_periode_id,
            angkatans.id as angkatan_id,
            majors.id as major_id,
            students.kelas,
            students.id as student_id,
            angkatans.angkatan,
            angkatans.tahun as tahun_angkatan,
            majors.inisial as inisial,
            majors.nama as jurusan, 
            count(payment_details.status) as banyak_tunggakan,
            financing_periodes.nominal,
            financing_periodes.kelas_x,
            financing_periodes.kelas_xi,
            financing_periodes.kelas_xii,
            getNominalCicilan(payment_details.id) as cicilan_dibayar,
            payments.jenis_pembayaran,
            payments.persentase,
            payments.nominal_potongan,
		payments.jenis_potongan,
	sum(payment_details.nominal) as nominal_detail,
	sum(cicilans.nominal) as nominal_cicilan,
            payment_details.status'))
            ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
            ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
            ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
            ->join('students', 'students.id', '=', 'payments.student_id')
            ->join('majors', 'majors.id', '=', 'students.major_id')
            ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
            ->leftJoin('cicilans', 'cicilans.payment_detail_id', '=', 'payment_details.id')
            ->orderBy('students.nama', 'asc')
            ->orderBy('financing_categories.nama', 'asc')
            ->groupBy('payments.id')
            ->where('payment_details.status','<>','Lunas')
            ->where('angkatans.tahun', '=', '2019')
            ->where('financing_periodes.nominal', '<>', '0')
            ->get();
    return view('export.coba', compact('title', 'datas'));
});

Route::get('penyesuaian/print/tunggakan/{kategori?}', function($kategori = "SPP") {
    $title = "Laporan Tunggakan";
    $datas = DB::table('payment_details')
            ->select(DB::raw('students.nama as nama_murid,
            financing_categories.nama as nama_kategori,
	financing_categories.id as financing_category_id,
	financing_categories.jenis as jenis_kategori,
            payment_details.id, 
            payment_details.payment_id,
            payment_details.payment_periode_id,
            angkatans.id as angkatan_id,
            majors.id as major_id,
            students.kelas,
            students.id as student_id,
            angkatans.angkatan,
            angkatans.tahun as tahun_angkatan,
            majors.inisial as inisial,
            majors.nama as jurusan, 
            count(payment_details.status) as banyak_tunggakan,
            financing_periodes.nominal,
            financing_periodes.kelas_x,
            financing_periodes.kelas_xi,
            financing_periodes.kelas_xii,
            getNominalCicilan(payment_details.id) as cicilan_dibayar,
            payments.jenis_pembayaran,
            payments.persentase,
            payments.nominal_potongan,
		payments.jenis_potongan,
	sum(payment_details.nominal) as nominal_detail,
	sum(cicilans.nominal) as nominal_cicilan,
            payment_details.status'))
            ->join('payments', 'payments.id', '=', 'payment_details.payment_id')
            ->join('financing_periodes', 'financing_periodes.id', '=', 'payment_details.payment_periode_id')
            ->join('financing_categories', 'financing_categories.id', '=', 'payments.financing_category_id')
            ->join('students', 'students.id', '=', 'payments.student_id')
            ->join('majors', 'majors.id', '=', 'students.major_id')
            ->join('angkatans', 'angkatans.id', '=', 'students.angkatan_id')
            ->leftJoin('cicilans', 'cicilans.payment_detail_id', '=', 'payment_details.id')
            ->orderBy('students.angkatan_id', 'desc')
            ->orderBy('students.nama', 'asc')
            // ->orderBy('financing_categories.nama', 'asc')
            ->groupBy('payments.id')
            // ->where('payment_details.status','<>','Lunas')
            ->where('financing_categories.nama','=',$kategori)
            // ->where('angkatans.tahun', '=', '2019')
            ->where('financing_periodes.nominal', '<>', '0')
            // ->first();
            ->get();
    // dd($datas);
    return view('export.coba', compact('title', 'datas'));
});

Route::get('penyesuaian/print/buku-besar/{keyword?}', function($tahun="2019") {
    $title = "Laporan Buku Besar";
    $datas = DB::table('pencatatans')
            ->whereYear('pencatatans.created_at', '=', $tahun)
            ->orderBy('pencatatans.created_at', 'desc')
            ->get();
    return view('export.coba_buku', compact('title', 'datas'));
});
Route::get('penyesuaian/print/pemasukan/{keyword?}', function($tahun="2019") {
    $title = "Laporan Pemasukan";
    $datas = DB::table('incomes')
            ->whereYear('incomes.created_at', '=', $tahun)
            ->orderBy('incomes.created_at', 'desc')
            ->get();
    return view('export.coba_pemasukan', compact('title', 'datas'));
});

route::get('registrasi','RegistrasiPembayaranController@index')->name('registrasi.index');
route::post('registrasi','RegistrasiPembayaranController@store')->name('registrasi.store');