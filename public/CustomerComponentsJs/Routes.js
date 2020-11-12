var app = angular.module('myApp', ["ngRoute", "chart.js", 'isteven-multi-select'], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    })
    .controller('customermainbody', ['$scope', function($scope, $rootScope) {

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
        $scope.$on("SendUp", function(evt, data) {
            $scope.isShowHide('1');
        });
        $scope.isShowHide = function(state) {

            if (state == 1) {
                console.log('first state');
                $scope.showcontrol = 0;
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
                    "width": "12vw",
                    "margin-left": "0px",
                    "bottom": "0",
                    "transition": "width .3s",
                };
                $scope.sibarcontstyle = {
                    "display": "block"
                };
                $scope.sibarfooterstyle = {
                    "width": "100%",
                    "margin-left": "6px",
                    "display": "block"

                };
                $scope.chartsinfostyle = {
                    "width": "calc (88vw)",
                    "margin-left": "12vw",
                    "transition": "margin .3s",
                    "display": "block"
                }

            } else {
                $scope.showcontrol = 1;
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
                $scope.sidestyle = {

                    "margin-left": "-250px",
                    "transition": "width .3s",
                };

                $scope.sidebarcontoptionsstyle = {
                    "display": "block"
                };
                $scope.chartsinfostyle = {
                    "width": "100% ",
                    "margin-left": "0",
                    "transition": "margin .3s",
                    "display": "block"
                }
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
            templateUrl: './CustomerComponents/CustomerHome.blade.php',
            controller: 'CustomerHomePage'
        }).when("/CustomerHome2", {
            templateUrl: './CustomerComponents/CustomerHome2.blade.php',
            controller: 'CustomerHomePage'
        }).when("/CustomerHome3", {
            templateUrl: './CustomerComponents/CustomerHome3.blade.php',
            controller: 'CustomerHomePage3'
        });
    }
]);
app.run(function($rootScope) {
    $rootScope.color = 'blue';
});