<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Latitude </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="css/operatorcss.css" rel="stylesheet">
  </head>

  <body  ng-app="myApp" >
      <input ng-model="showcontrol" ng-init="showcontrol = 1" hidden>
      <div class="container-fluid" ng-controller="operatormainbody">
        @include('includes.operatormainbody')
      </div>
   
    <!-- Js -->
    <script>
        var global_sequence = 0;
        var operatorside = {
            'form' :{}

        }

    </script>
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
    <script src="<?= asset('OperatorComponentsJs/routes.js') ?>"></script>
    <script src="<?= asset('OperatorComponentsJs/Customerslist.js') ?>"></script>
    <script src="<?= asset('OperatorComponentsJs/Customerform.js') ?>"></script>

     <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7heras8LxUkJxZSbXmJvPBB1qMStJTM4&callback=&libraries=&v=weekly"
      defer
    ></script>
  </body>
</html>