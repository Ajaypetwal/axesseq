@include('admin.layout.header')

<style>
  .checkB{
    display:none;
  }
</style>
<div class="container-fluid p-0 overflow-hidden">
  <div id="back-panel">
    <div class="row marginZero">
    @include('admin.layout.sidebar')
   
      <main role="main" class="contentPart">
        <div class="">
          <div class="backbtn">
            <a href="#" id="sidebar-control" onclick="$('#sidebarMenu').toggle()" ><img src="{{asset('admin/images/leftarrow.svg')}}"></a>
            <h1 class="h2"> Push Notifications</h1>
          </div>emojionearea.min.js
         
          @if($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
          @endif
         
          <div class="row">
            <!-- Push Notification start here -->
            <div class="col-lg-7 col-md-12">
              <form action="{{route('adminPushNoti')}}" enctype="multipart/form-data" method="POST">
              @csrf 
              <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}" /> -->
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
                            <div class="row">
                                <div class="span6">
                                    <textarea id="emojionearea1"></textarea>
                                </div>
                             </div>

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

// Emoji 
$(document).ready(function() {
    $("#emojionearea1").emojioneArea({
        pickerPosition: "left",
        tonesStyle: "bullet"
    });
})
</script>
 @include('admin.layout.footer')