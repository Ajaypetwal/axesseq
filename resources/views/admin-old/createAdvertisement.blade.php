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

      <main role="main" class="contentPart">
        <div class="">
          <div class="backbtn">
            <a href="#" id="sidebar-control"><img src="{{('admin/images/leftarrow.svg')}}"></a>
            <h1 class="h2"> Create Advertisement</h1>
          </div>
          <form  action="{{route('createAdvert')}}" enctype="multipart/form-data" method="POST">
           @csrf
          <div class="profileinfo">
            <div class="row">
              <!-- Create Card start here -->
         
              <div class="col-lg-4 col-md-12">
                <div class="upload-image">
                 
                    <div class="form-group">
                      <label for="exampleFormControlFile1">Upload Phone size image
                        <input type="file" name="file" value="" class="form-control-file" id="exampleFormControlFile1"
                          placeholder="Upload File" required>
                      </label>
                    </div>
                
                </div>
              </div>
              <div class="col-lg-8 col-md-12">
             
                  <div class="row">
                   <div class="col-lg-6 col-md-6 col-sm-12">
                      <input type="text" class="form-control"  value="" name="promotion_title" placeholder="Title" required>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <input type="text" class="form-control" name="amount" value="" placeholder="Amount">
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <label>Start date</label>
                      <input type="date" class="form-control" name="start_date" value="" placeholder="start date">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 date">
                    <label>End date</label>
                      <input type="date" class="form-control" name="end_date" value="" placeholder="end date">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 date">
                      <input type="hidden" class="form-control" name="approval" value="0" placeholder="Approval">
                    </div>
                 <div class="row mt-3">
                    <div class="col">
                      <textarea class="form-control" id="exampleFormControlTextarea1" value="" name="description" rows="6"
                        placeholder="Description"></textarea>
                    </div>
                  </div>
                <div class="pushcard-btn">
                   <button type="submit" class="btn-custom btn-blue">  Create</button>
                  </div>
                </div>
              </form>
              <!-- Create Card end here -->
            </div>
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