<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Student;
use App\category;
use App\Addquestion;
use App\examsubject;
use App\result;
use App\ref_result;
use response;
use Illuminate\Support\Facades\input;
use App\Http\Requests;
use App\Payment;

use Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'publish'  => 'Publish',
        ];

        $payments = Payment::where([
            'user_id' => Auth::id(),
            'status' => "TXN_SUCCESS"
        ])->get();
        
        $catIds = [];
        $examIds = [];
        foreach($payments as $key => $pay) {
            if (!empty($pay->examcode)) {
                $examIds[]= $pay->examcode;
            } elseif(!empty($pay->category)) {
                $catIds[]= $pay->category;
            }
        }

        $exam = DB::table('exam')
            ->where($data)
            ->whereIn('examcode',$examIds)
            ->orwhereIn('category',$catIds)
            ->get();

        return view('home',compact('exam'));
    }

    public function ResultList()
    {
    
        $result = DB::table('ref_result')
        ->Join('exam', 'ref_result.examcode', '=', 'exam.examcode')
        ->select('ref_result.*', 'exam.*')
        ->where('ref_result.student_id', '=', Auth::user()->student_id)
        ->get();
        
        return view('Resultlist',compact('result'));
    }


    public function Updateresultlist(Request $req){
        $data = [
    //        'publish'  => 'Publish',
            'ref_result.student_id' => Auth::user()->student_id,
            'category'   => $req->val
        ];

        $result = DB::table('ref_result')
        ->Join('exam', 'ref_result.examcode', '=', 'exam.examcode')
        ->select('ref_result.*', 'exam.*')
        ->where($data)
        ->get();
        return response()->json(array('exam' => $result)); 
    }


    public function Get_Single_Result(Request $req){
        
        $result = DB::table('result')
        ->join('exam_question', 'result.ques_id', '=', 'exam_question.id')
        ->join('users', 'users.student_id', '=', 'result.student_id')
        ->select('result.student_id' , 'users.name' ,'result.givenmarks', 'exam_question.subject')
        ->where(['exam_question.examcode'  => $req->examcode])//->sum('result.givenmarks');
        ->get();

        $cat = DB::table('exam_subject')->where('examcode',$req->examcode)->get();
        
        return response()->json(array('result' => $result, 'cat' => $cat)); 
    }

    public function Get_Detail_Result(Request $req){
        
        $question = DB::table('exam_question')
        ->where(['examcode'  => $req->examcode])//->sum('result.givenmarks');
        ->get();

        $result = DB::table('exam_question')
        ->leftJoin('result', 'result.ques_id', '=', 'exam_question.id')
        ->select('result.*')
        ->where(['exam_question.examcode' => $req->examcode , 'result.student_id' => Auth::user()->student_id ])
        ->get();
       
        return response()->json(array('result' => $result, 'question' => $question)); 
    }

    public function Updateexamlist(Request $req){
        $data = [
            'publish'  => 'Publish',
            'admin_id' => Auth::user()->admin_id,
            'category'   => $req->val
        ];

        $exam = DB::table('exam')->where($data)->get();
    //    dump($exam);
    //    return response()->json($exam); 
        return response()->json(array('exam' => $exam)); 
     //   dump($req);
    }

    public function Adduserresponse(Request $req) {
    
        $data = [
             'id'  => $req->ques_id,
            'student_id' => Auth::user()->student_id
        ];

        $result = result::updateOrCreate(
            ['ques_id' => $req->ques_id, 'student_id' => Auth::user()->student_id],
            ['selected_option' => $req->selected_option, 'givenmarks' => $req->givenmarks]
        );
       
        return response()->json($result);
    }

    public function AttemptNewExam(Request $req){
      //  $ref_result = new ref_result;

        $ref_result = ref_result::updateOrCreate(
            ['student_id' => Auth::user()->student_id, 'examcode' => $req->examcode]
        );
    //    $ref_result->student_id = Auth::user()->student_id;
    //    $ref_result->examcode = $req->examcode;
    //    $ref_result->save();
        return response()->json($ref_result);
    }
    public function startexam($id, $title, $tname, $cat, $time) {

        $data = [
            'examcode'   => $id
        ];
        
        $subject = DB::table('exam_subject')->where($data)->get();
        $question = DB::table('exam_question')->where($data)->get();
    
        return view('Startexam',compact('question','subject','time','id'));
    }

    public function thankyou(request $request){
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/'.$request->payment_request_id.'/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array("X-Api-Key:XXXXXXXXXXXXXXXXXXXXXXXXXXXX",
                        "X-Auth-Token:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"));
        $response = curl_exec($ch);
        curl_close($ch); 
        $data =  json_decode($response, true);

        if($data['success']) 
        {
            $carbon = new Carbon(); 
            $carbon = $carbon->addYears(1);
            
            $student = Student::find(Auth::user()->id);
            $student->fee = $data['payment_request']['amount'];
            $student->validity = $carbon->toDateTimeString();
            $student->payment_request_id = $request->payment_request_id;
            $student->save();
        } 
            

        dump($data);
        return view('payment/thankyou',compact('data'));
       // return $request->payment_id;
    }
    public function Order(){
        $admin = DB::table('admins')->where('id',Auth::user()->admin_id)->get();
     //  dump($admin);
        $prd_name = "Test Series";
        $price = $admin[0]->student_fee;
    
        if($price == NULL) {
            $price = 100;
        }
        // Price calculation with tax and fee
        $fee = 3 +($price*.02);
        $tax = 0;
        $prd_price = $fee + $tax + $price;	
        return view('payment/order',compact('admin','prd_name','price','fee','tax', 'prd_price'));
    }
    public function pay(){
        $admin = DB::table('admins')->where('id',Auth::user()->admin_id)->get();
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array("X-Api-Key:XXXXXXXXXXXXXXXXXXXXXXXXXXXX",
                          "X-Auth-Token:XXXXXXXXXXXXXXXXXXXXXXXXXXXX"));

         $price = $admin[0]->student_fee;
    
        // Price calculation with tax and fee
        $fee = 3 +($price*.02);
        $tax = 0;
        $prd_price = $fee + $tax + $price;

        $payload = Array(
            'purpose' => 'Test Series',
            'amount' => $prd_price,
            'phone' => Auth::user()->contact,
            'buyer_name' => Auth::user()->name,
            'redirect_url' => url('/payment/thankyou'),
            'send_email' => true,
            'webhook' => url('/payment/webhook/'),
            'send_sms' => true,
            'email' => 'sunny6142@gmail.com',
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch); 
        
        $data =  json_decode($response, true);
        //dump($data['payment_request']['longurl']);
        if($data['payment_request']['longurl'] != null)
            return redirect($data['payment_request']['longurl']);
        else{
            dump("Internet Connection Not Found!!");
        }
    }

    public function Logout(){

        $admin_id = Auth::user()->admin_id;

        auth()->logout();
    
        session()->flash('message', 'goodbye');
    
        if($admin_id) 
        return redirect('/StudentLogin/'.$admin_id);
        return redirect('/');
    }
}
