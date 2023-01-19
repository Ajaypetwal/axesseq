<!DOCTYPE html>
<html lang="en">

<head>
  <title>AxessEQ </title>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="{{ URL::asset('admin/images/favicon.svg') }}">
  <link rel="stylesheet" href="{{ URL::asset('admin/css/style.css') }}">
  <link rel="stylesheet" href=" {{ URL::asset('admin/css/bootstrap.min.css') }}">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="{{ URL::asset('admin/js/jquery.slim.min.js') }}"></script>
  <script>
    $(document).ready(function () {
        $("#sidebar-control").click(function () {
            $(".sidebarMenu").toggleClass("hide");
        });

        //check auth
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
                    if (data.success == false) {
                        window.location.href = "/";
                    }
                }
            })
        }
        else{
            $('.mainax').hide();
            window.location.href = '/';

            return false;
        }
    });
  </script>
</head>
<body>
{{Session::get('adminLogin');}}
