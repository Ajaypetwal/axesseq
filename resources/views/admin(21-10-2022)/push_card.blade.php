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
        <main role="main" class="contentPart">
            <div class="pushbtn">
              <h1 class="h2"> Push Cards</h1>
              <div class="btn-right-blue">
                <a href="{{route('pushCard')}}" class="btn-custom btn-blue">Create New Card</a>
              </div>
            </div>
            <div class="profileinfo">
              <div class="row">
                <div class="col-md-12">
                  <h4 class="card-heading">Card Lists</h4>
                </div>
              </div>

              @if(Session::has('message'))
                 <div class="alert alert-success">
                  <p>{!! Session::get('message') !!}</p>
                 </div>
               @endif
               @if(Session::has('error'))
                 <div class="alert alert-danger">
                  <p>{!! Session::get('error') !!}</p>
                 </div>
               @endif 
           <!-- // Card start here -->
              @if(isset($data) && count($data)>0)
                @foreach($data as $value)
               <div class="card custom-card mb-3 mt-5 border-botm">
                <div class="row">
                
                  <div class="col-md-4 col-sm-4">
                    <img src="images/{{$value->image}}" alt="badges">
                  </div>
               
                  <div class="col-md-8 col-sm-8">
                    <div class="card-body cus-card-body">
                  
                      <div class="title-icon">
                        <h5 class="card-title">{{$value->title}}</h5>
                        
                        <div class="cardedit">
                            <a href="{{route('editPushCard',['id'=>$value->_id])}}">
                          <button class="edit-btn">
                            <img src="{{asset('admin/images/cardedit.svg')}}" alt="edit">
                          </button>
                         </a>
                        
                         <a href="{{route('deletePush',['id'=>$value->_id])}}">
                          <button class="delete-btn">
                            <img src="{{asset('admin/images/carddelete.svg')}}" alt="delete">
                          </button>
                         </a>
                        </div>
                      </div>
                      <p class="date">{{date('d. m. Y',strtotime($value->created_at))}}</p>
                      <p class="card-text">{{$value->description}}</p>
                    
                      <p class="card-text"><img src="{{asset('admin/images/cardcalendar.svg')}}" alt="calendar"><span
                        class="calendar-text">{{date('d. m. Y',strtotime($value->date))}}</span></p>
                    </div>
                  </div>
                </div>
              </div>
             
             @endforeach
             @endif
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