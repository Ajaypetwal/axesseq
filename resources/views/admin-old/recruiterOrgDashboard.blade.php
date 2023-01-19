
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
      <div class="row marginZero">
        <!-- Right Section start -->
        <main role="main" class="contentPart">
          <div class="">
            <div class="backbtn">
              <a href="#" id="sidebar-control"><img src="{{asset('admin/images/leftarrow.svg')}}"></a>
              <h1 class="h2">{{$recruOrgData->name}}</h1>
            </div>
            <div class="profileinfo">
              <div class="row">
                <div class="col-lg-4 col-md-4">
                  <div class="brooklynimg">
                    <img src="{{$recruOrgData->image}}" alt="">
                  </div>
                </div>
                <div class="col-lg-3 col-md-2">
                  <p class="L-update">Latest Updated: {{date('d/M/Y',strtotime($recruOrgData->updated_at))}}</p>
                </div>
                <div class="col-lg-5 col-md-6">
                  <div class="action-btn">
                  <form action="{{route('approveReject')}}" method="POST"> 
                      @csrf
                        <input type="hidden" name="id" value="{{$recruOrgData->_id}}">
                        <button type="submit" name="approve" value="1" class="btn-custom btn-green">Approve</button>
                        <button type="submit" name="approve" value="2" class="btn-custom btn-red">Reject</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="heading-border">
                    <h4 class="basic-heading"><span>Basic Information</span></h4>
                  </div>
                  <div class="basicinfo">
                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Name:</label>
                          <p><strong>{{$recruOrgData->name}}</strong></p>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Email:</label>
                          <p><strong>{{$recruOrgData->email}}</strong></p>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Phone:</label>
                          <p><strong>{{$recruOrgData->phone_number}}</strong></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="basicinfo">
                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Company<br> Name:</label>
                          <p><strong>{{$recruOrgData->companyinfo->company_name}}</strong></p>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Company Email:</label>
                          <p><strong>{{$recruOrgData->companyinfo->company_email}}</strong></p>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Company Phone:</label>
                          <p><strong>{{$recruOrgData->companyinfo->company_phone}}</strong></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="basicinfo">
                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Business Address:</label>
                          <p><strong>{{$recruOrgData->companyinfo->business_address}}</strong></p>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Website:</label>
                          <p><strong>{{$recruOrgData->companyinfo->website}}</strong></p>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6">

                      </div>
                    </div>
                  </div>


                </div>
              </div>
              <!-- Company Information start-->
              <div class="row">
                <div class="col-md-12">
                  <h4 class="basic-heading"><span>Company Information</span></h4>
                  <div class="basicinfo">
                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <p class="basicinfo-p">Industry:</p>
                          <p><strong>{{$recruOrgData->companyinfo->industry}}</strong></p>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Size of Company:</label>
                          <p><strong>{{$recruOrgData->companyinfo->size_of_company}}</strong></p>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Headquarters:</label>
                          <p><strong>{{$recruOrgData->companyinfo->headquarters}}</strong></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="basicinfo">
                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                        <div class="basicinfo-inner">
                          <label class="basicinfo-p">Founded:</label>
                          <p><strong>{{$recruOrgData->companyinfo->founded}}</strong></p>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6">

                      </div>
                      <div class="col-lg-4 col-md-6">

                      </div>
                    </div>
                  </div>


                </div>
              </div>
              <!-- Company Information end -->

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
</div>
</div>
</div>
</div>
</div>
@include('admin.layout.footer')