<div class="operatortopbar">
      
  <div class="operatorlogout">
      <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="color:white; float:right;"><i class="fa fa-power-off"></i> </a>
  </div>     
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
  </form>
</div>
<div class="operatormainbody">
  <div ng-view></div>
</div>