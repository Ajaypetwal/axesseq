@include('admin.layout.header')
<!-- <div class="container-fluid p-0 overflow-hidden">
    <div id="back-panel">
      <div class="row marginZero">
        <div id="back-panel">
      <div class="row marginZero">
      @include('admin.layout.sidebar')
       <div class="row">
              <div class="col-lg-12 col-md-12">          -->
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
            <a href="#" onClick="$('#sidebarMenu').toggle()" id="sidebar-control"><img src="{{asset('admin/images/leftarrow.svg')}}"></a>
            <h1 class="h2"> Guidelines</h1>
          </div>
          <div class="profileinfo">
            <div class="row">
              <!-- Guideline left section start -->
              <div class="col-lg-8 col-md-12">
                <div class="row">
                   <div class="col-lg-10 col-md-10">
                   <div class="guide-dropdown">
                  <form class="form-inline">
                    <div class="form-group">
                      <select class="form-control" id="size_select">
                        <option value="TermsCondition" >Terms & Condition</option>
                        <option value="FAQ" >FAQ</option>
                        <option value="PrivacyPolicy" >Privacy Policy</option>
                        <option value="Profanity" >Profanity</option>
                      </select>
                    </div>
                
                  </form>
               </div>   
                 </div>
                   <div class="col-lg-2 col-md-2 edit-icon">    
                    <a href="{{route('editTermCon')}}" class="iconHref">
                          <button class="edit-btn border-none">
                            <img src="{{asset('admin/images/cardedit.svg')}}" class="p-1" alt="edit">
                          </button>
                    </a> 
                </div>
               </div>
                
               <div class="profanity_div d-none prodiv">

               </div>
               <div id="profanity_area" class="pre_are d-none">
                  
                </div>
                <div  class="second_proarea">
                  
                  </div>


                <div class="content-area mt-4 multiSection">
                  <!-- Terms & Condition starts here -->
                 @if(isset($guideTerm))  
                     <div id="TermsCondition" class="size_chart termDesc">
                       <p>{{$guideTerm->description}} </p>   
                     </div>
                  @endif
                  <div class="term-condition">
                      
                  </div>
                  <!-- Terms & Condition ends here -->

                  <!-- FAQ starts here -->
                  <div id="FAQ" class="size_chart d-none faq-div">
                    <div class="panel-group faq-panel" id="accordion" role="tablist" aria-multiselectable="true">
                    
                    </div>
                  </div>


                  <!-- FAQ ends here -->
                  <!-- Privacy Policy starts here -->
                  <div id="PrivacyPolicy" class="size_chart d-none privacyPol">
                 
                  </div>
                  <!-- Privacy Policy ends here -->
                   <!-- Profanity starts here -->
                  <!-- <div> -->
                       <!-- Profanity ends here -->

                  <!-- </div> -->
                

                </div>
     <div class="btn-guide-blue mt-4">
                  <a href="#" class="guideline-btn guide-btn-blue">Save</a>
                </div>
              </div>
              <!-- Guideline left section end -->

              <!-- Guideline right section start -->
              <div class="col-lg-4 col-md-12">
                <div class="logs-side">
                </div>
                <div class="logs logs-div">
                    
                @if(isset($guideTerm))
                  <h3>{{date('M d, Y',strtotime($guideTerm->created_at))}}</h3>
                  <h5>Update Logs</h5>
                  <ul class="logs-date">
                    <li>{{date('m/d/Y',strtotime($guideTerm->updated_at))}}</li>
                    <li>Term & Conditions - Updated!</li>
                @endif
                @if(isset($guide_Faq))
                    <li>{{date('m/d/Y',strtotime($guide_Faq->updated_at))}}</li>
                    <li>FAQ</li>
                @endif
                @if(isset($guidePrivay_policy))
                    <li>{{date('m/d/Y',strtotime($guidePrivay_policy->updated_at))}}</li>
                    <li>Privacy Policy</li>
                    @endif
                    @if(isset($guideProfanity))
                    <li>{{date('m/d/Y',strtotime($guideProfanity->updated_at))}}</li>
                    <li>Profanity</li>
                  </ul>
                  @endif
                  
                </div>
              </div>

              <!-- Guideline right section end -->
                   </div>
                  </div>
                </div>
              </div>
            </div>
            </main>
          </div>
          </div>
        </div>
      </body>
      </div>
      </main>
    </div>
        </div>
        </div>
  <!-- </div> 
