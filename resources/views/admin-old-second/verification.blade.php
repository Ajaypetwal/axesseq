<!DOCTYPE html>
<html lang="en">

<head>
  <title>AxessEQ Chehan</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="images/favicon.svg">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery.slim.min.js"></script>

</head>

<body>
  <div class="signInWrapper">
    <div class="signIn">
      <div class="container">
        <!-- Sign in page HTML start-->
        <div class="row align-items-center innerSignIn">
          <div class="col-md-6">
            <div class="LeftContent">
              <img src="images/Logo.svg" alt="LogoAxessEQ"/>
              <h1>Welcome to admin portal</h1>
            </div>
          </div>
          <div class="col-md-6">
            <div class="signInBlock">
              <h2>Verify your phone</h2>
              <!-- Form HTML Start-->
              <form class="verifyPhone">
                <div class="form-group">
                    <p class="codeText">Verification code sent to your phone<br>
                      +1 234 567 8901</p>
                  </div>
                <div class="form-group otp d-flex">
                  <input type="text" class="form-control" placeholder="">
                  <input type="text" class="form-control" placeholder="">
                  <input type="text" class="form-control" placeholder="">
                  <input type="text" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                  <p>Didn’t recive code?<a href="#">Resend OTP</a></p>
                </div>
                <button type="submit" class="btn btn-primary">Sign in</button>
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
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- JS Links End -->
</body>

</html>