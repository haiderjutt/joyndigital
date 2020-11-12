<div class="row lat-mainbody">
  <div class="lat-sidebara" ng-style="sidestyle">
    <div class="lat-sidebarlarge" ng-style="sibarcontstyle" id="accordion">
      <div class="lat-sidebarheader">
        <div class="sidebarheader1">
          <header>ADMIN DASHBOARD</header>
        </div>
        <div class="sidebarheader2">
          <img src="./images/user.png" alt="ERR" width="50" height="50" style="border:2px solid white; border-radius:50%;">
          <h style="font-size: 12px;"><i style="color: greenyellow; font-size:10px; margin-left:10px;"> </i> Haider Majeed</h>
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
            <a type="button" href="#!AllCustomers" data-toggle="collapse" data-target="#optiontwo"><img src="./images/icons/User.png" height="30" width="30"> Customer</a>
            <div id="optiontwo" class="collapse options" data-parent="#accordion"></div>
          </li>
          {{-- <li>
              <a type="button" data-toggle="collapse" data-target="#optionthree"> <i class="fa fa-users"></i> Workers <span class="fa fa-chevron-down"> </span></a>
              <div id="optionthree" class="collapse options" data-parent="#accordion">
                <ul>
                  <li><a href="#!AllAdministrator"><i class="fa fa-user"></i> Administrator</a> </li>
                  <li><a href="#!AllOperators"><i class="fa fa-user-md"></i> Operator</a> </li>
                  <li><a href="#!AllAgents"><i class="fa fa-male"></i> Vendor</a> </li>
                  <li><a href="#!AllVendors"><i class="fa fa-road"></i> Agent</a> </li>
                </ul>
              </div>
            </li> --}}
          <li>
            <a href="#!AllPackages" type="button" data-toggle="collapse" data-target="#optionfour"><img src="./images/icons/Packages.png" height="30" width="30"> Packages</a>
            <div id="optionfour" class="collapse options" data-parent="#accordion"></div>
          </li>
          <li>
            <a type="button" href="#" data-toggle="collapse" data-target="#optionfive"><img src="./images/icons/Features.png" height="30" width="30">Feature Library. <span class="fa fa-chevron-down"> </span><a>
                <div id="optionfive" class="collapse options" data-parent="#accordion">
                  <ul>
                    <li><a href="#!Inventory"><img src="./images/icons/Inventory.png" height="30" width="30"> Inventory </a></li>
                    <li><a href="#"><img src="./images/icons/Features.png" height="30" width="30"> Feature Library </a></li>
                  </ul>
                </div>
          </li>
          <li>
            <a type="button" href="#" data-toggle="collapse" data-target="#optionsix"><i class="fa fa-cubes"></i>Others <span class="fa fa-chevron-down"> </span><a>
                <div id="optionsix" class="collapse options" data-parent="#accordion">
                  <ul>
                    <li><a href="#!Inventory"><i class="fa fa-user"></i> Inventory </a></li>
                    <li><a href="#"><i class="fa fa-user"></i> Feature Library </a></li>
                  </ul>
                </div>
          </li>
        </ul>
      </div>
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
<!-- 
<div class="lat-sidebar" ng-style="sidestyle" >
    <div class="lat-sidebarcont" ng-style="sibarcontstyle" id="accordion">
      <header>ADMIN DASHBOARD</header>
      <div class="sidebarheader row">
        <img src="./images/user.png" alt="ERR" width="50" height="50" style="border:2px solid white; border-radius:50%;">
        <h style="font-size: 12px;"><i style="color: greenyellow; fontsize:10px; margin-left:10px;"> </i> Haider Majeed</h>
      </div>
      <hr style="background-color:black; height:3px;">
      <!-- headerend -->
