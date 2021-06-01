<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Admin;
use App\Student;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
use App\category;
use Illuminate\Support\Facades\Artisan;
use App;

class StudentRegController extends Controller
{

    use RegistersUsers;
    public function __construct()
    {
    //    DB::setDefaultConnection('default'); //admin section
        $this->middleware('guest');
    }
    public function showLoginForm()
    {
       $category = category::all();
       return view('student-login',compact('category'));
    }

    public function login(Request $request){

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);

        if(Auth::guard('admin')->attempt(['email'=> $request->email, 'password' => $request->password] , $request->remember))
        {
            return redirect()->intended(route('home'));
        }

        return redirect()->back()->withInput($request->only('email'));
        
    }

    public function register(Request $request){
        $this->validate($request,[
            'name' => 'required|min:3|max:15',
            'email' => 'required|unique:admins|max:35',
            'password' => 'required|min:3|max:6'
        ]);
        if ($validator->fails()) {
              return response()->json($validator);
            //    return Redirect::route('login#toregister')->withErrors($validator);
        } else {
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            Auth::guard('home');
        }
     
    }
    protected function Student_SignUp(Request $req){
        
       $validator = Validator::make($req->all(), [
           'name' => 'required',
           'student_id' => 'required|unique:users|max:100',
           'password' => 'required|min:3|max:10|confirmed',
           'contact' => 'numeric|min:10'
       ]);

       if ($validator->fails()) {
           return response()->json(array('errors'=> $validator->errors()));
       } else {
            $student = new Student;

            $student->student_id = $req->student_id;
            $student->name = $req->name;
            $student->password = bcrypt($req->password);
            $student->contact = $req->contact;
            $student->email = $req->email;
        
            $student->save();

            return response()->json(array('msg'=> "Now, You Can Login!"));
       }
   }
}
