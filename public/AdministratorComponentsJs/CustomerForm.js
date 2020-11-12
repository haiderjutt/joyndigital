app.controller('CustomerForm', function($scope, $filter, $http, $interval) {
    $scope.inputform = {};
    $scope.latitude = '';
    $scope.longitude = '';
    $scope.currCustomer = {};
    $scope.currSite = {};
    var aa;
    var initload = function() {
        $scope.$emit("SendUp", '1');
    };
    $scope.handleAction = function(text) {

        if (aa != '') {
            alert(text);
            aa = '';
        } else {
            alert('aa');
            aa = text;
        }

    };
    var initload1 = function() {
        $scope.lat = '';
        $scope.long = '';
        var PipelineData = {
            sequence: global_sequence,
        };
        $http.post('/Latitude/public/administrator/assigned/customer/form/init', JSON.stringify(PipelineData)).then(function(response) {
            if (response.data['fields']) {
                console.log(response.data);
                var whole = response.data['fields'];
                $scope.sites = response.data['sites'];

                for (var i = 0; i < whole["Input"].length; i++) {
                    whole['Input'][i]['value'] = '';
                }
                //console.log($scope.inputitems);
                for (var i = 0; i < whole["Date"].length; i++) {
                    whole['Date'][i]['value'] = '';
                }
                for (var i = 0; i < whole["Dropdown"].length; i++) {
                    whole['Dropdown'][i]['value'] = '';
                }
                for (var i = 0; i < whole["Controlled"].length; i++) {
                    whole['Controlled'][i]['value'] = '';
                }
                for (var i = 0; i < whole["Range"].length; i++) {
                    whole['Range'][i]['value'] = '';
                }
                operatorside.form = whole;
                $scope.inputform = operatorside;
            }
            $scope.customers = response.data['customers'];
            operatorside.form['upd'] = '0';
            var current = $filter('filter')(response.data['customers'], { id: global_sequence })[0];
            $scope.FormCustomer(current, 'InitName');
            // console.log()
        });
    };
    $scope.labels = ["Download Sales", "In-Store Sales", "Mail-Order Sales", "Tele Sales", "Corporate Sales"];
    $scope.data = [5, 5, 5, 5, 5];

    $scope.labelsss = ["Customers", "Operators", "Agents", "Admin"];
    $scope.seriesss = ['Series A', 'Series B'];
    $scope.dataaa = [
        [100, 100, 100, 100],
        [5, 15, 5, 1],
    ];
    $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }, { yAxisID: 'y-axis-2' }];
    $scope.optionsss = {
        scales: {
            yAxes: [{
                    id: 'y-axis-1',
                    type: 'linear',
                    display: true,
                    position: 'left'
                },
                {
                    id: 'y-axis-2',
                    type: 'linear',
                    display: true,
                    position: 'right'
                }
            ]
        },
        legend: {
            labels: {
                // This more specific font property overrides the global property
                fontColor: 'black'
            }
        }
    };
    ////////map//////////////////
    var marker = null;

    var googleMapOption = {
        zoom: 5,
        center: new google.maps.LatLng(31, 71),
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        styles: [
            { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
            {
                elementType: "labels.text.stroke",
                stylers: [{ color: "#242f3e" }],
            },
            {
                elementType: "labels.text.fill",
                stylers: [{ color: "#ffffff" }],
            },
            {
                featureType: "administrative.locality",
                elementType: "labels.text.fill",
                stylers: [{ color: "#ffffff" }],
            },
            {
                featureType: "poi",
                elementType: "labels.text.fill",
                stylers: [{ color: "#d59563" }],
            },
            {
                featureType: "poi.park",
                elementType: "geometry",
                stylers: [{ color: "#263c3f" }],
            },
            {
                featureType: "poi.park",
                elementType: "labels.text.fill",
                stylers: [{ color: "#ffffff" }],
            },
            {
                featureType: "road",
                elementType: "geometry",
                stylers: [{ color: "#ffffff" }],
            },
            {
                featureType: "road",
                elementType: "geometry.stroke",
                stylers: [{ color: "#ffffff" }],
            },
            {
                featureType: "road",
                elementType: "labels.text.fill",
                stylers: [{ color: "#ffffff" }],
            },
            {
                featureType: "road.highway",
                elementType: "geometry",
                stylers: [{ color: "#746855" }],
            },
            {
                featureType: "road.highway",
                elementType: "geometry.stroke",
                stylers: [{ color: "#ffffff" }],
            },
            {
                featureType: "road.highway",
                elementType: "labels.text.fill",
                stylers: [{ color: "#ffffff" }],
            },
            {
                featureType: "transit",
                elementType: "geometry",
                stylers: [{ color: "#2f3948" }],
            },
            {
                featureType: "transit.station",
                elementType: "labels.text.fill",
                stylers: [{ color: "#d59563" }],
            },
            {
                featureType: "water",
                elementType: "geometry",
                stylers: [{ color: "#00FFFF" }],
            },
            {
                featureType: "water",
                elementType: "labels.text.fill",
                stylers: [{ color: "#00FFFF" }],
            },
            {
                featureType: "water",
                elementType: "labels.text.stroke",
                stylers: [{ color: "#00FFFF" }],
            },
        ]
    };
    var map = new google.maps.Map(document.getElementById('googleMap'), googleMapOption);
    let infoWindow = new google.maps.InfoWindow({
        content: "click on map for location",
        position: new google.maps.LatLng(31, 71),
    });

    $scope.gMap = map;
    google.maps.event.addListener(map, 'click', function(event) {
        addMarker(event.latLng);
    });
    let input = document.getElementById("pac-input");
    let searchBox = new google.maps.places.SearchBox(input);
    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });
    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }
        const bounds = new google.maps.LatLngBounds();
        places.forEach((place) => {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            marker.setPosition(place.geometry.location);
            map.setCenter(place.geometry.location);


        });

    });

    function addMarker(location) {
        infoWindow.close();
        infoWindow = new google.maps.InfoWindow({
            position: location,
        });
        infoWindow.setContent(
            JSON.stringify(location.toJSON(), null, 2)
        );
        infoWindow.open(map);
    }
    $scope.markerposition = function() {
        if ($scope.lat != null && $scope.long != null) {
            position = new google.maps.LatLng($scope.lat, $scope.long);
            if (marker == undefined) {
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    center: new google.maps.LatLng($scope.lat, $scope.long),
                });
            } else {
                marker.setPosition(position);
                map.setCenter(position);
            }
        }
    }
    $scope.windowposition = function() {
        if ($scope.maplat != null && $scope.maplong != null) {
            position = new google.maps.LatLng($scope.maplat, $scope.maplong);
            infoWindow.close();
            infoWindow = new google.maps.InfoWindow({
                position: position,
            });
            infoWindow.setContent(
                JSON.stringify(position.toJSON(), null, 2)
            );
            map.setCenter(position);
            infoWindow.open(map);
        }
    }
    $scope.$on('eventBroadcastedName', function() {
        if ($scope.footerstate) {
            console.log("formdata");
            $scope.customerformstyle = {
                "width": "100%",
            };
            $scope.leftsidestyle = {
                "width": "50%",

            };
            $scope.leftsideonestyle = {
                "width": "90%",
            };

            $scope.rightsidestyle = {
                "width": "50%",

            };
            $scope.rightsidestylemap = {
                "width": "100%"
            }
            $scope.formfooterstyle = {
                "width": "calc(100% - 8vw)",
            }
        } else {
            console.log("changed")
            $scope.customerformstyle = {
                "width": "95%",
            };
            $scope.leftsidestyle = {
                "width": "50%",
                "margin-left": "-3vw",
            };
            $scope.leftsideinputfieldstyle = {
                "width": "100%",
            };
            $scope.leftsideonestyle = {
                "width": "100%",
            };
            $scope.leftsideone1style = {
                "width": "90%",
            };
            $scope.leftsidetopstyle1 = {
                "width": "95%",
            };
            $scope.leftsidetopstyle2 = {
                "width": "95%",
            }
            $scope.rightsidestyle = {
                "width": "50%",
            }
            $scope.rightsidestylemap = {
                "width": "100%",
            }
            $scope.formfooterstyle = {
                "width": "calc(100% - 14vw)",
            }
        }
    });

    $scope.FormData = function() {
        console.log(operatorside);
        var PipelineData = {
            sequence: global_sequence,
            data: operatorside,
            lat: $scope.lat,
            long: $scope.long
        };
        $http.post('/Latitude/public/administrator/assigned/customer/form/entry', JSON.stringify(PipelineData)).then(function(response) {
            console.log(response);
            if (response) {
                $scope.alertmessage = "Site entered Successfully";
                $scope.alertboxjs = {
                    'display': "block",
                    'background': "black",
                    'color': "white"
                };
            }
        });
        console.log(PipelineData)
        initload1();
    }
    $scope.FormCustomer = function(value, name) {
        if (name == 'CustomerName') {
            $scope.currCustomer = JSON.parse(value);
            global_sequence = $scope.currCustomer.id;
            initload1();
        }
        if (name == 'InitName') {
            $scope.currCustomer = value;
            global_sequence = $scope.currCustomer.id;
        } else {
            var site = JSON.parse(value);

            for (var i = 0; i < operatorside.form["Input"].length; i++) {
                operatorside.form['Input'][i]['value'] = site[operatorside.form['Input'][i]['field_name']];
            }
            for (var i = 0; i < operatorside.form["Date"].length; i++) {
                operatorside.form['Date'][i]['value'] = new Date(site[operatorside.form['Date'][i]['field_name']]);
            }
            for (var i = 0; i < operatorside.form["Dropdown"].length; i++) {
                operatorside.form['Dropdown'][i]['value'] = site[operatorside.form['Dropdown'][i]['field_name']];
            }
            for (var i = 0; i < operatorside.form["Controlled"].length; i++) {
                operatorside.form['Controlled'][i]['value'] = site[operatorside.form['Controlled'][i]['field_name']];
            }
            for (var i = 0; i < operatorside.form["Range"].length; i++) {
                operatorside.form['Range'][i]['value'] = parseFloat(site[operatorside.form['Range'][i]['field_name']]);

            }
            $scope.lat = site['latitude'];
            $scope.long = site['longitude'];
            $scope.markerposition();
            operatorside.form['upd'] = site['id'];
            console.log(operatorside.form)

        }
    }


    initload();
    initload1();
});