</div> -->
<script>
$(document).on('click','.cancelbtn',function(){
   var id =  $(this).attr('data-val');  
     $(this).parent(this).remove();
    $.ajax({ 
      type: 'GET',  
      url: '/delete-profanity', 
      data: { value: id},
      dataType: "json",
      success: function(response) {
        if(response.status === true){
          $("#mydiv").load(location.href + " #mydiv");
        }
      }
      });

  });


$(document).on('click','.addmore',function(){
  var input = $('.inputfield').val();
  if(input == ""){
    return false;
  }

      $.ajax({ 
      type: 'GET',  
      url: '/cap-profanity', 
      data: { value: input},
      dataType: "json",
      success: function(response) {
        console.log(response.status);
        if(response.status == "true")
             $('.pre_are').append(response.result);
              
         }
      });
   });


 $('#size_select').change(function(){
    var selectValue  = $('#size_select').val(); 
    
    if(selectValue == 'TermsCondition'){
      $('.iconHref').attr('href','/edit-term-condition')
        selOp = selectValue;
    }else if(selectValue == 'FAQ'){
        selOp = selectValue;
    }else if(selectValue == 'PrivacyPolicy'){
      $('.iconHref').attr('href','/privacyPolicy')
        selOp = selectValue;
    }else if(selectValue == 'Profanity'){
        selOp = selectValue;
    }

    let selected = selectValue;
    $.ajax({ 
      type: 'GET',  
      url: '/guide-line', 
      data: { term: selOp},
      dataType: "json",
      success: function(response) {

         if(response.status == "TermsCondition"){
         $('.term-condition').html(response.result);
         $('.logs-side').html(response.sidedes);
         $('.logs-div,.logs-div,.termDesc,.faq-div,.privacyPol,.prodiv,.pro_area,.pre_are').addClass('d-none');
         $('.term-condition,.edit-icon,.multiSection').removeClass('d-none');
       }else if(response.status == "faq"){
            $('.faq-panel').html(response.result);
            $('.faq-div').removeClass('d-none');
            $('.termDesc').addClass('d-none');
            $('.term-condition').addClass('d-none');
            $('.edit-icon').addClass('d-none');
            $('.privacyPol').addClass('d-none');
            $('.faq-panel').removeClass('d-none');
            $('.prodiv').addClass('d-none');
          $('.pro_area').addClass('d-none');
          $('.pre_are').addClass('d-none');
          $('.multiSection').removeClass('d-none');
         }else if(response.status == "PrivacyPolicy"){
          console.log('dfdf');
            $('.privacyPol').html(response.result);
            $('.privacyPol').removeClass('d-none');
            $('.termDesc').addClass('d-none');
            $('.term-condition').addClass('d-none'); 
            $('.edit-icon').removeClass('d-none');
            $('.faq-div').addClass('d-none');
            $('.faq-panel').addClass('d-none');
            $('.prodiv').addClass('d-none');
          $('.pro_area').addClass('d-none');
          $('.pre_are').addClass('d-none');
          $('.multiSection').removeClass('d-none');
         }else if(response.status == "Profanity"){
            $('.pro_area').removeClass('d-none');
            $('.prodiv').removeClass('d-none');
            $('.profanity_div').html(response.result);
            $('.pre_are').html(response.areaHtml);
            $('.privacyPol').addClass('d-none');
            $('.term-condition').addClass('d-none');
            $('.termDesc').addClass('d-none');
            $('.faq-div').addClass('d-none');
            $('.faq-panel').addClass('d-none');
            $('.edit-icon').addClass('d-none');
            $('.pre_are').removeClass('d-none');
            $('.multiSection').addClass('d-none');
         } 
      }
    }); 
 });
</script>
 @include('admin.layout.footer')