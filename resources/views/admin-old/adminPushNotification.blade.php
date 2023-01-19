@include('admin.layout.header')
<div class="container-fluid p-0 overflow-hidden">
    <div id="back-panel">
      <div class="row marginZero">
        <div id="back-panel">
      <div class="row marginZero">
      @include('admin.layout.sidebar')
       <div class="row">
              <div class="col-lg-12 col-md-12">         
            
              <body>

<div class="container-fluid p-0 overflow-hidden">
  <div id="back-panel">
    <div class="row marginZero">
      <!-- Left side start here -->
      
      <!-- Left side end here -->

      <!-- Right Section start -->
      <main role="main" class="contentPart">
        <div class="">
          <div class="backbtn">
            <a href="#" id="sidebar-control"><img src="{{asset('admin/images/leftarrow.svg')}}"></a>
            <h1 class="h2"> Push Notifications</h1>
          </div>
          <div class="row">
            <!-- Push Notification start here -->
            <div class="col-lg-7 col-md-12">
              <form action={{route('adminPushNoti')}} enctype="multipart/form-data" method="POST">
                @csrf  
                <div class="push-form">
                        <div class="form-row notify">
                        <div class="form-group col-md-4 col-sm-4 form-check">
                        <label class="checkbox-container">Send To All
                          <input type="checkbox" name="checkbox[]" value="1">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 form-check">
                        <label class="checkbox-container">Professionals
                            <input type="checkbox" name="checkbox[]" value="2">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 form-check text-right">
                        <span class="datepicker-toggle">
                            <span class="datepicker-toggle-button"></span>
                            <input type="date" name="date" value="" class="datepicker-input form-control">
                        </span>
                        </div>
                    </div>
                      <div class="form-row">
                        <div class="form-group col-md-4 col-sm-4 form-check">
                        <label class="checkbox-container">Organization
                            <input type="checkbox" name="checkbox[]" value="3" >
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 form-check">
                        <label class="checkbox-container">Recruiter
                            <input type="checkbox" name="checkbox[]" value="4">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="form-group col-md-4 col-sm-4 form-check">

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 mt-2">
                        <input type="text" class="form-control" id="" name="title" value="" placeholder="Title">
                        </div>
                        <div class="form-group col-md-12 mt-2">
                        <input type="text" class="form-control" id="" name="toall" value="" placeholder="To: All">
                        </div>

                        <div class="form-group col-md-12 mt-2">
                        <div class="pushform-area">
                            <div class="pushform-content">
                            <h6><strong>My Promo Sale 1</strong></h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 7-01-2021</p>
                            <div class="content-img">
                               <img src="{{asset('admin/images/content-img.png')}}" alt="">
                               <button class="cross-btn">
                                  <img src="{{asset('admin/images/cross.png')}}" alt="">
                               </button>
                            </div>
                            </div>
                            <div class="area-flex">
                            <div>
                                <button>
                                <img src="{{asset('admin/images/smiley.svg')}}" alt="">
                                <input type="hidden" name="emoji" value="">
                                </button>
                            </div>
                            <div>
                              <div class="form-group">
                                    <label for="exampleFormControlFile1"><img src="{{asset('admin/images/attachment.svg')}}" alt="">
                                    <input type="file" name="file" value="" class="form-control-file" id="exampleFormControlFile1"
                                        placeholder="Upload File">
                                    </label>
                                   </div>
                             </div>
                            <div>
                                <div class="form-group">
                                    <label for="exampleFormControlFile1"><img src="{{asset('admin/images/img-icon.svg')}}" alt="">
                                    <input type="file" name="image" value="" class="form-control-file" id="exampleFormControlFile1"
                                        placeholder="Upload File">
                                    </label>
                                </div>
                            </div>
                            <div>
                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" cols="35"rows="1" placeholder="Write your message here"></textarea>
                            </div>
                            <div class="char-count">
                                <p>38/800</p>
                            </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="btn-right-blue mt-2">
                        <button type="submit" class="push-btn-custom push-btn-blue"> Push Now </button>
                    </div>
                </div>
             </form>
            </div>
            <div class="col-lg-5 col-md-12">
              <div class="push-history">
                <h6>History</h6>
                <ul>
                  <li><strong>06/19/2021</strong> <span class="history-text">Notification was sent</span></li>
                  <li><strong>06/18/2021</strong> <span class="history-text">Notification was sent</span></li>
                  <li><strong>06/17/2021</strong> <span class="history-text">Notification was sent</span></li>
                  <li><strong>06/16/2021</strong> <span class="history-text">Notification was sent</span></li>
                  <li><strong>06/15/2021</strong> <span class="history-text">Notification was sent</span></li>
                  <li><strong>06/14/2021</strong> <span class="history-text">Notification was sent</span></li>
                  <li><strong>06/13/2021</strong> <span class="history-text">Notification was manually sent</span></li>
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

</body>
    </div>
  </main>
  </div>
  </div>
  </div>
  </div> 
</div>

 @include('admin.layout.footer')