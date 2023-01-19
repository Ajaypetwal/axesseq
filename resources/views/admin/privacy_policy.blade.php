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
            <a href="#" onClick="$('#sidebarMenu').toggle()" id="sidebar-control"><img src="{{asset('admin/images/leftarrow.svg')}}"></a>
            <h1 class="h2">Edit privacy policy</h1>
          </div>
          <form action="{{route('editPrivacy')}}" method="POST">
            @csrf
          <div class="profileinfo">
            <div class="row">
              <div class="col-lg-8 col-md-12">
                <h5 class="ml-3">Description</h5>
                    <div class="col">
                      <textarea class="form-control" style="min-width:50rem" id="exampleFormControlTextarea1" name="description" value="{{$data->description}}" rows="10"
                        placeholder="Description"  required>{{$data->description}}</textarea>
                        @error('description')
                          <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div> 
                     </div>
                </div>
                <div class="btn-guide-blue mt-4">
                    <button type="submit" class="guideline-btn guide-btn-blue">Save</button>
                </div>
              </div>
             </div>
             </div>
         </div>
       </div>
    </form>
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
  </div> 
</div>

 @include('admin.layout.footer')