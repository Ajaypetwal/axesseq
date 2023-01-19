@include('admin.layout.header')


<!-- 

<div class="container-fluid p-0 overflow-hidden"> 
    <div id="back-panel"> 
      <div class="row marginZero"> 
        <div id="back-panel"> 
      <div class="row marginZero"> 
      @include('admin.layout.sidebar') -->
 
<body>

  <div class="container-fluid p-0 overflow-hidden">
    <div id="back-panel">
      <div class="row marginZero">
      @include('admin.layout.sidebar')
       <!-- Right Section start -->
        <main role="main" class="professionalTabbing contentPart">
          <div class="backbtn">
             <a href="#" id="sidebar-control" onclick="$('#sidebarMenu').toggle()" ><img src="{{asset('admin/images/leftarrow.svg')}}"></a> 
            <h1 class="h2">Dashboard</h1>
          </div>
          <div class="btnsGroupWrap">
              <div class="professional-tabs">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link professMenu" id="profess"  data-toggle="tab" href="#home">@if(isset($professinalAll) && count($professinalAll) > 0){{count($professinalAll)}}  Professionals @endif</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link recuMenu" data-toggle="tab" id="recru" href="#menu1">@if(isset($recruiterAll) && count($recruiterAll) > 0){{count($recruiterAll)}}  Recruiters @endif</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link orgMenu" data-toggle="tab" id="organi" href="#menu2">@if(isset($organizationAll) && count($organizationAll) > 0){{count($organizationAll)}}  Organizations @endif</a>
                </li>
              </ul>
            </div>
              <div class="search stats">
                <form class="form-inline searchblock" action="">
                  <input type="hidden" id="csrfToken" name="_token" value="{{ csrf_token() }}" />
               <input  class="form-control form-control-1 mr-sm-2 searchBox" name="" value=""  type="text"placeholder="Search">
                  <button onClick="reload()"><img src="{{asset('admin/images/Search.svg')}}" alt="" /></button>
                </form>
                <div class="date-clndr">
                
                  <a class="cvs csvUrl" href>
                    <img src="{{asset('admin/images/CVS.svg')}}" alt="CVS">
                    <span class="downcvs">Download CVS</span>
                  </a>
                  <span class="datepicker-toggle" class="calendar">
                    <span class="datepicker-toggle-button"></span>
                    <input type="date" class="datepicker-input form-control">
                  </span>
                </div>
              </div>
          </div>
          <!-- 200 Professionals Table Starts here -->
          <div class="row">
            <div class="col-md-12">
              <div class="tab-content">
                 <div id="home"  class="tab-pane active professionalWrapper">
                  <div class="table-responsive" id="professionals">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Email</th>
                          <th>Phone Number</th>
                          <th>Account Created</th>
                          <th>Subscription Level</th>
                          <th>Active</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody id="bodypart" class="professionalTB">
                        @php 
                        $i=0;
                        @endphp
                        @if(isset($professional) && count($professional) > 0)
                        @foreach($professional as $value)
                            
                      <tr>
                          <td><img class="imageSize" src="{{asset('')}}{{$value->image}}"> <span>{{$value->name}}</span></td>
                          <td>{{$value->email}}</td>
                          <td>+{{$value->country_code}} {{substr($value->phone_number,0,3).' '.substr($value->phone_number,3,3).' '.substr($value->phone_number,6,4)}}</td>
                          <td>{{date('d/m/Y',strtotime($value->updated_at))}}</td>
                          <td>
                          @php 
                            
                             if(isset($type_array_pro[$i])){
                               
                              print_r ($type_array_pro[$i]);
                              $i++;
                             }else{
                                echo "N/A";
                                $i++;
                             }
                        @endphp
                          </td>
                         <td><label class="switch">
                              <input type="checkbox" data-id="{{$value->_id}}" class="active_inactive" @php if($value->status == 'Active'){echo 'checked';} @endphp data-check=@php if($value->status == 'Active'){echo 'checked';} @endphp >
                              <span class="sliderbtn round"></span>
                            </label>
                         </td>
                         <td><a href="{{route('showPro',['id'=>$value->_id])}}">show</a></td>
                        </tr>
                         @endforeach
                        @endif
                     </tbody>
                    </table>
                    
                    @if(isset($professional))
                     <div class="allDisabled" style="display: flex;justify-content: center;">
                       {{$professional->render("pagination::bootstrap-4")}}
                     </div>
                       @endif
                   </div>
                </div>
           <!-- start common div  for professional and recruiter-->
                <div class="tab-content">
                <div  class="tab-pane common">
                  <div class="table-responsive" id="professionals">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Email</th>
                          <th>Phone Number</th>
                          <th>Account Created</th>
                          <th>Subscription Level</th>
                          <th>Active</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody id="bodypart" class="commonTb">
                  
                     </tbody>
                    </table>
                  </div>
                </div>
              </div>
                <!-- end commom div  -->
   <!-- start common div  for professional and recruiter-->
   <div class="tab-content">
                <div  class="tab-pane common1">
                  <div class="table-responsive" id="professionals">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Company Email</th>
                          <th>Company</th>
                          <th>Location</th>
                          <th>Description</th>
                          <th>Subscription Level</th>
                          <th>Active</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody id="bodypart" class="commonTb1">
                  
                     </tbody>
                    </table>
                  </div>
                </div>
              </div>
                <!-- end commom div  -->


