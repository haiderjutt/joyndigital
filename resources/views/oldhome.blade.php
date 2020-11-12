<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Latitude </title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="css/topbar.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
       #flipflop:hover{
        color:black;
        cursor: pointer;
      }
      .alertbox {
        text-align:center;
        background-color: #f44336;
        color: darkblue;
        background-color: lightgray;
        display: none;
        position:relative;
        border-radius: 2px;
        font-family:cursive;
      }
    .my-card
    {
      position:absolute;
      right:0;
      top:0%;
      border-radius:20%;
      background: rgba(0, 0, 0, 0.349);
      color:white;
      border:5px solid #17bab271;
      font-family:cursive;
    }

    .my-card2
    {
      position:absolute;
      left:30%;
      top:40%;
      font-family:'Times New Roman', Times, serif;
      border-radius:60%;
      background: #17A2BA;
      color:white;
      border:5px solid whitesmoke;
    }
    </style>

  </head>

  <body ng-app="myApp" >
    <input ng-model="showcontrol" ng-init="showcontrol = 1" hidden>
      <div class="container-fluid" ng-controller="mainbody">
          @include('includes.topbar')
          <div class="row lat-mainbody" >
            <div class="lat-sidebar" ng-style="sidestyle">
                <div class="lat-sidebarcont" ng-style="sibarcontstyle" id="accordion">
                  <!-- sidebar -->
                  <!-- header -->
                  <div class="sidebarheader row">
                    <!-- <div class="col-md-6">
                      <img src="images/jd.gif" alt="JOYN DIGITAL" style="border-radius:100%; backgroud-color:white; height:50; width:50px;">
                    </div> -->
                    <div class="col-md-12">
                      <small>Welcome,</small>
                      <h6><i style="color:greenyellow;" class="fa fa-circle"></i><b> Haider Majeed</b></h6>
                    </div>
                  </div><hr>
                  <!-- headerend -->
                  <header><u>ADMIN DASHBOARD</u></header>
                  <ul>
                    <li>
                      <a type="button" href="#!"   data-toggle="collapse" data-target="#optionone"><i class="fa fa-home" ></i> Home</a>
                      <div id="optionone" class="collapse options" data-parent="#accordion"></div>
                    </li>
                    <li>
                      <a type="button" href="#!AllCustomers" data-toggle="collapse" data-target="#optiontwo"><i class="fa fa-user-secret"></i> Customer</a>
                      <div id="optiontwo" class="collapse options" data-parent="#accordion"></div>
                    </li>
                    <li >
                    <a type="button" data-toggle="collapse" data-target="#optionthree"> <i class="fa fa-users"></i> Workers <span class="fa fa-chevron-down"> </span></a>
                      <div id="optionthree" class="collapse options" data-parent="#accordion">
                        <ul>
                          <li><a href="#!AllAdministrator"><i class="fa fa-user"></i> Administrator</a> </li>
                          <li><a href="#!AllOperators"><i class="fa fa-user-md"></i> Operator</a> </li>
                          <li><a href="#!AllAgents"><i class="fa fa-male"></i> Vendor</a> </li>
                          <li><a href="#!AllVendors"><i class="fa fa-road"></i> Agent</a> </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a href="#!AllPackages" type="button" data-toggle="collapse" data-target="#optionfour"><i class="fa fa-money"></i> Packages</a>
                      <div id="optionfour" class="collapse options" data-parent="#accordion"></div>
                    </li>
                    <li >
                      <a type="button" data-toggle="collapse" data-target="#optionfive"><i class="fa fa-list-ol"></i> Templates <span class="fa fa-chevron-down"> </span></a>
                      <div id="optionfive" class="collapse options" data-parent="#accordion">
                        <ul>
                          <li><a href="#"> <i class="fa fa-user"></i> Create Template </a> </li>
                          <li><a href="#"> <i class="fa fa-users"></i> Template Library</a> </li>
                          <li><a href="#"> <i class="fa fa-user"></i> Module Library</a> </li>
                          <li><a href="#"><i class="fa fa-users"></i> Feature Library</a> </li>
                        </ul>
                      </div>
                    </li>
                  
                  </ul>
               
                  <!-- endsidebar -->
                  
                </div>
                <div class="lat-sidebarcontoptions" ng-style="sidebarcontoptionsstyle" id="miniaccordian">
                    <a href="#" data-toggle="collapse" data-target="#minioptionone"><i class="fa fa-home" title="HOME"></i> </a><br>
                      <div id="minioptionone" class="collapse minioptions" data-parent="#miniaccordian"></div>
                    <a href="# " data-toggle="collapse" data-target="#minioptiontwo"><i class="fa fa-user-secret" title="CUSTOMERS"></i> </a><br>
                      <div id="minioptiontwo" class="collapse minioptions" data-parent="#miniaccordian"></div>
                    <a href="#" data-toggle="collapse" data-target="#minioptionthree"><i class="fa fa-users" title="WORKERS"></i> </a><br>
                      <div id="minioptionthree" class="collapse minioptions" data-parent="#miniaccordian">
                            <a href="#"><i class="fa fa-user" title="ADMINISTRATOR"></i> </a> 
                            <a href="#"><i class="fa fa-user-md" title="OPERATOR"></i> </a> 
                            <a href="#"><i class="fa fa-male" title="VENDOR"></i> </a> 
                            <a href="#"><i class="fa fa-road" title="AGENTS"></i> </a>      
                      </div>
                    <a href="#" data-toggle="collapse" data-target="#minioptionfour"><i class="fa fa-fa fa-money" title="PACKAGES"></i> </a>
                     <div id="minioptionfour" class="collapse minioptions" data-parent="#miniaccordian"></div> 
                    <a href="#" data-toggle="collapse" data-target="#minioptionfive"><i class="fa fa fa-list-ol" title="TEMPLATES"></i> </a> 
                    <div id="minioptionfive" class="collapse minioptions" data-parent="#miniaccordian">
                                <a href="#"><i class="fa fa-user" title="CREATE TEMPLATE"></i> </a> 
                                <a href="#"><i class="fa fa-users" title="TEMPLATE LIBRARY"></i> </a> 
                                <a href="#"><i class="fa fa-user" title="MODULE LIBRARY"></i> </a> 
                                <a href="#"><i class="fa fa-users" title="FEATURE LIBRARY"></i> </a>      
                          </div>
                    <a href="#" data-toggle="collapse" data-target="#minioptionsix"><i class="fa fa fa-cubes" title="OTHERS"></i> </a>
                        <div id="minioptionsix" class="collapse minioptions" data-parent="#miniaccordian">
                            <a href="#"><i class="fa fa-user" title="ORDER FEATURE"></i> </a>      
                      </div> 
                </div>
                <div class="footer row" ng-style="sibarfooterstyle">
                  <div class="col-sm-6">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i></a>
                 
                  </div>
                  <div class="col-sm-6">
                  <a href="#" ng-click="isShowHide(showcontrol)" value="Show Div"><i class="fa fa-chevron-left"></i></a>
                  </div>
                </div>
                <div class="footertwo row" ng-style="sidebarcontoptions">
          
                  <div class="col-md-12">
                  <a href="#" ng-click="isShowHide(showcontrol)" value="Show Div"><i class="fa fa-chevron-right"></i></a>
                  </div>
                </div>
            </div>
            <div class="lat-maincontent"  ng-style="mainstyle">
              sdfsfsdfsdfsafgasfgafgafg
              {{-- <div ng-view></div> --}}
            </div>
          </div>
      </div>
    
    <!-- Js -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap-progressbar.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/angular-1.7.9/angular.min.js"></script>
    <script src="js/angular-1.7.9/angular-route.js"></script>

    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/maps.js"></script>
    <script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

    <!-- My-Js -->
    <script src="<?= asset('AdminComponentsJs/routes.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllCustomers.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/TableSorting.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllAdministrator.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/NewPackage.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllOperators.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllTemplates.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/InternalTemplate.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllVendors.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/Inventory.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllAgents.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/All.js') ?>"></script>


  </body>
</html>
