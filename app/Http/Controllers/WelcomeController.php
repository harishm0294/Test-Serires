<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Student;
use App\category;
use App\Addquestion;
use App\examsubject;
use App\Aexam;
use App\result;
use App\ref_result;
use response;
use Illuminate\Support\Facades\input;
use App\Http\Requests;

use Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the home page application
     *
     * @return \Illuminate\Http\Response
     */
    public function home() {

        $category = category::with('exam')->where('status',1)->get();
        return view('welcome', compact('category'));
    }

    /**
     * Show the Exam Detials
     *
     * @return \Illuminate\Http\Response
     */
    public function examDetails($id) {
        $exams = Aexam::with('subject')->where('category', $id)->get();
        dd($exams);
    }
}