<!--  Recruiters Table starts here -->
                <div id="menu1" class="tab-pane fade recruiterWrapper">
                  <div class="table-responsive" id="professionals">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Email</th>
                          <th>Phone Number</th>
                          <th>Account Created</th>
                          <th>Subscription Level</th>
                          <th>Active</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody class="recruiterTB">
                      @php  
                        $i = 0; 
                      @endphp
                      @if(isset($recruiter) && count($recruiter) > 0)
                        @foreach($recruiter as $value)  
                        @php 
                           
                        if($value->userinfo){
                              $image_arr = $value->userinfo->image;
                           }

                        @endphp
                      <tr>
                          <td>
                         <img class="imageSize" src="{{asset('')}}{{$image_arr}}"> 
                          
                          <span>{{$value->name}}</span></td>
                          <td>{{$value->email}}</td>
                          <td>+{{$value->country_code}} {{substr($value->phone_number,0,3).' '.substr($value->phone_number,3,3).' '.substr($value->phone_number,6,4)}}</td>
                          <td>{{date('d/m/Y',strtotime($value->updated_at))}}</td>
                          <td>
                          @php 
                            
                            if(isset($type_array_rec[$i])){
                               print_r ($type_array_rec[$i]);
                               $i++;
                            }else{
                               echo "N/A";
                               $i++;
                            }
                          @endphp
                          </td>
                          <td><label class="switch">
                              <input type="checkbox" data-id="{{$value->_id}}" class="active_inactive" @php if($value->status == 'Active'){echo 'checked';} @endphp data-check=@php if($value->status == 'Active'){echo 'checked';} @endphp >
                              <span class="sliderbtn round"></span>
                            </label>
                         </td>
                         <td><a href="{{route('showRecruOrg',['id'=>$value->_id])}}">show</a></td>
                        </tr>
                         @endforeach
                        @endif
                      

                      </tbody>
                    </table>
                    @if(isset($recruiter))
                     <div style="display: flex;justify-content: center;">
                       {{$recruiter->render("pagination::bootstrap-4")}}
                     </div>
                       @endif
                  </div>
                </div>
                <!-- 350 Organization Table starts here -->
                <div id="menu2" class="tab-pane fade organizationWrapper">
                  <div class="table-responsive" id="professionals">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Company Email</th>
                          <th>Company</th>
                          <th>Location</th>
                          <th>Description</th>
                          <th>Subscription Level</th>
                          <th>Active</th>
                          <th>View</th>
                          
                        </tr>
                      </thead>
                      <tbody class="organizationTB">
                       @php $i= 0; @endphp
                      @if(isset($organization) && count($organization) > 0)
                       @foreach($organization as $value)
                             
                        <tr>
                          <td>@if(isset($value->userinfo->company_email)){{$value->userinfo->company_email}}@endif</td>
                          <td><img class="imageSize" src="{{asset('')}}{{$value->userinfo->profile_pic}}">
                          @if(isset($value->userinfo->company_name)){{$value->userinfo->company_name}}@endif</td>
                          <td>@if(isset($value->userinfo->business_address)){{$value->userinfo->business_address}}@endif</td>
                          <td>@if(isset($value->userinfo->about_company)){{$value->userinfo->about_company}}@endif</td>
                          <td>
                          @php 
                         
                             if(isset($type_array_org[$i])){
                              print_r($type_array_org[$i]);
                              $i++;
                             }else{
                                echo "N/A";
                             }
                        @endphp
                          </td>
                          
                          <td><label class="switch">
                              <input type="checkbox" data-id="{{$value->_id}}" class="active_inactive" @php if($value->status == 'Active'){echo 'checked';} @endphp data-check=@php if($value->status == 'Active'){echo 'checked';} @endphp >
                              <span class="sliderbtn round"></span>
                            </label>
                         </td>
                         <td><a href="{{route('showRecruOrg',['id'=>$value->_id])}}">show</a></td>
                        </tr>
                        @endforeach
                        @endif
                     </tbody>
                    </table>
                    
                    @if(isset($organization))
                     <div style="display: flex;justify-content: center;">
                       {{$organization->render("pagination::bootstrap-4")}}
                     </div>
                       @endif
                
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Table ends here -->
      </div>
    </div>
    </main>
    <!-- Right Section end -->

  </div>
  </div>
  </div>

