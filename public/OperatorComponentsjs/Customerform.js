app.controller('Form', function ($scope, $filter, $http, $interval) {
    $scope.inputform = {};
    var initload=function(){
        var PipelineData = {
            sequence: "4",
            };
            $http.post('/Latitude/public/admin/customer/fields', JSON.stringify(PipelineData)).then(function (response) {
            var whole = response.data;
            whole['Input'][0]['value'] = '1111';
            for(var i=0;i<whole["Input"].length; i++){
                whole['Input'][i]['value'] = '';
            }
            //console.log($scope.inputitems);
            for(var i=0;i<whole["Date"].length; i++){
                whole['Date'][i]['value'] = '';
            }
            for(var i=0;i<whole["Dropdown"].length; i++){
                whole['Dropdown'][i]['value'] = '';
            }
            //console.log( $scope.dropdownitems);
            operatorside.form = whole;
            $scope.inputform = operatorside;
            console.log( $scope.inputform['form']);
            $interval( function(){ $scope.valuechecking(); }, 5000);
        });
    };
    ////////map//////////////////
    $scope.valuechecking=function(){
        // alert( $scope.dropdownitems[1].model);

    }
    var marker = null;
    
    var googleMapOption = {
        zoom: 5,
        center: new google.maps.LatLng(31, 71),
        mapTypeId: google.maps.MapTypeId.TERRAIN
      };
      var map=new google.maps.Map(document.getElementById('googleMap'), googleMapOption);
      $scope.gMap = map;
      google.maps.event.addListener(map, 'click', function( event ){
          $scope.latlong(event.latLng.lng(), event.latLng.lat())
          addMarker(event.latLng); 
        });
      function addMarker(location) {  
        if(marker==undefined){
            marker = new google.maps.Marker({  
                position: location,  
                map: map  
              }); 
        }
        else{
            marker.setPosition(location);
        }
            
        }
        $scope.latlong=function(latitude,longitude){
            $scope.latitude=latitude;
            $scope.longitude=longitude;

        }

    initload();
  });