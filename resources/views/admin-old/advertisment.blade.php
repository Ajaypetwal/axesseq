@include('admin.layout.header')

<div class="container-fluid p-0 overflow-hidden"> 
    <div id="back-panel"> 
      <div class="row marginZero"> 
        <div id="back-panel"> 
      <div class="row marginZero"> 
      @include('admin.layout.sidebar')
    
<body>
<div class="container-fluid p-0 overflow-hidden">
    <div id="back-panel">
      <div class="row marginZero ">

        <main role="main" class="contentPart htmladver-div">
          <div class="backbtn">
            <a href="#" onClick="$('#sidebarMenu').toggle()" id="sidebar-control"><img src="{{asset('admin/images/leftarrow.svg')}}"></a>
            <h1 class="h2">Advertisement</h1>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="tabs-outer">
                <ul class="nav">
                  <li class="nav-item">
                    <a class="nav-link active approval" data-toggle="tab" href="#forapproval">For Approval</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link approved" data-toggle="tab" href="#forapproved">Approved</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link denied" data-toggle="tab" href="#fordenied">Denied</a>
                  </li>
                </ul>
            </div>
            </div>
            <div class="col-md-4">
              <div class="btn-right-blue text-right">
                <a href="{{route('createAdvertisement')}}"  class="ads-btn-custom ads-btn-blue createAdver">Create New</a>
              </div>
            </div>
          </div>
          <div class="row approveMess mt-4 mb-0">
          </div>
          <div id="Advertisement">
            <div class="row">
              <div class="col-md-12">
                <div class="tab-content">
                  <div id="forapproval" class="tab-pane active approval-div">
                    <div class="row">
                      <div class="col-md-12">
                        <h4 class="ads-card-heading">Recent</h4>
                      </div>
                    </div>
                    <!-- Card start here -->
                    @if(!empty($promoData) && count($promoData))
                    @foreach($promoData as $value)
                    <div class="card ad-custom-card mb-3 mt-4 ads-border-botm ads-border-top">
                      <div class="row">
                        <div class="col-md-3 col-sm-3 card-img">
                          <img src="images/{{$value->image}}" alt="badges">
                        </div>
                        <div class="col-md-9">
                          <div class="card-body cus-card-body">
                            <div class="title-icon">
                              <div>
                                <h5 class="ads-title">{{$value->promotion_title}}</h5>
                                <p class="ads-date">{{date('d. m. Y',strtotime($value->start_date))}}</p>
                              </div>
                              <div class="ads-dot-btn">
                                <div class="dropdown drop">
                                  <button class="dropdown-toggle dots-btn dropButton" type="button" id="dropdownMenu2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{asset('admin/images/threedots.svg')}}" alt="threedots">
                                  </button>

                                  <div class="dropdown-menu dropMenu" aria-labelledby="dropdownMenu2">
                  
                                 <button class="dropdown-item" data-id="{{$value->_id}}" value="1" type="button" >Approve</button>
                                 <button class="dropdown-item"  data-id="{{$value->_id}}" value="2" type="button">Deny</button></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <p class="ads-text">{{$value->description}}</p>
                            <ul class="money">
                              <li><strong>$</strong></li>
                              <li>{{$value->amount}}</li>
                            </ul>
                            <div class="datetime">
                              <ul>
                                <li><img src="{{asset('admin/images/adcalendar.svg')}}" alt=""> <span>{{date('d. m. Y',strtotime($value->start_date))}}</span></li>
                                <li><img src="{{asset('admin/images/clock.svg')}}" alt=""> <span>{{date("h:i a",strtotime($value->Start_date))}}</span></li>
                                <li><span class="hyphen">-</span></li>
                                <li><img src="{{asset('admin/images/adcalendar.svg')}}" alt=""> <span>{{date('d. m. Y',strtotime($value->end_date))}}</span></li>
                                <li><img src="{{asset('admin/images/clock.svg')}}" alt=""> <span>{{date("h:i a",strtotime($value->end_date))}}</span></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @endif
                    <!-- Card end here -->
                   
                  
                  </div>
                  <!-- For Approval ends here -->
                  <!-- For Apprved start here -->
                  
                  <div id="forapproved" class="tab-pane fade approved-div">
                    <div class="row">
                      <div class="col-md-12">
                        <h4 class="ads-card-heading">Recent</h4>
                      </div>
                    </div>
                    <!-- Card start here -->
                   
                    @if(!empty($promoApproved) && count($promoApproved))
                    @foreach($promoApproved as $value)
                    <div class="card ad-custom-card mb-3 mt-4 ads-border-botm ads-border-top">
                      <div class="row">
                        <div class="col-md-3 card-img">
                          <img src="images/{{$value->image}}" alt="nevermiss">
                        </div>
                        <div class="col-md-9">
                          <div class="card-body cus-card-body">
                            <div class="title-icon">
                              <div>
                                <h5 class="ads-title">{{$value->promotion_title}}</h5>
                                <p class="ads-date">{{date('d. m. Y',strtotime($value->start_date))}}</p>
                              </div>
                              <div class="ads-dot-btn">
                                <div class="dropdown">
                                  <button class="dropdown-toggle dots-btn" type="button" id="dropdownMenu2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{asset('admin/images/threedots.svg')}}" alt="threedots">
                                  </button>
                                  <div class="dropdown-menu dropMenu" aria-labelledby="dropdownMenu2">
                                  <button class="dropdown-item" data-id="{{$value->_id}}" value="1" type="button">Approve</button></a>
                                  <button class="dropdown-item" data-id="{{$value->_id}}" value="2" type="button">Deny</button></a>
                                  </div>
                                </div>
                              </div>
                            </div>


                            <p class="ads-text">{{$value->description}}</p>
                              <ul class="money">
                                <li><strong>$</strong></li>
                                <li>{{$value->amount}}</li>
                              </ul>
                            <div class="datetime">
                              <ul>
                                <li><img src="{{asset('admin/images/adcalendar.svg')}}" alt=""> <span>{{date('d. m. Y',strtotime($value->start_date))}}</span></li>
                                <li><img src="{{asset('admin/images/clock.svg')}}" alt=""> <span>{{date("h:i a",strtotime($value->Start_date))}}</span></li>
                                <li><span class="hyphen">-</span></li>
                                <li><img src="{{asset('admin/images/adcalendar.svg')}}" alt=""> <span>{{date('d. m. Y',strtotime($value->end_date))}}</span></li>
                                <li><img src="{{asset('admin/images/clock.svg')}}" alt=""> <span>{{date("h:i a",strtotime($value->end_date))}}</span></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @endif
                   </div>
                  <!-- For Apprved ends here -->
                  <!-- For Denied start here -->
                 
                  <div id="fordenied" class="tab-pane fade denied-div">
                  <div class="row">
                      <div class="col-md-12">
                        <h4 class="ads-card-heading">Recent</h4>
                      </div>
                    </div>
                    <!-- Card start here -->
                    @if(!empty($promoDenied) && count($promoDenied))
                    @foreach($promoDenied as $value)
                    <div class="card ad-custom-card mb-3 mt-4 ads-border-botm ads-border-top">
                      <div class="row">
                        <div class="col-md-3 col-sm-3 card-img">
                          <img src="images/{{$value->image}}" alt="hiring">
                        </div>
                        <div class="col-md-9">
                          <div class="card-body cus-card-body">
                            <div class="title-icon">
                              <div>
                                <h5 class="ads-title">{{$value->promotion_title}}</h5>
                                <p class="ads-date">{{date('d. m. Y',strtotime($value->start_date))}}</p>
                              </div>
                              <div class="ads-dot-btn">
                                <div class="dropdown">
                                  <button class="dropdown-toggle dots-btn" type="button" id="dropdownMenu2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{asset('admin/images/threedots.svg')}}" alt="threedots">
                                  </button>
                                  <div class="dropdown-menu dropMenu" aria-labelledby="dropdownMenu2">
                                 <button class="dropdown-item" data-id="{{$value->_id}}" value="1" type="button">Approve</button></a>
                                 <button class="dropdown-item" data-id="{{$value->_id}}" value="2" type="button">Deny</button></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                              <p class="ads-text">{{$value->description}}</p>
                              <ul class="money">
                                <li><strong>$</strong></li>
                                <li>{{$value->amount}}</li>
                              </ul>
                            <div class="datetime">
                              <ul>
                                <li><img src="{{asset('admin/images/adcalendar.svg')}}" alt=""> <span>{{date('d. m. Y',strtotime($value->start_date))}}</span></li>
                                <li><img src="{{asset('admin/images/clock.svg')}}" alt=""> <span>{{date("h:i a",strtotime($value->Start_date))}}</span></li>
                                <li><span class="hyphen">-</span></li>
                                <li><img src="{{asset('admin/images/adcalendar.svg')}}" alt=""> <span>{{date('d. m. Y',strtotime($value->end_date))}}</span></li>
                                <li><img src="{{asset('admin/images/clock.svg')}}" alt=""> <span>{{date("h:i a",strtotime($value->end_date))}}</span></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @endif
                    <!-- Card end here -->
                   
                  </div>
                  <!-- For Denied start here -->
                </div>
              </div>
            </div>
          </div>
          <!-- ends here -->
      </div>
    </div>
    </main>
    <!-- Right Section end -->
 </div>
  </div>
  </div>

