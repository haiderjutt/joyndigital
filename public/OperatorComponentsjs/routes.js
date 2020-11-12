var app = angular.module('myApp', ["ngRoute"], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
  })
  .controller('operatormainbody', ['$scope', function($scope) {


    }]);

    app.directive('customOnChange', function() {
        return {
          restrict: 'A',
          link: function (scope, element, attrs) {
            var onChangeFunc = scope.$eval(attrs.customOnChange);
            element.bind('change', onChangeFunc);
          }
        };
      });
      
  app.config(['$routeProvider',

    function($routeProvider){
    $routeProvider.
    
    when("/", {
        templateUrl: './OperatorComponents/Customerslist.blade.php',
        controller: 'Customerslist'
    }). 
    when("/customersform", {
        templateUrl: './OperatorComponents/Cutomersform.blade.php',
        controller: 'Form'
    });
  }]);