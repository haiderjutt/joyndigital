<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
         
        </div>
        
        <nav class="nav navbar-nav">
          
        <ul class=" navbar-right">
          <strong><u>Dashboard</u></strong> <i class="fa fa-arrow-right"> </i> <input type="text"  id="main_pointer" value="Main" readonly style="border:0px; background:transparent; font-family:serif; color:#5E6974;">
          <li class="nav-item dropdown open" style="padding-left: 15px;">
            <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
              <img src="images/img.jpg" alt="">{{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item"  href="javascript:;">Help</a>
              <a class="dropdown-item"  href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              <i class="fa fa-sign-out pull-right"></i> Log Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
            </div>
          </li>
          
          <li role="presentation" class="nav-item dropdown open" style="position:relative; margin-left:10px;">
            
            <a href="chatify" class="dropdown-toggle info-number" >
              <i class="fa fa-envelope-o"></i>
              <span class="badge bg-green">@php echo DB::table('messages')->where('to_id', Auth::user()->id )->where('seen','0')->get()->count(); @endphp</span>
            </a>
          </li>
          <li role="presentation" class="nav-item dropdown open" style="position:relative;margin-left:2px;">
            <label class="switch" >
              <input type="checkbox" id="onlineStatus">
              <span class="slider round"></span>
            </label>
          </li>
          <li role="presentation" class="nav-item dropdown open" style="position:relative; ">
            <u>Online-Status </u> 
          </li>
        </ul>
      </nav>
    </div>
  </div>