<ul>
  <li>
    <a type="button" href="#!" data-toggle="collapse" data-target="#optionone"><img src="./images/icons/homeJoyn.png" height="30" width="30"> Home</a>
    <div id="optionone" class="collapse options" data-parent="#accordion"></div>
  </li>
  <li>
    <a type="button" href="#!AllCustomers" data-toggle="collapse" data-target="#optiontwo"><img src="./images/icons/User.png" height="30" width="30"> Customer</a>
    <div id="optiontwo" class="collapse options" data-parent="#accordion"></div>
  </li>
  {{-- <li>
              <a type="button" data-toggle="collapse" data-target="#optionthree"> <i class="fa fa-users"></i> Workers <span class="fa fa-chevron-down"> </span></a>
              <div id="optionthree" class="collapse options" data-parent="#accordion">
                <ul>
                  <li><a href="#!AllAdministrator"><i class="fa fa-user"></i> Administrator</a> </li>
                  <li><a href="#!AllOperators"><i class="fa fa-user-md"></i> Operator</a> </li>
                  <li><a href="#!AllAgents"><i class="fa fa-male"></i> Vendor</a> </li>
                  <li><a href="#!AllVendors"><i class="fa fa-road"></i> Agent</a> </li>
                </ul>
              </div>
            </li> --}}
  <li>
    <a href="#!AllPackages" type="button" data-toggle="collapse" data-target="#optionfour"><img src="./images/icons/Packages.png" height="30" width="30"> Packages</a>
    <div id="optionfour" class="collapse options" data-parent="#accordion"></div>
  </li>
  <li>
    <a type="button" href="#" data-toggle="collapse" data-target="#optionfive"><img src="./images/icons/Features.png" height="30" width="30">Feature Library. <span class="fa fa-chevron-down"> </span><a>
        <div id="optionfive" class="collapse options" data-parent="#accordion">
          <ul>
            <li><a href="#!Inventory"><img src="./images/icons/Inventory.png" height="30" width="30"> Inventory </a></li>
            <li><a href="#"><img src="./images/icons/Features.png" height="30" width="30"> Feature Library </a></li>
          </ul>
        </div>
  </li>
  <li>
    <a type="button" href="#" data-toggle="collapse" data-target="#optionsix"><i class="fa fa-cubes"></i>Others <span class="fa fa-chevron-down"> </span><a>
        <div id="optionsix" class="collapse options" data-parent="#accordion">
          <ul>
            <li><a href="#!Inventory"><i class="fa fa-user"></i> Inventory </a></li>
            <li><a href="#"><i class="fa fa-user"></i> Feature Library </a></li>
          </ul>
        </div>
  </li>
</ul>
</div>
<div class="lat-sidebarcontoptions" ng-style="sidebarcontoptionsstyle" id="miniaccordian">
  <a href="#" data-toggle="collapse" data-target="#minioptionone"><img src="./images/icons/homeJoyn.png" height="30" width="30"> </a><br>
  <div id="minioptionone" class="collapse minioptions" data-parent="#miniaccordian"></div>
  <a href="#" data-toggle="collapse" data-target="#minioptiontwo"><img src="./images/icons/user.png" height="30" width="30"> </a><br>
  <div id="minioptiontwo" class="collapse minioptions" data-parent="#miniaccordian"></div>
  <a href="#" data-toggle="collapse" data-target="#minioptionfour"><img src="./images/icons/Packages.png" height="30" width="30"> </a><br>
  <div id="minioptionfour" class="collapse minioptions" data-parent="#miniaccordian"></div>
  {{-- <a href="#" data-toggle="collapse" data-target="#minioptionthree"><i class="fa fa-users" title="WORKERS"></i> </a><br>
      <div id="minioptionthree" class="collapse minioptions" data-parent="#miniaccordian">
        <a href="#"><i class="fa fa-user" title="ADMINISTRATOR"></i> </a> 
        <a href="#"><i class="fa fa-user-md" title="OPERATOR"></i> </a> 
        <a href="#"><i class="fa fa-male" title="VENDOR"></i> </a> 
        <a href="#"><i class="fa fa-road" title="AGENTS"></i> </a>      
      </div> --}}
  <a href="#" data-toggle="collapse" data-target="#minioptionfour"><img src="./images/icons/Packages.png" height="30" width="30"> </a>
  <div id="minioptionfour" class="collapse minioptions" data-parent="#miniaccordian"></div>
  {{-- <a href="#" data-toggle="collapse" data-target="#minioptionfive"><i class="fa fa fa-list-ol" title="TEMPLATES"></i> </a> 
      <div id="minioptionfive" class="collapse minioptions" data-parent="#miniaccordian">
        <a href="#"><i class="fa fa-user" title="CREATE TEMPLATE"></i> </a> 
        <a href="#"><i class="fa fa-users" title="TEMPLATE LIBRARY"></i> </a> 
        <a href="#"><i class="fa fa-user" title="MODULE LIBRARY"></i> </a> 
        <a href="#"><i class="fa fa-users" title="FEATURE LIBRARY"></i> </a>      
      </div> --}}
</div>
<input ng-model="footerstate" ng-init="footerstate = 0" ng-change="Footerfunction()" hidden>
<div class="footer row" ng-style="sibarfooterstyle">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-6">
        <a href="#"><i class="fa fa-power-off"></i></a>
      </div>
      <div class="col-md-6">
        <a href="" ng-click="isShowHide(1)" value="Show Div"><i class="fa fa-chevron-left"></i></a>
      </div>
    </div>
  </div>
</div>
<div class="footertwo row" ng-style="sidebarcontoptions">
  <div class="col-md-12">
    <a ng-click="isShowHide(0)" value="Show Div"><i class="fa fa-chevron-right"></i></a>
  </div>
</div>
</div> -->