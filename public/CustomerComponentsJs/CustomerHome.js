    ///////////initial Data Loading /////////////////////  
    app.controller('CustomerHomePage', function($scope, $filter, $http, $interval, $rootScope) {

        const locations = [];
        var markers;
        // Add a marker clusterer to manage the markers.


        $scope.isShowHide = function(data) {
            $scope.$emit("SendUp", data);
        }
        var initload = function() {
            var PipelineData = {
                sequence: global_sequence,
            };
            $http.post('/Latitude/public/admin/customer/init', JSON.stringify(PipelineData)).then(function(response) {

                var temp = [];
                var temp2 = [];
                if (response.data) {
                    var marks = response.data['sites'];
                    marks.forEach(item => {
                        locations.push({ lat: parseFloat(item.latitude), lng: parseFloat(item.longitude), data: item });
                    });
                    $scope.clusterload();
                    // locations.forEach(myFunction);
                    var whole = response.data['fields'];
                    console.log(whole);
                    for (var i = 0; i < whole['Controlled'].length; i++) {
                        for (var j = 0; j < whole['Options'][whole['Controlled'][i]['field_name']].length; j++) {
                            whole['Options'][whole['Controlled'][i]['field_name']][j]['name'] = whole['Options'][whole['Controlled'][i]['field_name']][j]['field_name'];
                        }
                        whole['Controlled'][i]['option'] = whole['Options'][whole['Controlled'][i]['field_name']];
                        whole['Controlled'][i]['output'] = [];

                    }
                    for (var i = 0; i < whole['Input'].length; i++) {
                        temp2 = [];
                        temp = [];
                        for (var j = 0; j < whole['Option'][whole['Input'][i]['field_name']].length; j++) {
                            if (temp.includes(whole['Option'][whole['Input'][i]['field_name']][j][whole['Input'][i]['field_name']]) || whole['Option'][whole['Input'][i]['field_name']][j][whole['Input'][i]['field_name']] == null) {
                                delete whole['Option'][whole['Input'][i]['field_name']][j];
                            } else {
                                temp.push(whole['Option'][whole['Input'][i]['field_name']][j][whole['Input'][i]['field_name']]);
                                whole['Option'][whole['Input'][i]['field_name']][j]['name'] = whole['Option'][whole['Input'][i]['field_name']][j][whole['Input'][i]['field_name']];
                                temp2.push(whole['Option'][whole['Input'][i]['field_name']][j]);
                            }

                        }
                        whole['Input'][i]['option'] = temp2;
                        whole['Input'][i]['output'] = [];
                    }
                    for (var i = 0; i < whole['Dropdown'].length; i++) {
                        for (var j = 0; j < whole['Options'][whole['Dropdown'][i]['field_name']].length; j++) {
                            whole['Options'][whole['Dropdown'][i]['field_name']][j]['name'] = whole['Options'][whole['Dropdown'][i]['field_name']][j]['field_name'];

                        }
                        whole['Dropdown'][i]['option'] = whole['Options'][whole['Dropdown'][i]['field_name']];
                        whole['Dropdown'][i]['output'] = [];
                    }
                    whole['Current'] = [];
                    for (var i = 0; i < whole['Date'].length; i++) {
                        // for (var j = 0; j < whole['Options'][whole['Date'][i]['field_name']].length; j++) {
                        //     whole['Options'][whole['Date'][i]['field_name']][j]['name'] = whole['Options'][whole['Date'][i]['field_name']][j]['field_name'];
                        // }
                        whole['Date'][i]['to'] = [];
                        whole['Date'][i]['from'] = [];
                    }
                    for (var i = 0; i < whole['Range'].length; i++) {
                        // for (var j = 0; j < whole['Options'][whole['Date'][i]['field_name']].length; j++) {
                        //     whole['Options'][whole['Date'][i]['field_name']][j]['name'] = whole['Options'][whole['Date'][i]['field_name']][j]['field_name'];
                        // }
                        whole['Range'][i]['to'] = [];
                        whole['Range'][i]['from'] = [];
                    }
                    //console.log(response.data['fields']);
                    customer_fields.Basic.Controlled = whole['Controlled'];
                    customer_fields.Basic.Input = whole['Input'];
                    customer_fields.Basic.Dropdown = whole['Dropdown'];
                    customer_fields.Basic.Range = whole['Range'];
                    customer_fields.Basic.Date = whole['Date'];
                    customer_fields.Basic.Current = whole['Current'];
                    console.log("updated object");

                    $scope.items = customer_fields.Basic;
                    $scope.allSites = response.data['sites'];
                    console.log(customer_fields);

                } else {
                    alert(response.data);
                    $scope.alertmessage = "Proper Data Not Obtained. Check Server.";
                    $scope.alertboxjs = {
                        'display': "block",
                        'background': "darkred",
                        'color': "white"
                    };
                }
            }, function(response) {
                $scope.alertmessage = "Server Error!!!.";
                $scope.alertboxjs = {
                    'display': "block",
                    'background': "black",
                    'color': "white"
                };
            });
        }

        $scope.labels = ["Download Sales", "In-Store Sales", "Mail-Order Sales", "Tele Sales", "Corporate Sales"];
        $scope.data = [5, 5, 5, 5, 5];
        $scope.labelsss = ["Customers", "Operators", "Agents", "Admin", "Partner"];
        $scope.seriesss = ['Series A', 'Series B'];
        $scope.dataaa = [
            [100, 100, 100, 100, 100],
            [5, 15, 5, 1, 10],
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
        var marker = null;
        var googleMapOption = {
            zoom: 5,
            center: new google.maps.LatLng(31, 71),
            mapTypeId: google.maps.MapTypeId.TERRAIN,

            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                position: google.maps.ControlPosition.TOP_CENTER,
            },

            scaleControl: true,
            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
            },
            fullscreenControl: true,
            fullscreenControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
            },
            zoomControl: false,
            zoomControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
            },
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
        $scope.gMap = map;

        google.maps.event.addListener(map, 'click', function(event) {
            $scope.items['Current'][0] = {};
            addMarker(event.latLng);
            $scope.name = "name3";

            //markerinfo();
            console.log($scope.items);
            console.log($scope.name);

            $scope.items['Current'][0] = $scope.allSites[0];
        });
        var icon = {
            url: "http://maps.google.com/mapfiles/ms/icons/orange-dot.png", // url
            scaledSize: new google.maps.Size(50, 50), // size
        };

        function addMarker(location) {
            if (marker == undefined) {
                marker = new google.maps.Marker({
                    position: location,
                    icon: icon,
                    map: map
                });
            } else {
                marker.setPosition(location);

            }

        }

        $scope.markerinfo = function(id) {
            if (document.getElementById(id).classList.contains("close")) {
                document.getElementById(id).classList.remove("close");
            }
        }
        $scope.modernBrowsers = [{
                name: 'Opera',
                maker: 'Opera Software',
                ticked: false
            },
            {
                name: 'Internet Explorer',
                maker: 'Microsoft',
                ticked: false
            }
        ];
        $scope.clusterload = function() {
            markers = locations.map((location) => {

                var current = new google.maps.Marker({
                    position: location,
                });
                google.maps.event.addListener(current, 'click', function(event) {
                    //
                    //$scope.siteDetails = location.data;
                    $scope.$apply(showSiteData(location.data));
                    setMyColor('markerinfostyle');

                })
                return current;
            });
            new MarkerClusterer(map, markers, {
                imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
            });


        }

        function showSiteData(data) {
            $scope.name = "name2";
            customer_fields.Basic.Current[0] = data;
            $scope.items = customer_fields.Basic;
            //$scope.items['Current'] = customer_fields.Basic.Current;
            console.log($scope.items)
            $scope.name = "name1";
            // customer_fields.Basic.Current = data;
            // $scope.siteDetails = customer_fields.Basic.Current;
        }

        function setMyColor(id) {
            document.getElementById(id).classList.add("close");
        }
        initload();
        $scope.name = "name";
    });