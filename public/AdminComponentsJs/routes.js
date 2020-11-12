var app = angular.module('myApp', ["ngRoute", "chart.js"], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    })
    .controller('mainbody', ['$scope', function($scope, $rootScope) {
        $scope.balls = false;

        $scope.main = 'main';
        $scope.init = 'topbar';

        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("chartdiv", am4maps.MapChart);

        // Set map definition
        chart.geodata = am4geodata_worldLow;

        // Set projection
        chart.projection = new am4maps.projections.Orthographic();
        chart.panBehavior = "rotateLongLat";
        chart.deltaLatitude = -20;
        chart.padding(4, 4, 4, 4);

        // Create map polygon series
        var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

        // Make map load polygon (like country names) data from GeoJSON
        polygonSeries.useGeodata = true;
        //polygonSeries.include = ["BR", "UA", "MX", "CI"];

        // Configure series
        var polygonTemplate = polygonSeries.mapPolygons.template;
        polygonTemplate.tooltipText = "{name}";
        polygonTemplate.fill = am4core.color("#ffffff");
        polygonTemplate.stroke = am4core.color("#ffffff");
        polygonTemplate.strokeWidth = 0.5;
        polygonTemplate.cursorOverStyle = am4core.MouseCursorStyle.pointer;
        polygonTemplate.url = "https://www.datadrum.com/main.php?package={id}";
        polygonTemplate.urlTarget = "_blank";

        var graticuleSeries = chart.series.push(new am4maps.GraticuleSeries());
        graticuleSeries.mapLines.template.line.stroke = am4core.color("#ffffff");
        graticuleSeries.mapLines.template.line.strokeOpacity = 0.09;
        graticuleSeries.fitExtent = false;


        chart.backgroundSeries.mapPolygons.template.polygon.fillOpacity = 0.1;
        chart.backgroundSeries.mapPolygons.template.polygon.fill = am4core.color("#ffffff");

        // Create hover state and set alternative fill color
        var hs = polygonTemplate.states.create("hover");
        hs.properties.fill = chart.colors.getIndex(0).brighten(-0.5);

        let animation;
        setTimeout(function() {
            animation = chart.animate({ property: "deltaLongitude", to: 10000 }, 300000);
        }, 1000)

        chart.seriesContainer.events.on("down", function() {
                //  animation.stop();
            })
            //end top javascript
        $scope.$on("SendUp", function(value) {
            $scope.isShowHide(value);
        });
        $scope.isShowHide = function(state) {
            if (state == 1) {
                $scope.footerstate = state;
                $scope.showcontrol = 0;
                $scope.$broadcast('eventBroadcastedName');
                $scope.topbartopstyle = {
                    "transform": "rotate(0)",
                    "transform-origin": "-11% 80%",
                };
                $scope.topbarmiddlestyle = {
                    "opacity": "1",
                };
                $scope.topbarbottomstyle = {
                    "transform": "rotate(0)",
                    "transform-origin": "0% 50%",
                };
                $scope.sibarcontstyle = {
                    "display": "none",
                    "opacity": "0",
                    "visibility": "hidden"
                };
                $scope.sibarfooterstyle = {
                    "display": "none"
                };
                $scope.mainstyle = {

                    "width": "100%",
                    "transition": "margin .3s",
                    "margin-left": "6vw",
                };
                $scope.sidestyle = {
                    "width": "3.5vw",
                    "transition": "width .3s",
                };

                $scope.sidebarcontoptionsstyle = {
                    "display": "block"
                };
                $scope.sidebarcontoptions = {
                    "display": "block"
                };
            } else {
                $scope.footerstate = 0;
                $scope.showcontrol = 1;
                $scope.$broadcast('eventBroadcastedName');
                $scope.topbartopstyle = {
                    "transform": "rotate(45deg)",
                    "transform-origin": "-11% 80%",
                };
                $scope.topbarmiddlestyle = {
                    "opacity": "0",
                };
                $scope.topbarbottomstyle = {
                    "transform": "rotate(-45deg)",
                    "transform-origin": "0% 50%",
                };
                $scope.sidestyle = {
                    "width": "12vw"
                };
                $scope.mainstyle = {

                    "width": "calc(100% - 12vw)",
                    "right": "0",
                    "margin-left": "14vw"

                };
                $scope.sibarcontstyle = {
                    "display": "block"
                };
                $scope.sibarfooterstyle = {
                    "width": "12vw",
                    "margin-left": "0px",
                    "display": "block"

                };
                $scope.sidebarcontoptionsstyle = {
                    "display": "none"
                };
                $scope.sidebarcontoptions = {
                    "display": "none"
                };
            }
        }
    }]);

app.directive('customOnChange', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var onChangeFunc = scope.$eval(attrs.customOnChange);
            element.bind('change', onChangeFunc);
        }
    };
});

app.config(['$routeProvider',

    function($routeProvider) {
        $routeProvider.

        when("/", {
            templateUrl: './AdminComponents/AdminHome.blade.php',
            controller: 'AdminHome'
        }).
        when("/AllCustomers", {
            templateUrl: './AdminComponents/AllCustomer.blade.php',
            controller: 'allCustomers'
        }).
        when("/AllAdministrator", {
            templateUrl: './AdminComponents/AllAdministrator.blade.php',
            controller: 'AllAdministrator'
        }).
        when("/AllPackages", {
            templateUrl: './AdminComponents/NewPackage.blade.php',
            controller: 'NewPackage'
        }).
        when("/AllOperators", {
            templateUrl: './AdminComponents/AllOperators.blade.php',
            controller: 'AllOperators'
        }).
        when("/AllTemplates", {
            templateUrl: './AdminComponents/AllTemplates.blade.php',
            controller: 'AllTemplates'
        }).
        when("/InternalTemplate", {
            templateUrl: './AdminComponents/InternalTemplate.blade.php',
            controller: 'InternalTemplate'
        }).
        when("/AllVendors", {
            templateUrl: './AdminComponents/AllVendors.blade.php',
            controller: 'AllVendors'
        }).
        when("/AllAgents", {
            templateUrl: './AdminComponents/AllAgents.blade.php',
            controller: 'AllAgents'
        }).
        when("/Inventory", {
                templateUrl: './AdminComponents/Inventory.blade.php',
                controller: 'Inventory'
            })
            .
        when("/Form", {
                templateUrl: './AdminComponents/Form.blade.php',
                controller: 'Form'
            })
            .
        when("/testonline", {
            template: `
            
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">

                    @php $users = DB::table('users')->get(); @endphp

                    <div class="container">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
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
            </div>
        </div>
    </div>

        `,
            controller: 'Inventory'
        });


    }
]);
app.run(function($rootScope) {
    $rootScope.color = 'blue';
});