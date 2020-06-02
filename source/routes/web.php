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
Route::resource('/majors', 'MajorController');
//angkatan
Route::resource('/angkatan', 'AngkatanController');
//student
Route::resource('students', 'StudentController');
Route::post('students_filter', 'StudentController@filter')->name('students.filter');

/**
 * Route resource untuk User
 */
Route::resource('user', 'UserController');

/**
 * Route resource untuk Kategori Pembiayaan
 */
Route::resource('financing', 'FinancingCategoryController');
Route::get('financing/history/{id}', 'FinancingCategoryController@history');
Route::get('financing/ajax/periode/{id}', 'FinancingCategoryController@periode_ajax');
Route::get('financing/ajax/form/{id}', 'FinancingCategoryController@showForm');
Route::get('periode/{id}','PeriodeController@periode');
Route::get('periode/all/{category}','PeriodeController@all')->name('periode.all');
Route::get('periode/all/{category}/{jurusan}','PeriodeController@showAll')->name('periode.all.setting');
Route::put('periode/all/{category}/{jurusan}','PeriodeController@showAllUpdate')->name('periode.all.setting.update');
Route::get('periode/jurusan/{category}','PeriodeController@showJurusan')->name('periode.jurusan.setting');
Route::put('periode/jurusan/{category}','PeriodeController@showJurusanUpdate')->name('periode.jurusan.setting.update');
Route::get('periode/angkatan/{category}','PeriodeController@showAngkatan')->name('periode.angkatan.setting');
Route::put('periode/angkatan/{category}','PeriodeController@showAngkatanUpdate')->name('periode.angkatan.setting.update');

/**
 * Route Periode Pembayaran
 */
Route::get('financing/periode/{id}', 'FinancingCategoryController@periode')->name('financing.periode');
Route::put('financing/periode/{id}', 'FinancingCategoryController@periode_update')->name('periode.update');
Route::post('financing/periode/store', 'FinancingCategoryController@periode_store')->name('periode.store');
Route::delete('financing/periode/destroy/{id}/{kategori}', 'FinancingCategoryController@periode_destroy')->name('periode.destroy');
 
/**
 * Route resource untuk Pembayaran
 */
Route::resource('payment', 'PaymentController');
Route::post('payment/filter', 'PaymentController@showFilter')->name('payment.filter');
Route::get('payment/category/{id}', 'PaymentController@indexKategori2')->name('payment.category');
/**
 * Route pembayaran jenis "sekali bayar"
 */
Route::post('payment/metode','PaymentController@storeMetodePembayaran')->name('payment.storeMethod');
Route::get('payment/details/{id}/{id_siswa}/{id_payment}','PaymentController@details')->name('payment.details.cicilan');
Route::post('payment/details/store','PaymentController@cicilanStore')->name('payment.details.cicilan.store');
/**
 * Route pembayaran jenis "per bulan"
 */
Route::get('payment/perbulan/{id}', 'PaymentController@showBulanan')->name('payment.monthly.show');
Route::get('payment/perbulan/detail/{payment}/{student}/{category}', 'PaymentController@showBulananDetail')->name('payment.monthly.show.detail');
Route::post('payment/perbulan/detail/','PaymentController@bulananStore')->name('payment.monthly.detail.store');
Route::put('payment/perbulan/detail/update','PaymentController@updateStatusBulanan')->name('payment.monthly.detail.update');
Route::post('payment/perbulan/detail/add','PaymentController@addPeriodeBulanan')->name('payment.monthly.detail.add');
/**
 * Route resource untuk Pengeluaran 
 */
Route::resource('expense', 'ExpenseController');
Route::post('expense/filter', 'ExpenseController@filter')->name('expense.filter');
Route::get('expense/download/{path}', 'ExpenseController@download')->name('expense.download');

/**
 * Route resource untuk Pembayaran
 */ 
Route::resource('rekap', 'RekapController');

/**
 * Route resource untuk Pembayaran
 */
Route::resource('income', 'IncomeController');
Route::post('income/filter', 'IncomeController@filter')->name('income.filter');
Route::get('income/download/{path}', 'IncomeController@download')->name('income.download');

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
 Route::get('simpanan', 'SimpananController@index')->name('simpanan');
 Route::post('simpanan/filter', 'SimpananController@filter')->name('simpanan.filter');

Route::get('/home', 'HomeController@index')->name('home');
