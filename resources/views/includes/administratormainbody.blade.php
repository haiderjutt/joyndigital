<div class="row lat-mainbody">
  <div class="lat-sidebara" ng-style="sidestyle">
    <div class="lat-sidebarlarge" ng-style="sibarcontstyle" id="accordion">
      <div class="lat-sidebarheader">
        <div class="sidebarheader1">
          <header>ADMINISTRATOR DASHBOARD</header>
        </div>
        <div class="sidebarheader21">
          <h style="font-size: 12px;"><i style="color: greenyellow; font-size:10px; margin-left:10px;"> </i> {{ Auth::user()->name }}</h>
          <h style="font-size: 12px;"><i style="color: greenyellow; font-size:10px; margin-left:10px;" class="fa fa-circle"> </i> online</h>
         </div>
        <hr style="background-color:black; height:3px;">
      </div>
      <div class="lat-sidebarbody">
        <ul>
          <li>
            <a type="button" href="#!" data-toggle="collapse" data-target="#optionone"><img src="./images/icons/homeJoyn.png" height="30" width="30"> Home</a>
            <div id="optionone" class="collapse options" data-parent="#accordion"></div>
          </li>
          <li>
            <a type="button" href="#!Workers" data-toggle="collapse" data-target="#optionone"><img src="./images/icons/homeJoyn.png" height="30" width="30"> Workers</a>
            <div id="optionone" class="collapse options" data-parent="#accordion"></div>
          </li>
        </ul>
      </div>
      <div class="lat-sidebarfooter">
        <div class="lat-sidebarfooter1">
          <a href="#"><i class="fa fa-power-off"></i></a>
        </div>
        <div class="lat-sidebarfooter2">
          <a href="" ng-click="isShowHide(1)" value="Show Div"><i class="fa fa-chevron-left"></i></a>
        </div>
      </div>
    </div>
  </div>
  <div class="lat-sidebaramini" ng-style="sidebarcontoptionsstyle" id="miniaccordian">
    <div class="lat-sidebarlargemini">
      <div class="lat-sidebarlargemini1">
        <a href="#" data-toggle="collapse" data-target="#minioptionone"><img src="./images/icons/homeJoyn.png" height="30" width="30"> </a><br>
        <div id="minioptionone" class="collapse minioptions" data-parent="#miniaccordian"></div>
      </div>
      <div class="lat-sidebarlargemini2">
        <a href="#!Customers " data-toggle="collapse" data-target="#minioptiontwo"><img src="./images/icons/user.png" height="30" width="30"> </a><br>
        <div id="minioptiontwo" class="collapse minioptions" data-parent="#miniaccordian"></div>
      </div>
    </div>
    <div class="lat-sidebarfooter">
      <a ng-click="isShowHide(0)" value="Show Div"><i class="fa fa-chevron-right"></i></a>
    </div>
  </div>

  <div class="lat-maincontent" ng-style="mainstyle">
    <div class="Loading" ng-show="Loadingstyle=false">
      <div class="bounce">
        <p></p>
      </div>
    </div>
    <div ng-view class="ngview"></div>
  </div>

</div>
