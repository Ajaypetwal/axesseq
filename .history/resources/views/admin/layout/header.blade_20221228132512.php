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
  <script src="{{ URL::asset('admin/js/jquery.slim.min.js') }}"></script>

  <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
  
<script>
    //check auth
    var uid = localStorage.getItem("UID");
    var authToken = localStorage.getItem("authToken");

    if(uid && authToken){
        var headers =  {
            Authorization: 'Bearer '+ authToken
        }

        $.ajax({
            url: '/api/get_user_data',
            type: "GET",emojionearea.min.js

            beforeSend: function() {
                $(document).find('span.error-text').text('');
            },
            su                    }
        }
    })emojionearea.min.js
}
});
</script>
</head>
</head>
<body>
{{Session::get('adminLogin');}}
