<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <!-- CSRF Token -->
        <meta id="token" name="token" content="{{ csrf_token() }}">   
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
       	<meta name="keywords" content="Test Series, Conduct your online exam, online exam, exam portal, test, test series, SSC exam, coaching online exam platform, exam corner,">
      	<meta name="author" content="Harish Meshram">

	      <title>Test Series &mdash; Conduct you Exam with Us</title>

    <!-- Bootstrap core CSS -->
    <link href="{{url('/landing/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
     <!-- Custom fonts for this template -->
    <link href="{{ url('/landing/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="{{url('landing/vendor/magnific-popup/magnific-popup.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{url('landing/css/creative.min.css')}}" rel="stylesheet">
 
  </head>

  <body id="page-top">

    <!--Student Login  - ---------------------------- -->
    <div class="modal fade" id="studentlogin" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="padding:35px 50px;">
              <h4><span class="glyphicon glyphicon-lock"></span>Student Login</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body" style="padding:40px 50px;">
      
            <form role="form">
              <div class="form-group hidden">
                <span class="alert-danger " id="error_msg"></span>
              </div>
              <div class="form-group">
                <label for="usrname"><span class="glyphicon glyphicon-user"></span> Student Id</label>
                <input type="text" class="form-control" id="loginstudent_id" name="loginstudent_id" placeholder="Enter student Id">
                <span class="help-block hidden" id="error_student_id">
                </span>     
              </div>
              <div class="form-group">
                <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
                <input type="password" class="form-control" id="loginpassword" name="loginpassword" placeholder="Enter password">
                <span class="help-block hidden" id="error_student_pass">
                </span>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} style="margin-right:15px" >Remember me</label>
              </div>
              </form>
              <button id="std-login" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
          
          </div>
          <div class="modal-footer text-center">
            <p>Not a member? <a href="#">Sign Up</a></p>
            <p>Forgot <a href="#">Password?</a></p> 
          </div>
        </div>
        
      </div>
    </div> 
  <!-- EndLogin - ---------------------------- -->
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="{{url('/')}}">Test Series</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            @if (Route::has('login'))
              @auth
                <li class="nav-item">
                  <a  class="nav-link js-scroll-trigger" href="{{ url('/home') }}">Back To Exam</a>
                </li>
            @else
            <!-- data-toggle="modal" data-target="#studentlogin" -->
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="{{ url('/login') }}" >Student</a>
              </li>
              @endauth
            @endif
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#services">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <section class=" text-white" style="background-color: #72d042;">
      <div class="container text-center">
        <h2 class="mb-4">{{ $category->category }}</h2>
        <p class="mb-1"><b>Price: ₹ {{ $category->fee }}</b></p>
      </div>
    </section>
    <section class="">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Tests</h2>
            <hr class="my-4">
          </div>
        </div>
      </div>
      <div class="container text-center">
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start mb-2">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">List group item heading</h5>
              <small>3 days ago</small>
            </div>
            <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
            <small>Donec id elit non mi porta.</small>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start mb-2">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">List group item heading</h5>
              <small class="text-muted">3 days ago</small>
            </div>
            <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
            <small class="text-muted">Donec id elit non mi porta.</small>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start mb-2">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">List group item heading</h5>
              <small class="text-muted">3 days ago</small>
            </div>
            <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
            <small class="text-muted">Donec id elit non mi porta.</small>
          </a>
        </div>  
      </div>
    </section>
    <section id="contact" class="bg-dark text-white">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading">Let's Get In Touch!</h2>
            <hr class="my-4">
            <p class="mb-5">Ready to conduct your next exam with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 ml-auto text-center">
            <i class="fa fa-phone fa-3x mb-3 sr-contact"></i>
            <p>8770775732</p>
          </div>
          <div class="col-lg-4 mr-auto text-center">
            <i class="fa fa-envelope-o fa-3x mb-3 sr-contact"></i>
            <p>
              <a href="mailto:contact@allexamcorner.org">testseries@gmail.com</a>
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="{{url('landing/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{url('landing/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{url('landing/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{url('landing/vendor/scrollreveal/scrollreveal.min.js')}}"></script>
    <script src="{{url('landing/vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{url('landing/js/creative.min.js')}}"></script>

  <script>
    // Add Question
    $(document).ready(function(){
            
            $("#std-login").click(function(){
              
                $("#std-login").addClass('hidden'); 
                $('#std-login').text(""); 
                $('#std-login').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Processing ...');

                var data = new FormData();

                data.append('student_id', $('input[name=loginstudent_id]').val());
                data.append('password', $('input[name=loginpassword]').val());
                data.append('remember', $('input[name=remember]').val());
                $("#error_msg").text(''); 
                $("#error_msg").addClass('hidden'); 
               $.ajax({
                   type : 'POST',
                   url : '/ajaxstudentlogin',
                   data: data,
                   contentType: false,
                   processData: false,
                   beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                
                   success: function(data) {
                       
                        
                        $('#std-login').text(""); 
                        $('#std-login').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Connecting ...');
                        console.log(data);
                        if(data.errors){
                       //     alert("err");
                            $("#error_msg").removeClass('hidden'); 
                            $('#error_msg').text("credentials are not correct");
                            $('#std-login').text(""); 
                            $('#std-login').append('Login');
                        } else{
                            $('#std-login').text(""); 
                            $('#std-login').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Redirecting ...');
                            window.location.replace("/home");
                            $('#add_question_msg').text("Question Successfully Added");
                            console.log("ABC");
                        }
                   }
               }).fail(function (jqXHR, textStatus, error) {
                        
                        $('#errorModal').modal('show');
                 });
            });
        });
  </script>
  </body>

</html>
