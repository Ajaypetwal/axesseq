@include('admin.layout.header')
<head>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="{{asset('admin/css/emoji.css')}}" rel="stylesheet">
</head>
<style>
  .checkB{
    display:none;
  }
  </style>
            
<body>

<div class="container-fluid p-0 overflow-hidden">
  <div id="back-panel">
    <div class="row marginZero">
    @include('admin.layout.sidebar')
      <!-- Left side start here -->
      
      <!-- Left side end here -->

      <!-- Right Section start -->
      <main role="main" class="contentPart">
        <div class="">
          <div class="backbtn">
            <a href="#" id="sidebar-control" onclick="$('#sidebarMenu').toggle()" ><img src="{{asset('admin/images/leftarrow.svg')}}"></a>
            <h1 class="h2"> Push Notifications</h1>
          </div>
         
          @if($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
          @endif
         
          <div class="row">
            <!-- Push Notification start here -->
            <div class="col-lg-7 col-md-12">
              <form action="{{route('adminPushNoti')}}" enctype="multipart/form-data" method="POST">
                @csrf  
                <input type="hidden" name="type1[]" class="checkhidden" value="">
                <div class="push-form">
                        <div class="form-row notify">
                        <div class="form-group col-md-4 col-sm-4 form-check">
                        <label class="checkbox-container">Send To All
                           <input type="checkbox" name=""  class="allchecks sendall checkB" value="Professional,Recruiter,Organization" >
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 form-check">
                        <label class="checkbox-container">Professionals
                            <input type="checkbox" name="" type="" class="allchecks prof checkB" value="Professional" >
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 form-check text-right">
                        <span class="datepicker-toggle">
                            <span class="datepicker-toggle-button"></span>
                            <input type="date" name="date" value="" class="datepicker-input form-control dateField" required>
                        </span>
                        </div>
                    </div>
                      <div class="form-row">
                        <div class="form-group col-md-4 col-sm-4 form-check">
                        <label class="checkbox-container">Organization
                            <input type="checkbox" name="" class="allchecks org checkB" value="Organization" >
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 form-check">
                        <label class="checkbox-container">Recruiter
                            <input type="checkbox" name="" class="allchecks rec checkB" value="Recruiter">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 form-check">

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 mt-2">
                        <input type="text" class="form-control title_cls" id=""  name="title" value="" placeholder="Title" required>
                        </div>
                        <div class="form-group col-md-12 mt-2">
                        <input type="text" class="form-control" id="toall" name="toall[]" value="" placeholder="To: All" required readonly>
                        </div>

                        <div class="form-group col-md-12 mt-2">
                        <div class="pushform-area">
                            <div class="pushform-content">
                            <h6><strong class="promotitle"></strong></h6>
                            <p class="promodescription"></p>
                            <div class="content-img" id="uploadfile">
                              <a href="#" class="cross-btn d-none crossbtn">
                                  <img src="{{asset('admin/images/cross.png')}}" style="padding-left:13px;padding-bottom:2rem" alt="">
                               </a>
                            </div>
                            </div>
                            <div class="area-flex">
                            <div>


                            <p class="lead emoji-picker-container">
              <input type="email" class="form-control" placeholder="Input field" data-emojiable="converted" data-id="f9454666-fb55-462a-a42d-8f9c7b15ff87" data-type="original-input" style="display: none;"><div class="emoji-wysiwyg-editor form-control" data-id="f9454666-fb55-462a-a42d-8f9c7b15ff87" data-type="input" placeholder="Input field" contenteditable="true" style="height: 21px;"></div><div class="emoji-menu" data-id="f9454666-fb55-462a-a42d-8f9c7b15ff87" data-type="menu" style="z-index: 5004; display: none;"><div class="emoji-items-wrap1"><table class="emoji-menu-tabs"><tbody><tr><td><a class="emoji-menu-tab icon-recent-selected"></a></td><td><a class="emoji-menu-tab icon-smile"></a></td><td><a class="emoji-menu-tab icon-flower"></a></td><td><a class="emoji-menu-tab icon-bell"></a></td><td><a class="emoji-menu-tab icon-car"></a></td><td><a class="emoji-menu-tab icon-grid"></a></td></tr></tbody></table><div class="emoji-items-wrap mobile_scrollable_wrap"><div class="emoji-items"><a href="javascript:void(0)" title=":bust_in_silhouette:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -550px -150px no-repeat;background-size:675px 175px;" alt=":bust_in_silhouette:"><span class="label">:bust_in_silhouette:</span></a><a href="javascript:void(0)" title=":joy:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -550px 0px no-repeat;background-size:675px 175px;" alt=":joy:"><span class="label">:joy:</span></a><a href="javascript:void(0)" title=":kissing_heart:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -175px 0px no-repeat;background-size:675px 175px;" alt=":kissing_heart:"><span class="label">:kissing_heart:</span></a><a href="javascript:void(0)" title=":couplekiss:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -550px -100px no-repeat;background-size:675px 175px;" alt=":couplekiss:"><span class="label">:couplekiss:</span></a><a href="javascript:void(0)" title=":dancers:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -600px -100px no-repeat;background-size:675px 175px;" alt=":dancers:"><span class="label">:dancers:</span></a><a href="javascript:void(0)" title=":heart:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -250px -150px no-repeat;background-size:675px 175px;" alt=":heart:"><span class="label">:heart:</span></a><a href="javascript:void(0)" title=":heart_eyes:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -150px 0px no-repeat;background-size:675px 175px;" alt=":heart_eyes:"><span class="label">:heart_eyes:</span></a><a href="javascript:void(0)" title=":blush:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -75px 0px no-repeat;background-size:675px 175px;" alt=":blush:"><span class="label">:blush:</span></a><a href="javascript:void(0)" title=":grin:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -375px 0px no-repeat;background-size:675px 175px;" alt=":grin:"><span class="label">:grin:</span></a><a href="javascript:void(0)" title=":+1:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -600px -75px no-repeat;background-size:675px 175px;" alt=":+1:"><span class="label">:+1:</span></a><a href="javascript:void(0)" title=":relaxed:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -100px 0px no-repeat;background-size:675px 175px;" alt=":relaxed:"><span class="label">:relaxed:</span></a><a href="javascript:void(0)" title=":pensive:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -400px 0px no-repeat;background-size:675px 175px;" alt=":pensive:"><span class="label">:pensive:</span></a><a href="javascript:void(0)" title=":smile:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') 0px 0px no-repeat;background-size:675px 175px;" alt=":smile:"><span class="label">:smile:</span></a><a href="javascript:void(0)" title=":sob:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -575px 0px no-repeat;background-size:675px 175px;" alt=":sob:"><span class="label">:sob:</span></a><a href="javascript:void(0)" title=":kiss:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -475px -150px no-repeat;background-size:675px 175px;" alt=":kiss:"><span class="label">:kiss:</span></a><a href="javascript:void(0)" title=":unamused:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -450px 0px no-repeat;background-size:675px 175px;" alt=":unamused:"><span class="label">:unamused:</span></a><a href="javascript:void(0)" title=":flushed:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -350px 0px no-repeat;background-size:675px 175px;" alt=":flushed:"><span class="label">:flushed:</span></a><a href="javascript:void(0)" title=":stuck_out_tongue_winking_eye:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -275px 0px no-repeat;background-size:675px 175px;" alt=":stuck_out_tongue_winking_eye:"><span class="label">:stuck_out_tongue_winking_eye:</span></a><a href="javascript:void(0)" title=":see_no_evil:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -75px -75px no-repeat;background-size:675px 175px;" alt=":see_no_evil:"><span class="label">:see_no_evil:</span></a><a href="javascript:void(0)" title=":wink:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -125px 0px no-repeat;background-size:675px 175px;" alt=":wink:"><span class="label">:wink:</span></a><a href="javascript:void(0)" title=":smiley:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -25px 0px no-repeat;background-size:675px 175px;" alt=":smiley:"><span class="label">:smiley:</span></a><a href="javascript:void(0)" title=":cry:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -525px 0px no-repeat;background-size:675px 175px;" alt=":cry:"><span class="label">:cry:</span></a><a href="javascript:void(0)" title=":stuck_out_tongue_closed_eyes:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -300px 0px no-repeat;background-size:675px 175px;" alt=":stuck_out_tongue_closed_eyes:"><span class="label">:stuck_out_tongue_closed_eyes:</span></a><a href="javascript:void(0)" title=":scream:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -125px -25px no-repeat;background-size:675px 175px;" alt=":scream:"><span class="label">:scream:</span></a><a href="javascript:void(0)" title=":rage:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -175px -25px no-repeat;background-size:675px 175px;" alt=":rage:"><span class="label">:rage:</span></a><a href="javascript:void(0)" title=":smirk:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -50px -50px no-repeat;background-size:675px 175px;" alt=":smirk:"><span class="label">:smirk:</span></a><a href="javascript:void(0)" title=":disappointed:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -475px 0px no-repeat;background-size:675px 175px;" alt=":disappointed:"><span class="label">:disappointed:</span></a><a href="javascript:void(0)" title=":sweat_smile:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') 0px -25px no-repeat;background-size:675px 175px;" alt=":sweat_smile:"><span class="label">:sweat_smile:</span></a><a href="javascript:void(0)" title=":kissing_closed_eyes:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -200px 0px no-repeat;background-size:675px 175px;" alt=":kissing_closed_eyes:"><span class="label">:kissing_closed_eyes:</span></a><a href="javascript:void(0)" title=":speak_no_evil:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -125px -75px no-repeat;background-size:675px 175px;" alt=":speak_no_evil:"><span class="label">:speak_no_evil:</span></a><a href="javascript:void(0)" title=":relieved:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -425px 0px no-repeat;background-size:675px 175px;" alt=":relieved:"><span class="label">:relieved:</span></a><a href="javascript:void(0)" title=":grinning:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -50px 0px no-repeat;background-size:675px 175px;" alt=":grinning:"><span class="label">:grinning:</span></a><a href="javascript:void(0)" title=":yum:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -275px -25px no-repeat;background-size:675px 175px;" alt=":yum:"><span class="label">:yum:</span></a><a href="javascript:void(0)" title=":ok_hand:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -650px -75px no-repeat;background-size:675px 175px;" alt=":ok_hand:"><span class="label">:ok_hand:</span></a><a href="javascript:void(0)" title=":neutral_face:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -600px -25px no-repeat;background-size:675px 175px;" alt=":neutral_face:"><span class="label">:neutral_face:</span></a><a href="javascript:void(0)" title=":confused:"><img src="../lib/img//blank.gif" class="img" style="display:inline-block;width:25px;height:25px;background:url('../lib/img//emoji_spritesheet_0.png') -625px -25px no-repeat;background-size:675px 175px;" alt=":confused:"><span class="label">:confused:</span></a></div></div></div></div><i class="emoji-picker-icon emoji-picker fa fa-smile-o" data-id="f9454666-fb55-462a-a42d-8f9c7b15ff87" data-type="picker"></i>
            </p>


                            <!-- <p class="lead emoji-picker-container">
              <input type="text" class="form-control" placeholder="Input with max length of 10" data-emojiable="true" maxlength="10">
            </p> -->
                            <!-- <p class="lead emoji-picker-container">

                            <img src="{{asset('admin/images/smiley.svg')}}" alt="">
                               
                              <input type="hidden" class="form-control" placeholder="Input with max length of 10" data-emojiable="true" maxlength="10">
                           </p> -->





                                 <!-- <button>
                                <img src="{{asset('admin/images/smiley.svg')}}" alt="">
                                <input type="hidden" name="emoji" value="">
                                </button> -->
                            </div>
                            <div>
                              <div class="form-group">
                                    <label for="exampleFormControlFile1"><img src="{{asset('admin/images/attachment.svg')}}" alt="">
                                    <input type="file" name="file" alt="file" value="" class="form-control-file upfile" id="exampleFormControlFile1"
                                        placeholder="Upload File" multiple="true">
                                    </label>
                                   </div>
                             </div>
                            <div>
                                <div class="form-group">
                                    <label for="exampleFormControlFile1"><img src="{{asset('admin/images/img-icon.svg')}}" alt="">
                                    <input type="file" name="image" value="" class="form-control-file imageup" id="exampleFormControlFile1"
                                        placeholder="Upload File" multiple="true">
                                    </label>
                                </div>
                            </div>
                            <div>
                                <textarea class="form-control descrip_cls" name="description" id="exampleFormControlTextarea1" cols="35"rows="1" placeholder="Write your message here" required></textarea>
                            </div>
                            <div class="char-count">
                                <p><span  class="wordcount"></span>/800</p>
                            </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="btn-right-blue mt-2">
                        <button type="submit" class="push-btn-custom push-btn-blue submitbtn"> Push Now </button>
                    </div>
                </div>
             </form>
            </div>
            <div class="col-lg-5 col-md-12">
              <div class="push-history">
                <h6>History</h6>
                <ul>
                @if(isset($hitory_date))
                      @foreach($hitory_date as $value) 
                       
                   <li>
                     <strong>{{date('d/m/Y',strtotime($value->date))}}</strong> 
                     <span class="history-text">Notification was sent</span>
                   </li>
                     
                      @endforeach
                    @endif
                </ul>
              </div>

            </div>
            <!-- Push Notification ends here -->
          </div>
        </div>
    </div>
  </div>
  </main>
  <!-- Right Section end -->

</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<!-- for emoji script-->
   <script src="{{asset('admin/js/config.min.js')}}"></script>
   <script src="{{asset('admin/js/emoji-picker.min.js')}}"></script>
   <script src="{{asset('admin/js/jquery.emojiarea.min.js')}}"></script>
   <script src="{{asset('admin/js/util.min.js')}}"></script>
<!-- end emoji script-->
</body>
    </div>
  </main>
<script>
  $('.sendall').click(function(){
    $check =  $(this).is(":checked")

    if($check == true){
      $('.prof,.prof,.rec,.org').prop('disabled', true);
      $('.prof,.prof,.rec,.org').prop('checked', true);
     }else{
      $('.prof,.prof,.rec,.org').prop('disabled', false);
      $('.prof,.rec,.org').prop('checked', false);
    }
      
  });

  $(document).on('click','.prof,.rec,.org',function(){
    $check =  $(this).is(":checked");

    if($check == true){
        $('.sendall').prop('disabled', true);
      }else {

        $profChecked = $(".prof").is(':checked');
        $recChecked  = $('.rec').is(':checked');
        $orfChecked  = $('.org').is(':checked');

        if($profChecked == false && $recChecked == false && $orfChecked == false){
            $('.sendall').prop('disabled', false);
        }
      }
  
  }); 

   var count = '';
   var checkvalue = [] ;
   $('.sendall,.prof,.rec,.org').click(function(){

        $check =  $(this).is(":checked")
        var val1 = $(this).attr('value');
        if($check == true){
           checkvalue.push(val1);
        }else{
          checkvalue.pop(val1);
         }

         $('.checkhidden').attr('value',checkvalue);
         $('#toall').attr('value',checkvalue);
      });  

  $('.title_cls,.descrip_cls').keyup(function(){

    var descrip_val = $('.descrip_cls').val();
    var count = descrip_val.length;
    $('.promodescription').html(descrip_val);
    var title_val =  $('.title_cls').val();
    $('.promotitle').html(title_val);
    $('.wordcount').html(count);
  });

  $('.crossbtn').click(function(){
    $('#uploadfile').children('img').remove();
    $('.crossbtn').addClass('d-none');
   });

 $(document).on('change', '.upfile',function() {
  $('.crossbtn').removeClass('d-none');
    imagesPreview(this, 'div#uploadfile');
  });
  
  $(document).on('change', '.imageup',function() {
    imagesPreview(this, 'div#uploadimage');
  });

  var imagesPreview = function(input, placeToInsertImagePreview) {
      if (input.files) {
          var filesAmount = input.files.length;

          for (i = 0; i < filesAmount; i++) {
              var reader = new FileReader();

              reader.onload = function(event) {
                  $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                      placeToInsertImagePreview);
              }

              reader.readAsDataURL(input.files[i]);
          }
      }
};

   $(function() {
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: '/admin/images/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();
      });

</script>


 
 @include('admin.layout.footer')