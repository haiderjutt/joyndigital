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
    <link href="css/custom.min.css" rel="stylesheet">
    <link href="css/sidebarLogo.css" rel="stylesheet">

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

      .closebtn {
        margin-left: 10px;
        color: darkblue;
        font-weight: bold;
        float: right;
        font-size: 20px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
      }

      .closebtn:hover {
        color: black;
      }


      .switch {
      position: relative;
      display: inline-block;
      width: 30px;
      height: 17px;
    }

    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 15px;
      width: 12px;
      left: 1px;
      bottom: 1px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(15px);
      -ms-transform: translateX(15px);
      transform: translateX(15px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 20px;
    }

    .slider.round:before {
      border-radius: 50%;
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

    .switchdemoBasicUsage .inset {
  padding-left: 25px;
  padding-top: 25px; }
    </style>

  </head>

  <body class="nav-md" ng-app="myApp" >
    <div class="container body">
      <div class="main_container">
        <!-- Side-Bar -->
        @include('includes.Admin_sidebar')

        <!-- Top-bar -->
        @include('includes.Admin_topbar')

        <!-- Main-Content -->
        <div class="right_col" role="main">
          <div class="row" id="main_content_container">
            <div class="col-md-12"><div ng-view style=" border-radius:10px; border-top:none;"></div></div>
          </div> 
          <div class="row" id="statusTable" style="display:none;">
            <div class="row" style="background-color:#17a2ba; padding-top: 13px; border-radius: 5px; color:white;position:relative;">
              <div class="col-sm-3" style="text-align:center;">
                  <div class="row" >
                      <p style="font-size:12px;  padding-left:15px;"> <b>Items Per Page </b>  : </p>
                      <u style="font-size:12px;  padding-left:10px;">All</u>
                  </div>
              </div>
              <div class="col-sm-3" style="text-align: center; ">
                  <span style="font-size: 12px; border-top: 5px solid red; "> <p style="color:white;"> <b>Page</b> : <u>1</u> <b>of</b> <u>1</u></p></span>
              </div>
              <div class="col-sm-1"></div>
              <div class="col-sm-5" style="text-align: center;">
                  <p><input type="text" ng-model="test" placeholder="Not Available" style="border-radius: 5px; height:20px;" disabled></p> 
              </div>
            </div>
            <table class="table table-striped table-condensed table-hover">
              @php $users = DB::table('users')->get(); @endphp
              <thead>
              <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Status</th>
              </tr>
              </thead>
              <tbody>
              @foreach($users as $user)
                      <tr>
                          <td>{{$user->name}}</td>
                          <td>{{$user->email}}</td>
                          <td>{{$user->phone}}</td>
                          <td>
                              @if(Cache::has('user-is-online-' . $user->id))
                                  <span class="text-success">Online</span>
                              @else
                                  <span class="text-secondary">Offline</span>
                              @endif
                          </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <!-- Footer -->
        @include('includes.footer01')

      </div>
    </div>
    
    <!-- Js -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap-progressbar.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/angular-1.7.9/angular.min.js"></script>
    <script src="js/angular-1.7.9/angular-route.js"></script>

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
    <script>
      var global_sequence= "0";
      $( document ).ready(function() {
        $("#opt_home").click(function(){$("#main_pointer").val("Home");});
        $("#opt_customers").click(function(){$("#main_pointer").val("Customers");});
        $("#opt_administrators").click(function(){$("#main_pointer").val("Administrators");});
        $("#opt_operators").click(function(){$("#main_pointer").val("Operators");});
        $("#opt_packages").click(function(){$("#main_pointer").val("Packages");});
        $("#opt_templates").click(function(){$("#main_pointer").val("Templates");});
        $("#opt_agents").click(function(){$("#main_pointer").val("Agents");});
        $("#opt_vendors").click(function(){$("#main_pointer").val("Vendors");});
        $("#opt_inventory").click(function(){$("#main_pointer").val("Inventory");});
        $("#clicktesting").click(function(){
          alert("here");
        });

        $("#onlineStatus").click(function(){
          var stat = $("#onlineStatus").val();
          if(stat == 'on'){
            $("#onlineStatus").val("off");
            $("#main_content_container").css({
              "display": "none"
            });
            $("#statusTable").css({
              "display": "block",
              "font-size": "12px"
            });
          }else{
            $("#onlineStatus").val("on");
            $("#main_content_container").css({
              "display": "block"
            });
            $("#statusTable").css({
              "display": "none",
              "font-size": "12px"
            });
          }
        });
      });
      
    </script>

  </body>
</html>
