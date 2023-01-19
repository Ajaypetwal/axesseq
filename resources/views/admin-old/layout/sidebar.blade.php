<nav id="sidebarMenu" class="sidebarMenu navbar navbar-expand-lg navbar-light bg-light pt-0">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="sidebar pad-top collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav flex-column">
              <li class="nav-items">
                <a class="nav-links" href="{{url('/dashboard')}}">
                  <img src="{{ URL::to('/')}}/admin/images/dashboardblack.svg" alt="dashboard" class="blackimg"><img src="{{ URL::to('/')}}/admin/images/dashboard.svg" alt="dashboard" class="hover"><span>Dashboard</span>
                </a>
              </li>
              <li class="nav-items">
                <a class="nav-links" href="{{url('/push-card-dashboard')}}">
                  <img src="{{ URL::asset('admin/images/pushcards.svg') }}" alt="pushcard" class="blackimg"><img src="{{ URL::asset('admin/images/pushcardcolor.svg') }}" alt="pushcard" class="hover"><span>Push Cards</span>
                </a>
              </li>
              <li class="nav-items">
                <a class="nav-links" href="{{url('/advertisment')}}">
                  <img src="{{ URL::asset('admin/images/advertisementcolor.svg') }}" alt="Advertisements" class="hover"><img src="{{ URL::asset('admin/images/advertisement.svg') }}" alt="Advertisements" class="blackimg"><span>Advertisements</span>
                </a>
              </li>
              <li class="nav-items">
                <a class="nav-links" href="{{url('/admin-push-notification')}}">
                <img src="{{ URL::asset('admin/images/notificationblue.svg') }}" alt="Push Notifications" class="hover">
                  <img src="{{ URL::asset('admin/images/pushnoti.svg') }}" alt="Push Notifications" class="blackimg"><span>Push Notifications</span>
                </a>
              </li>
              <li class="nav-items">
                <a class="nav-links" href="{{url('/guide-line-term')}}">
                  <img src="{{ URL::asset('admin/images/guidelines.svg') }}" alt="Guidelines" class="blackimg"><img src="{{ URL::asset('admin/images/guidlinecolor.svg') }}" alt="Guidelines" class="hover"><span>Guidelines</span>
                </a>
              </li>
              <li class="nav-items">
                <a class="nav-links" href="{{url('/support')}}">
                  <img src="{{ URL::asset('admin/images/support.svg') }}" alt="Support" class="blackimg"><img src="{{ URL::asset('admin/images/supportblue.svg') }}" alt="Guidelines" class="hover"><span>Support</span>
                </a>
              </li>
            </ul>
          </div>
        </nav>