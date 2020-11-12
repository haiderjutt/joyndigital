<div class="row Clat-topbar">
      <div class="leftside">
            <a style="margin-right:5px;" ng-click="isShowHide(showcontrol)" class="bars">
                  <span class="icon1" ng-style="topbartopstyle"></span>
                  <span class="icon2" ng-style="topbarmiddlestyle"></span>
                  <span class="icon3" ng-style="topbarbottomstyle"></span>
            </a>
            <a href="chatify" class="licons"><img src="./images/icons/Message.png" height="30" width="30"> <sup class="supclass">@php echo DB::table('messages')->where('to_id', Auth::user()->id )->where('seen','0')->get()->count(); @endphp</sup></a>
            <a href="#" class="licons"><img src="./images/icons/Alert.png" height="30" width="30"> <sup class="supclass">2</sup></a>
      </div>
      <div class="center">
            <img src="images/logo.png" alt="LATITUDE" style=" height:30px; width:100px; z-index:1;">
      </div>
      <div class="right">
            <a title="Logout" href="{{ route('logout') }}" style="font-size:15px; color:white;" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="color:white; float:right;"><img src="./images/icons/Logouti.png" height="35" width="35"></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
            </form>
      </div>
</div>