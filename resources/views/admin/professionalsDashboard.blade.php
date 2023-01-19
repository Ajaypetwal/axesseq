@include('admin.layout.header')

<body>
   <style>
    img.imageSize {
    width: 40px;
    border-radius: 100px;
    height: 40px;
    object-fit: cover;
    margin: 10px;
    border: 1px solid #999;
}
</style>
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
              <a href="#" onclick="$('#sidebarMenu').toggle()" id="sidebar-control"><img src="{{asset('admin/images/leftarrow.svg')}}"></a>
            <h1 class="h2">{{$proData->name}}</h1>
            </div>
            <div class="profileinfo">
              <div class="row">
                <div class="col-md-4">
                  <div class="brooklynimg">
                    <img class= "imageSize" src="{{asset('')}}{{$proData->image}}" alt="">
                  </div>
                </div>
                <div class="col-md-3">
                  <p class="L-update">Latest Updated: {{date('d/M/Y',strtotime($proData->updated_at))}}</p>
                </div>
                <div class="col-md-5">
                  <div class="action-btn">
                    <form action="{{route('approveReject')}}" method="POST"> 
                      @csrf
                      <input type="hidden" name="id" value="{{$proData->_id}}">
                      @if(empty($proData->approval))
                        <button type="submit" name="approve" value="1" class="btn-custom btn-green">Approve</button>
                        <button type="submit" name="approve" value="2" class="btn-custom btn-red">Reject</button>
                      @endif
                      @if(isset($proData->approval))
                      @if($proData->approval == 2)
                         <button type="submit" name="approve" value="1" class="btn-custom btn-green">Approve</button>
                      @endif
                      @if($proData->approval == 1 )   
                       <button type="submit" name="approve" value="2" class="btn-custom btn-red">Reject</button>
                      @endif
                     @endif
                    </form>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <h4 class="basic-heading"><span>Basic Information</span></h4>
                  <div class="basicinfo">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Name:</label>
                          <p><strong>{{$proData->name}}</strong></p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Email:</label>
                          <p><strong>{{$proData->email}}</strong></p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Address:</label>
                          <p><strong>{{$proData->address}}</strong></p>
                       
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="basicinfo">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Phone:</label>
                          <p><strong>{{$proData->phone_number}}</strong></p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">About Me:</label>
                          <p><strong>{{$proData->about_me}}</strong></p>
                        </div>
                      </div>
                      <div class="col-md-4">

                      </div>
                    </div>
                  </div>


                </div>
              </div>
              <!-- Work Experience start-->

              <h4 class="basic-heading"><span>Work Experience</span></h4>
             @if(isset($proData->work_info))
               @foreach($proData->work_info as $value)
              
            <div class="row">
                <div class="col-md-12">
               
                  <div class="basicinfo">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Company <br>Name:</label>
                          <p><strong>{{$value->company_name}}</strong></p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Your Role:</label>
                          <p><strong>{{$value->your_role}}</strong></p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Started And <br>End Date:</label>
                          <p><strong>{{date('M d, Y',strtotime($value->start_date))}} - {{date('M d, Y',strtotime($value->end_date))}} </strong></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="basicinfo">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Experience:</label>
                          <p><strong>@if(isset($value->your_experience)){{$value->your_experience}}@endif</strong></p>
                        </div>
                      </div>
                      <div class="col-md-4">

                      </div>
                      <div class="col-md-4">

                      </div>
                    </div>
                  </div>


                </div>
              </div>
               @endforeach
             @endif
              
              <!-- Work Experience end -->
              <!-- Work Experience second row start-->
           
              <!-- Work Experience second row end -->
            </div>
          </div>
      </div>
    </div>
    </main>
    <!-- Right Section end -->

  </div>
  </div>
  </div>

</body>
@include('admin.layout.footer')