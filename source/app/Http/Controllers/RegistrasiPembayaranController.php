<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FinancingCategory;
use App\Student;
use DB;

class RegistrasiPembayaranController extends Controller
{
	public function __construct()
    {
        set_time_limit(300);
        $this->middleware('auth');
    }
    
    public function index()
    {
    	$students = Student::pluck('nama', 'id');
    	return view('master.registrasi.index', [
    		'students' => $students
    	]);
    }

    public function store(Request $request)
    {
    	$categories = DB::select("SELECT * FROM financing_categories WHERE id NOT IN (SELECT DISTINCT financing_category_id FROM payments WHERE student_id = ". $request .") ");
    	return response()->json($categories);
    }

    
    // foreach ($categories as $category) {
    //             $payment = Payment::create([
    //                 'financing_category_id' => $category->id,
    //                 'student_id' => $id,
    //                 'jenis_pembayaran' => "Waiting",
    //             ]);
    //             if($category->jenis=="Bayar per Bulan"){
    //                 $temp = explode("-", $date);
    //                 $thn = $temp[0];
    //                 $tgl_hitung = "{$thn}-07-01";
    //                 $time = strtotime($tgl_hitung);
    //                 for ($j=0, $count=0; $j < 36; $j++) {
    //                     $inc = "+{$j} month"; 
    //                     $final = date("Y-m-d", strtotime($inc, $time));
    //                     $status = "Waiting";
    //                     PaymentDetail::create([
    //                         'id' => null,
    //                         'payment_id' => $payment->id,
    //                         'payment_periode_id' => $category->periode_id,
    //                         'nominal_bayar' => $category->periode_id,
    //                         'bulan' => $final,
    //                         'user_id' => 0,
    //                         'status' => $status,
    //                     ]);
    //                     if($j%12==0){
    //                         $count++;
    //                     }
    //                 }
    //             }else{
    //                 PaymentDetail::create([
    //                     'id' => null,
    //                     'payment_id' => $payment->id,
    //                     'payment_periode_id' => $category->periode_id,
    //                     'user_id' => 0,
    //                     'status' => "Waiting"
    //                 ]);
    //             }
    //         }
}
?>