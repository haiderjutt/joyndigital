<div class="row lat-mainbody" >
  <div class="lat-sidebar" ng-style="sidestyle" >
    <div class="lat-sidebarcont" ng-style="sibarcontstyle" id="accordion">
      <header>ADMINISTRATOR DASHBOARD</header>
      <div class="sidebarheader row">
        <img src="./images/user.png" alt="ERR" width="50" height="50" style="border:2px solid white; border-radius:50%;">
        <h style="font-size: 12px;"><i style="color: greenyellow; fontsize:10px; margin-left:10px;"> </i> Haider Majeed</h>
      </div>
      <hr style="background-color:black; height:3px;">
      <!-- headerend -->
      
      <ul>
          <li>
            <a type="button" href="#!"   data-toggle="collapse" data-target="#optionone"><img src="./images/icons/homeJoyn.png" height="30" width="30"> Home</a>
            <div id="optionone" class="collapse options" data-parent="#accordion"></div>
          </li>
          <li>
            <a type="button" href="#!Workers"   data-toggle="collapse" data-target="#optionone"><img src="./images/icons/homeJoyn.png" height="30" width="30"> Workers</a>
            <div id="optionone" class="collapse options" data-parent="#accordion"></div>
          </li>
      </ul>
    </div>
    <div class="lat-sidebarcontoptions" ng-style="sidebarcontoptionsstyle" id="miniaccordian">
      <a href="#" data-toggle="collapse" data-target="#minioptionone"><img src="./images/icons/homeJoyn.png" height="30" width="30"> </a><br>
      <div id="minioptionone" class="collapse minioptions" data-parent="#miniaccordian"></div>
      <a href="#!Customers " data-toggle="collapse" data-target="#minioptiontwo"><img src="./images/icons/user.png" height="30" width="30"> </a><br>
      <div id="minioptiontwo" class="collapse minioptions" data-parent="#miniaccordian"></div> 
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
    <div class="footertwo row" ng-style="sidebarcontoptionsstyle">
      <div class="col-md-12">
        <a  ng-click="isShowHide(0)" value="Show Div"><i class="fa fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
  <div class="lat-maincontent" ng-style="mainstyle" >
    <div class="Loading" ng-show="Loadingstyle=false">
      <div class="bounce">
        <p></p>
      </div>
    </div>
    <div  ng-view class="ngview"></div>
  </div>
 
</div>