</body>
<!-- </div>
</div>
</div>
</div>
</div> -->

<script>
$(document).on( 'click','.active_inactive',function (){
   var check = $(this).attr('data-check');
   var id = $(this).attr('data-id');
   if(check == "checked"){
   var data = "inactive";
   
   }else{
   var  data = "Active";
   }
  $.ajax({ 
      type: 'GET', 
      url: 'activeStatus', 
      data:{status : data,id : id},
      dataType: "json",
      success: function(result) {
      
    }
  }); 

});


function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

$(document).on( 'click', '.csvUrl', function(e) {
  e.preventDefault();
  var selectedMenu = localStorage.getItem('selected');
  var searchValue = $('.searchBox').val();

  var role = capitalizeFirstLetter(selectedMenu);
  
  $.ajax({ 
      type: 'GET',  
      url: '/exp-csv/' +role+ '/' +searchValue, 
      success: function(data) {
        console.log(data);
        $('.loadercls').removeClass('d-none');

        /*
          * Make CSV downloadable
          */
        var downloadLink = document.createElement("a");
        var fileData = ['\ufeff'+data];
        console.log('rswsjwheweee',data);
        var blobObject = new Blob(fileData,{
            type: "text/csv;charset=utf-8;"
          });

        var url = URL.createObjectURL(blobObject);
        downloadLink.href = url;
        downloadLink.download = "data.csv";

        /*
          * Actually download CSV
          */
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
  }); 

});  
$('.professMenu').click(function () {
        $('#home').show();
        $('.common').hide();
        $('.common1').hide();
      });
$('.recuMenu').click(function () {
        $('#home,.common,.common1').hide();
        $('#menu1').show();
});
      $('.orgMenu').click(function () {
        $('#home,#menu1,.common,.common1').hide();
       $('#menu2').show();
     
      });
$(document).ready(function () {
  $('.searchBox').keyup(function(){

    var uname = $('.searchBox').val();
    var searchTerm = $(this).val();
    var selectedMenu = localStorage.getItem("selected");
    var role = '';
    if(selectedMenu == "professional"){
      selectedMenu ="{{route('exportFile',['role'=>'Professional','search'=>".uname."])}}";
       $('.csvUrl').attr('href',selectedMenu);
       role = "Professional";
    }else if(selectedMenu == "recruiter"){
      selectedMenu ="{{route('exportFile',['role'=>'Recruiter','search'=>".uname."])}}";
      $('.csvUrl').attr('href',selectedMenu);
      role = "Recruiter";
    }else if(selectedMenu == "organization"){
      selectedMenu ="{{route('exportFile',['role'=>'Organization','search'=>".uname."])}}";
      $('.csvUrl').attr('href',selectedMenu);
      role = "Organization";
    }
    $.ajax({ 
      type: 'GET',  
      url: '/searchbox', 
      data: { name: uname,role :role},
      dataType: "json",
      success: function(response) {
        $('#home,#menu1,#menu2').hide();
        if(response.status === "trueRes"){
          $('.common').show();
         $('.commonTb').html(response.result);
      }else{
       $('.commonTb').html(response.result);
      
     }
     if(response.status === "trueOrg"){
        $('.common1').show();
        $('#menu2').hide();
        $('.commonTb1').html(response.result);
      } else{
        $('.commonTb1').html(response.result);
      }

      }
    }); 
  })
  var selectedMenu = localStorage.getItem("selected");

});
</script>
@include('admin.layout.footer')