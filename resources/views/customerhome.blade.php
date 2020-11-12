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
    <link href="css/customertopbar.css" rel="stylesheet">
    <link href="css/customermain.css" rel="stylesheet">
    <link href="css/customerfilters.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <style>
        /* 
 * Don't modify things marked with ! - unless you know what you're doing
 */

        /* ! vertical layout */
        .multiSelect .vertical {
            float: none;
        }

        /* ! horizontal layout */
        .multiSelect .horizontal:not(.multiSelectGroup) {
            float: left;
        }

        /* ! create a "row" */
        .multiSelect .line {
            padding: 2px 0px 4px 0px;
            max-height: 30px;
            overflow: hidden;
            box-sizing: content-box;
        }

        /* ! create a "column" */
        .multiSelect .acol {
            display: inline-block;
            min-width: 12px;
        }

        /* ! */
        .multiSelect .inlineBlock {
            display: inline-block;
        }

        /* the multiselect button */
        .multiSelect>button {
            display: inline-block;
            position: relative;
            text-align: center;
            cursor: pointer;
            padding: 1px 8px 1px 8px;
            width: 120px;
            font-size: 10px;
            min-height: 30px !important;
            border-radius: 4px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
            white-space: normal;
            background-color: rgba(0, 0, 0, .6);
            color: wheat;
        }

        /* button: hover */
        .multiSelect>button:hover {
            background-image: linear-gradient(#444, #27291e);
        }

        /* button: disabled */
        .multiSelect>button:disabled {
            background-image: linear-gradient(#fff, #fff);
            border: 1px solid #ddd;
            color: #999;
        }

        /* button: clicked */
        .multiSelect .buttonClicked {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* labels on the button */
        .multiSelect .buttonLabel {
            display: inline-block;
            padding: 2px 0px 2px 0px;
        }

        /* downward pointing arrow */
        .multiSelect .caret {
            display: none;
            width: 0;
            height: 0;
            margin: 0px 0px 1px 12px !important;
            vertical-align: middle;
            border-top: 4px solid transparent;
            border-right: 4px solid #333;
            border-left: 4px solid #333;
            border-bottom: 0 dotted;
            color: wheat;
            background-color: wheat;
        }

        /* the main checkboxes and helper layer */
        .multiSelect .checkboxLayer {
            background-color: #27291e;
            position: fixed;
            z-index: 10000;
            border: 1px solid wheat;
            border-radius: 4px;
            -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            width: 120px;
            display: none !important;
        }

        /* container of helper elements */
        .multiSelect .helperContainer {
            border-bottom: 1px solid #ddd;
        }

        /* helper buttons (select all, none, reset); */
        .multiSelect .helperButton {

            cursor: pointer;
            border: 1px solid #ccc;
            height: 20px;
            font-size: 9px;
            border-radius: 1px;
            color: #666;
            background-color: black;
            color: wheat;
            line-height: 1.6;
            background-color: #27291e;
            margin-left: 2px;
        }
    

        /* clear button */
        .multiSelect .clearButton {
            position: absolute;
            display: inline;
            text-align: center;
            cursor: pointer;
            border: 1px solid #ccc;
            height: 20px;

            font-size: 10px;
            border-radius: 2px;
            color: #666;
            background-color: #27291e;
            color: wheat;
            line-height: 1.4;
            right: 2px;
            top: 4px;
        }

        /* filter */
        .multiSelect .inputFilter {
            border-radius: 2px;
            border: 1px solid #ccc;
            height: 26px;
            font-size: 12px;
            width: 100%;
            padding-left: 7px;
            -webkit-box-sizing: border-box;
            /* Safari/Chrome, other WebKit */
            -moz-box-sizing: border-box;
            /* Firefox, other Gecko */
            box-sizing: border-box;
            /* Opera/IE 8+ */
            color: #888;

            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        }

        /* helper elements on hover & focus */
        .multiSelect .clearButton:hover,
        .multiSelect .helperButton:hover {
            border: 1px solid #ccc;
            background-color: black;
            color: wheat;
        }

        .multiSelect .helperButton:disabled {
            color: #ccc;
            border: 1px solid #ddd;
        }

        .multiSelect .clearButton:focus,
        .multiSelect .helperButton:focus,
        .multiSelect .inputFilter:focus {
            border: 1px solid #66AFE9 !important;
            outline: 0;
            -webkit-box-shadow: inset 0 0 1px rgba(0, 0, 0, .065), 0 0 5px rgba(102, 175, 233, .6) !important;
            box-shadow: inset 0 0 1px rgba(0, 0, 0, .065), 0 0 5px rgba(102, 175, 233, .6) !important;
        }

        /* container of multi select items */
        .multiSelect .checkBoxContainer {
            display: block;
            overflow: hidden;
        }

        /* ! to show / hide the checkbox layer above */
        .multiSelect .show {
            display: block !important;
        }

        /* item labels */
        .multiSelect .multiSelectItem {
            display: block;
            color: wheat;
            background-color: #27291e;
            white-space: nowrap;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
            position: relative;
            max-width: 100%;
            min-height: 25px;
            font-size: 12px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }


        /* Styling on selected items */
        .multiSelect .multiSelectItem:not(.multiSelectGroup).selected {
            background-image: linear-gradient(#e9e9e9, #f1f1f1);
            color: #555;
            cursor: pointer;
            border-top: 1px solid #e4e4e4;
            border-left: 1px solid #e4e4e4;
            border-right: 1px solid #d9d9d9;
        }

        .multiSelect .multiSelectItem .acol label {
            display: inline-block;
            padding-right: 30px;
            margin: 0px;
            font-weight: normal;
            line-height: normal;
        }

        /* item labels focus on mouse hover */
        .multiSelect .multiSelectItem:hover,
        .multiSelect .multiSelectGroup:hover {
            background-image: linear-gradient(#c1c1c1, #999) !important;
            color: black !important;
            cursor: pointer;
            border: 1px solid #ccc !important;
        }

        /* item labels focus using keyboard */
        .multiSelect .multiSelectFocus {
            background-image: linear-gradient(#c1c1c1, #999) !important;
            color: #fff !important;
            cursor: pointer;
            border: 1px solid #ccc !important;
        }

        /* change mouse pointer into the pointing finger */
        .multiSelect .multiSelectItem span:hover,
        .multiSelect .multiSelectGroup span:hover {
            cursor: pointer;
        }

        /* ! group labels */
        .multiSelect .multiSelectGroup {
            display: block;
            clear: both;
        }

        /* right-align the tick mark (&#10004;) */
        .multiSelect .tickMark {
            display: inline-block;
            position: absolute;
            right: 10px;
            top: 7px;
            font-size: 10px;
        }

        /* hide the original HTML checkbox away */
        .multiSelect .checkbox {
            color: #ddd !important;
            position: absolute;
            left: -9999px;
            cursor: pointer;
        }

        /* checkboxes currently disabled */
        .multiSelect .disabled,
        .multiSelect .disabled:hover,
        .multiSelect .disabled label input:hover~span {
            color: #c4c4c4 !important;
            cursor: not-allowed !important;
        }

        /* If you use images in button / checkbox label, you might want to change the image style here. */
        .multiSelect img {
            vertical-align: middle;
            margin-bottom: 0px;
            max-height: 22px;
            max-width: 22px;
        }

        @media screen and (max-width: 1700px) {
            .multiSelect>button {
                width: 120px;
            }

            .multiSelect .checkboxLayer {
                width: 120px;
            }

            .multiSelect .helperButton {
                border: 1px solid #ccc;
                font-size: 8px;
                line-height: 1.6;
            }
        }

        @media screen and (max-width: 1600px) {
            .multiSelect>button {
                width: 110px;
            }

            .multiSelect .checkboxLayer {
                width: 110px;
            }
            .multiSelect .helperButton {
                border: 1px solid #ccc;
                font-size: 7.8px;
                line-height: 1.6;
            }
        }

        @media screen and (max-width: 1500px) {
            .multiSelect>button {
                width: 105px;
            }

            .multiSelect .checkboxLayer {
                width: 105px;
            }
            .multiSelect .helperButton {
                border: 1px solid #ccc;
                font-size: 7px;
                line-height: 1.6;
            
            }
        }

        @media screen and (max-width: 1400px) {
            .multiSelect>button {
                width: 100px;
            }

            .multiSelect .checkboxLayer {
                width: 100px;
                position: sticky;
            }
            .multiSelect .helperButton {
                border: 1px solid #ccc;
                font-size: 7px;
                line-height: 1.6;
            
            }
         
        }

        @media screen and (max-width: 1300px) {
            .multiSelect>button {
                width: 95px;
            }

            .multiSelect .checkboxLayer {
                width: 95px;
                position: sticky;
            }
            .multiSelect .helperButton {
                border: 1px solid #ccc;
                font-size: 6.7px;
                line-height: 1.6;
            
            }
        }

        @media screen and (max-width: 1200px) {

            .multiSelect>button {
                width: 90px;
            }

            .multiSelect .checkboxLayer {
                width: 90px;
            }
            .multiSelect .helperButton {
                border: 1px solid #ccc;
                font-size: 6px;
                line-height: 1.6;
            
            }
        }

        @media screen and (max-width: 1100px) {
            .multiSelect>button {
                width: 90px;
            }

            .multiSelect .checkboxLayer {
                width: 90px;
            }
            .multiSelect .helperButton {
                border: 1px solid #ccc;
                font-size: 5.7px;
                line-height: 1.6;
            
            }
        }

        @media screen and (max-width: 1000px) {
            .multiSelect>button {
                width: 85px;
            }

            .multiSelect .checkboxLayer {
                width: 85px;
            }
            .multiSelect .helperButton {
                border: 1px solid #ccc;
                font-size: 5px;
                line-height: 1.6;
            
            }
        }

        @media screen and (max-width: 900px) {
            .multiSelect>button {
                width: 80px;
            }

            .multiSelect .checkboxLayer {
                width: 80px;
            }
        }

        @media screen and (max-width: 800px) {

            .multiSelect .checkboxLayer {
                width: 120px;
            }
        }
    </style>




</head>

<body ng-app="myApp">
    <input ng-model="showcontrol" ng-init="showcontrol = 1" hidden>
    <div class="container-fluid" ng-controller="customermainbody">
        @include('includes.customertopbar')
        <div ng-view class="row"></div>
    </div>

    <!-- Js -->
    <script>
        var global_sequence = "{{ Auth::user()->id }}";
        var global_sequence1 = 0;
        var customer_fields = {
            'Basic': {
                'Controlled': {},
                'Input': {},
                'Dropdown': {},
                'Range' :{},
                'Date': {},
                'Current':{}
            }
        }
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap-progressbar.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/angular-1.7.9/angular.min.js"></script>
    <script src="js/angular-1.7.9/angular-route.js"></script>
    <script src="js/Chart.js/Chart.js"></script>
    <script src="js/chart/angular-chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.7.0/lodash.min.js"></script>

    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/maps.js"></script>
    <script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6l5bH_gXHS6Qjxk4MdS_bDaqicwzI_uE&callback=&libraries=&v=weekly" defer></script>



    <!-- My-Js -->
    <script src="<?= asset('CustomerComponentsJs/Routes.js') ?>"></script>
    <script src="<?= asset('CustomerComponentsJs/CustomerHome.js') ?>"></script>
    <script src="<?= asset('CustomerComponentsJs/angularjs-dropdown-multiselect.js') ?>"></script>

</body>

</html>