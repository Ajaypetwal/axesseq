@include('admin.layout.header')

<div class="container-fluid p-0 overflow-hidden"> 
    <div id="back-panel"> 
      <div class=""> 
        <div id="back-panel"> 
      <div class="row marginZero"> 
      @include('admin.layout.sidebar')
      <body>

<div class="container-fluid p-0 overflow-hidden">
  <div id="back-panel">
    <div class="row marginZero">

      <main role="main" class="contentPart">
        <div class="">
          <div class="backbtn">
            <a href="#" id="sidebar-control" onClick="$('#sidebarMenu').toggle()"><img src="{{asset('admin/images/leftarrow.svg')}}"></a>
            <h1 class="h2"> Edit Card</h1>
          </div>
          <p id="error1" class="d-none" style="color:#FF0000;">
               
           </p>
          <div class="profileinfo">
            <div class="row">
            
              <div class="col-lg-12 col-md-12">
                <form id="createcard" action="{{route('editCard')}}" method="POST" enctype="multipart/form-data">
                      @csrf
                <div class="row"> 
                <div class="col-lg-4 col-md-12">
                <div class="upload-image">
                <div class="form-group">
                    <label for="exampleFormControlFile1">Upload Phone size image
                        <input type="file" class="form-control-file imagein" name="file" value=""  id="exampleFormControlFile1"
                        placeholder="Upload File" required>
                        @error('file')
                          <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                    </label>
                    </div>
                    </div>
                 </div>
                 <div class="col-lg-8 col-md-12">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <input type="text" class="form-control" name="title" value="{{$data->title}}"  placeholder="Title" required>
                      @error('title')
                          <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 date">
                      <input type="date" class="form-control" name="date" value="{{$data->date}}" placeholder="Date" required>
                      @error('date')
                          <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col">
                      <textarea class="form-control" id="exampleFormControlTextarea1" name="description" value="{{$data->description}}" rows="6"
                        placeholder="Description" required>{{$data->description}}</textarea>
                        @error('description')
                          <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                     </div>  
                  </div>
                  <div class="pushcard-btn">
                    <input type="hidden" name="id" value={{$data->_id}}>
                    <input type="submit" value="Push Card" class="btn-custom btn-blue submitbtn"></input>
                    </div>
                   </div>
                 </div>
                  </form>
                </div>

              <!-- Create Card end here -->
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
</div>
</div>
</div>
</div>

<script>
  $('.submitbtn').click(function(){
   if( document.querySelector(".imagein").files.length == 0 ){
      var error = "please select image field!";
      $('#error1').removeClass('d-none');
      $('#error1').html(error);
  }else {
    $('#error1').addClass('d-none');
  }
  }); 
  </script>
  @include('admin.layout.footer')