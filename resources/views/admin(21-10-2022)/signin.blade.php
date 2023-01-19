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

<body class="mainax">
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
                            <h2>Sign in</h2>
                            <div class="response"></div>
                            <!-- Form HTML Start-->
                            <form id="loginForm" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" name="email" placeholder="Username"
                                        id="username" required>

                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                        id="pwd" required>

                                </div>
                                <div class="form-group form-check">
                                    <label class="form-check-label">
                                        <a href="{{ route('forget.password.get') }}">Forget password? </a>
                                    </label>

                                </div>
                                <button type="submit" class="btn btn-primary">Sign in</button>
                            </form>

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        var uid = localStorage.getItem("UID");
        var authToken = localStorage.getItem("authToken");

        if(uid && authToken){
            var headers =  {
                Authorization: 'Bearer '+ authToken
            }

            $.ajax({
                url: '/api/get_user_data',
                type: "GET",
                headers : headers,
                data: {
                    '_token': "<?php echo csrf_token(); ?>",
                    'user_id' : uid
                },

                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.success == true) {
                        $('.mainax').hide();
                        window.location.href = "/dashboard";
                    }
                }
            })
        }

        //Login form submit
        $("#loginForm").submit(function(e) {
            e.preventDefault();

            var all = $(this).serialize();

            $.ajax({
                url: '/api/login',
                type: "POST",
                data: {
                    '_token': "<?php echo csrf_token(); ?>",
                    'email' : $('#username').val(),
                    'password' : $('#pwd').val(),
                    'user_admin' : true
                },
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.success == false) {
                        $('.response').html('<p class="error-response">'+ data.error+'</p>')
                    }
                    else{
                        $('.response').html('<p class="success-response">'+ data.message+'</p>');
                        if(data.access_token){
                            localStorage.setItem('authToken', data.access_token);
                            localStorage.setItem('UID', data.data._id);
                            window.location.href = "/dashboard";
                        }
                        else{
                            $('.response').html('<p class="error-response"> Something went wrong </p>')
                        }
                    }
                }
            })
        });
    });
    </script>
</body>

</html>