</body>
</div>
</div>
</div>
</div>
</div>
<script>

 $('.dots-btn').click(function(){
        $('.dots-btn').attr('aria-expanded','true');
        $(this).next('.dropdown-menu').toggle();
     });
   
     $('.dropdown-item').click(function(){
     var id = $(this).attr('data-id');
     var val = $(this).attr('value');
     $.ajax({ 
      type: 'GET',  
      url: '/postApproval', 
      data: { id: id,value: val},
      dataType: "json",
      success: function(response) {
         if(response.status == true){
          $('.approveMess').html(response.message);
          $('.approveMess').addClass('alert alert-success');
         }
         else{
          $('.approveMess').html(response.message);
          $('.approveMess').addClass('alert alert-danger');
         }
      }
    }); 

    });
    $('.dropMenu').click(function(){
      $('.dropMenu').hide();
    }); 
   $(document).on("click",".approval,.approved,.denied",function() {
      $('.approveMess').hide();
     });
     $('.dropMenu').click(function(){
      $('.approveMess').show();
 });
    
$('.approval').click(function(){
      $('.approval-div,.approval').addClass('active');
      $('.approved,.denied').removeClass('active');
      $('.approved-div,.denied-div').removeClass('active show');
 });
     $('.approved').click(function(){
        $('.approval-div,.approval,.denied').removeClass('active');
        $('.approved-div').addClass('active show');
        $('.approved').addClass('active');
        $('.denied-div').removeClass('active show');
       
     });
     $('.denied').click(function(){
        $('.approval-div,.approval,.approved').removeClass('active');
        $('.approved-div').removeClass('active show');
        $('.denied-div').addClass('active show');
        $('.denied').addClass('active');
     });
</script>
@include('admin.layout.footer')
 
