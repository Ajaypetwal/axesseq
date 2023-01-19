
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
        <main role="main" class="contentPart">
          <div class="">
            <div class="backbtn">
              <a href="#" onclick="$('#sidebarMenu').toggle()" id="sidebar-control"><img src="{{asset('admin/images/leftarrow.svg')}}"></a>
            <h1 class="h2">Dashboard</h1>
          </div>
            <div class="row">
              <div class="col-lg-8 col-md-12">
                <!-- Download chart start here -->
                <div class="downloads">
                  <p> section under development</p>
                  <!-- <div class="row d-flex align-items-center">
                    <div class="col-md-4 col-sm-4">
                      <img src="{{asset('admin/images/downloadchart.svg')}}" alt="chart">
                    </div>
                    <div class="col-md-8 col-sm-8">
                      <table class="download-count">
                        <tbody>
                          <tr>
                            <td><img src="{{asset('admin/images/Ellipse 877.svg')}}" alt=""></td>
                            <td>Total Downloads</td>
                            <td class="grey">35,670</td>
                          </tr>
                          <tr>
                            <td><img src="{{asset('admin/images/Ellipse 878.svg')}}" alt=""></td>
                            <td>Online</td>
                            <td class="grey">6,120</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div> -->
                </div>
                <!-- Download chart end here -->

                <!-- Daily Stats start here -->
                <div class="stats statsWrap">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="center-sec">
                        <div class="border-outer">
                          <h6>Daily Stats</h6>
                        </div>
                        <div class="text-right">
                           <a class="" href="#" >
                            <img src="{{asset('admin/images/CVS.svg')}}" alt="CVS">
                            <span class="downcvs">Download CVS</span>
                          </a> 
                           <img src="{{asset('admin/images/Calendar.svg')}}" alt="calendar" class="calendar"> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Daily Stats end here -->

                <div class="row">
                  <div class="col-md-5">
                    <div class="count">
                      <div class="count-inner">
                        <h5>@if(isset($event)){{count($event)}} @endif</h5>
                        <p>Events Posted:</p>
                      </div>
                      <div class="count-inner">
                        <h5>@if(isset($professional)){{count($professional)}} @endif</h5>
                        <p>Professionals:</p>
                      </div>
                      <div class="count-inner">
                        <h5>@if(isset($recruiter)){{count($recruiter)}} @endif</h5>
                        <p>Recruiters</p>
                      </div>
                      <div class="count-inner">
                        <h5> @if(isset($organization)){{count($organization)}} @endif</h5>
                        <p>Organizations</p>
                      </div>
                       <div class="count-inner">
                        <h5>3,567</h5>
                        <p>Online Users On Website</p>
                      </div> 
                    </div>
                  </div>
                  <div class="col-md-7">
                    <p>section under development</p>
                     <div class="dropdowns">
                      <div class="dropdowns-inner">
                        <div class="form-group">
                          <label for="sel1">Geographical Location</label>
                          <select class="form-control select" id="sel1">
                            <option value="NewYork"><strong>NewYork</strong></option>
                            <option value="USA"><strong>USA</strong></option>
                          </select>
                        </div>
                        <div>
                          <h5>290</h5>
                        </div>
                      </div>
                      <div class="dropdowns-inner">
                        <div class="form-group">
                          <label for="sel1">Industry</label>
                          <select class="form-control select" id="sel2">
                            <option value="NewYork"><strong>Information Technology</strong></option>
                            <option value="USA"><strong>Information Technology</strong></option>
                          </select>
                        </div>
                        <div>
                          <h5>120</h5>
                        </div>
                      </div>
                      <div class="dropdowns-inner">
                        <div class="form-group">
                          <label for="sel1">Companies</label>
                          <select class="form-control select" id="sel3">
                            <option value="NewYork"><strong>Information Technology</strong></option>
                            <option value="USA"><strong>Information Technology</strong></option>
                          </select>
                        </div>
                        <div>
                          <h5>340</h5>
                        </div>
                      </div>
                      <div class="dropdowns-inner">
                        <div class="form-group">
                          <label for="sel1">Sexual Orientation</label>
                          <select class="form-control select" id="sel4">
                            <option value="NewYork"><strong>Male</strong></option>
                            <option value="USA"><strong>Female</strong></option>
                          </select>
                        </div>
                        <div>
                          <h5>250</h5>
                        </div>
                      </div>
                      <div class="dropdowns-inner">
                        <div class="form-group">
                          <label for="sel1">Ethnicity/Race</label>
                          <select class="form-control select" id="sel5">
                            <option value="NewYork"><strong>African American</strong></option>
                            <option value="USA"><strong>Indian</strong></option>
                          </select>
                        </div>
                        <div>
                          <h5>670</h5>
                        </div>
                      </div>
                    </div> 
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-12">
                <!-- Tabbing Start-->
                <div class="tabsWrap">
                  <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#home">Jobs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#menu1">Events</a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="scrolling-wrapper">
                  <div class="tab-content">

                    <div id="home" class="tab-pane  active">
                   
                    @if(isset($jobs) && count($jobs) > 0)
                       @foreach($jobs as $value)
                          
                      <div class="jobsBlock">
                        <div class="d-flex logo&title">
                          <div class="iconWrap">
                              <img src="{{$value->company_logo}}" alt="" class="com-logo-cls"/></div>
                          <div class="jobTitle">
                            <h4>{{$value->job_title}}</h4>
                            <p>{{$value->company_name}}</p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <ul class="timingWrap">
                              <li>{{$value->job_type}}</li>
                              <li>Office</li>
                            </ul>
                          </div>
                          <div class="col-6">
                            <ul class="priceWrap">
                              <li>{{$value->salary_range}} / {{$value->salary_period}}</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      @endforeach
                      <!-- <button type="button" class="viewMoreBtn jobs btn btn-default">View More</button> -->
                    @endif
                     </div>
                      <div id="menu1" class="tab-pane fade">

                   @if(isset($event) && count($event) > 0)
                     @foreach($event as $value)    
                      <div class="blockWrapper">
                        <div class="imgWrap">
                          <img src="" alt="" />
                        </div>
                        <div class="sideBlockContent">
                          <div class="titlewrap">
                            <span class="logoWrap">
                              <img src="{{$value->company_logo}}" alt="" class="com-logo-cls"/>
                            </span>
                            <h4>{{$value->event_title}}</h4>
                          </div>
                          <p>{{$value->job_description}}</p>
                          <ul class="badges">
                            <li>{{$value->attendees}} Attendees</li>
                            <li>{{date('d M, Y', strtotime($value->date))}}</li>

                            
                            <li>{{date('H:i',strtotime($value->date))}}</li>
                          </ul>
                          <div class="d-flex imgText">
                          <i class="fa fa-map-marker" style="padding-right: 4px;color: white;"></i>
                         <p class="addressBlock">{{$value->address}}</p>
                          </div>
                        </div>
                      </div>
                   @endforeach
                      <!-- <button type="button" class="viewMoreBtn btn btn-default">View More</button> -->
                   @endif
                      </div>
                </div>
                 </div>
                </div>

                <!-- Tabbing End-->

              </div>
            </div>

          </div>
      </div>
    </div>
   
    <!-- Right Section end -->

  </div>
  </div>
  </div>
</body>
<!-- </div>
  </main>
  </div>
  </div>
  </div>
  </div> 
</div> -->
 @include('admin.layout.footer')
