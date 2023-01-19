<!DOCTYPE html>
<html lang="en">

<head>
  <title>AxessEQ Chehan</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <link rel="icon" type="image/x-icon" href="{{ asset('admin/images/favicon.svg') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
  <script src="{{ asset('admin/js/jquery.slim.min.js') }}"></script>
</head>

<body>
  <div class="signInWrapper">
    <div class="signIn">
      <div class="container">
        <!-- Sign in page HTML start-->
        <div class="row align-items-center innerSignIn">
          <div class="col-md-6">
            <div class="LeftContent">
              <img src="{{ asset('admin/images/Logo.svg') }}" alt="LogoAxessEQ" />
              <h1>Welcome to admin portal</h1>
            </div>
          </div>
          <div class="col-md-6">
            <div class="signInBlock">
            @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
  

              <h2>Forgot password?</h2>
              <!-- Form HTML Start-->
              <form action="{{ route('forget.password.post') }}" method="POST">
              @csrf
                <div class="form-group mg60">
                  <input type="email" class="form-control" placeholder="Email Address" name="email" id="email">
                  @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                   @endif
                </div>
                <button type="submit" class="btn btn-primary" >Reset Password</button>
              </form>
              <!-- Form HTML End-->
            </div>
          </div>
        </div>
        <!-- Sign in page HTML End-->
        <!-- Popup start-->
        <!-- The Modal -->
        <div class="modal forgetModal" id="myModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <!-- Modal body -->
              <div id="modal">
                <div class="modal-body">
                  <button type="button" class="close" data-dismiss="modal">×</button>
                  <div class="popup">
                    <img src="images/mail.svg" alt="mail">
                    <p>Your reset password link has been sent to your email.</p>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Popup end here-->
      </div>
    </div>
  </div>


  <!-- JS Links Start -->
  <script src="{{ asset('admin/js/popper.min.js') }}"></script>
  <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
  <!-- JS Links End -->



</body>

</html>