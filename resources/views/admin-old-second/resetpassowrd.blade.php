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
              <img src="{{ asset('admin/images/Logo.svg') }}" alt="LogoAxessEQ"/>
              <h1>Welcome to admin portal</h1>
            </div>
          </div>
          <div class="col-md-6">
            <div class="signInBlock resetpassowrd">
              <h2>Reset password</h2>
              <!-- Form HTML Start--> 
              <form class="verifyPhone" action="{{ route('reset.password.post') }}" method="POST">
              @csrf
                
              <div class="form-group">
                  <input type="text" class="form-control" name="email" placeholder="Email">
                  @if ($errors->has('email'))
               <span class="text-danger">{{ $errors->first('email') }}</span>
             @endif
                  </div>

                <div class="form-group">
                  <input type="text" class="form-control" name="password" placeholder="New password">
                  @if ($errors->has('password'))
               <span class="text-danger">{{ $errors->first('password') }}</span>
             @endif
                  </div>
                  <div class="form-group mb40">
                  <input type="text" class="form-control"  name="password_confirmation"  placeholder="Re-type password">
                  @if ($errors->has('password_confirmation'))
                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                   @endif
                  </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
              </form>
              <!-- Form HTML End-->
            </div>
          </div>
        </div>
        <!-- Sign in page HTML End-->
      </div>
    </div>
  </div>
  <!-- JS Links Start -->
  <script src="{{ asset('admin/js/popper.min.js') }}"></script>
  <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
  <!-- JS Links End -->
</body>
<!-- Modal HTML Start -->
  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-dialog-centeredinner">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          Modal body..
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      </div>
      </div>
    </div>
  </div>
<!-- Modal HTML End -->
</html>