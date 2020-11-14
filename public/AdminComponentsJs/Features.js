app.controller('Features', function($scope, $filter, $http, $interval) {

    ///////////initial Data Loading /////////////////////
    var initload = function() {
        var PipelineData = {
            sequence: global_sequence
        };
        $http.post('/Latitude/public/admin/customer/feature/init', JSON.stringify(PipelineData)).then(function(response) {
            //console.log(response.data);
            if (response.data) {
                var users = response.data['users'];
                var customers = [];
                var administrators = [];
                var operators = [];
                var agents = [];
                for (var i = 0; i < users.length; i++) {
                    if (users[i].role == "Customer") {
                        customers.push(users[i])
                    } else if (users[i].role == "Administrator") {
                        administrators.push(users[i])
                    } else if (users[i].role == "Operator") {
                        operators.push(users[i])
                    } else if (users[i].role == "Agent") {
                        agents.push(users[i])
                    }
                }
                $scope.items = response.data['features'];
                $scope.customers = response.data['customers'];
                $scope.modalAdministrators = administrators;
                $scope.modalOperators = operators;
                $scope.modalAgents = agents;
                $scope.search();
                if (global_sequence) {
                    for (var i = 0; i < response.data['customers'].length; i++) {
                        if (response.data['customers'][i].id == global_sequence) {
                            $scope.currentCustomer = response.data['customers'][i]["username"];
                            console.log($scope.currentCustomer)
                        }
                    }
                }

            } else {
                $scope.alertmessage = "Something Wrong went with the table.";
                $scope.alertboxjs = {
                    'display': "block",
                    'background': "black",
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


    };


    //////////////////////Variable Defination ///////////////////////
    $scope.packName = "None";

    $scope.items = [];
    var pageNum = 0;
    $scope.myValue = 5;
    $scope.gap = 5;
    $scope.filteredItems = [];
    $scope.groupedItems = [];
    $scope.itemsPerPage = 5;
    $scope.pagedItems = [];
    $scope.currentPage = 0;
    $scope.formFields = { "text": {}, "dropdown": {}, "file": {}, "allocation": {}, "callocation": {} };
    $scope.modal = true;
    $scope.FuncType = "";
    $scope.sort = {
        sortingOrder: 'id',
        reverse: false
    };
    $scope.serverMessage = 'none';
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////// Table Functions /////////////////////////////////

    $scope.hidealert = function() {
        $scope.alertboxjs = {
            'display': "none"
        };
    };
    ////////
    $scope.myFunc = function() {
        $scope.itemsPerPage = $scope.myValue;
        $scope.search();
    };
    ////////
    var searchMatch = function(haystack, needle) {
        if (!needle) {
            return true;
        }
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
    };

    ////////
    $scope.search = function() {
        $scope.filteredItems = $filter('filter')($scope.items, function(item) {
            for (var attr in item) {
                if (searchMatch(item[attr], $scope.query))
                    return true;
            }
            return false;
        });
        // take care of the sorting order
        if ($scope.sort.sortingOrder !== '') {
            $scope.filteredItems = $filter('orderBy')($scope.filteredItems, $scope.sort.sortingOrder, $scope.sort.reverse);
        }
        $scope.currentPage = 0;
        // now group by pages
        $scope.groupToPages();
    };
    ////////////
    $scope.groupToPages = function() {
        $scope.pagedItems = [];
        for (var i = 0; i < $scope.filteredItems.length; i++) {
            if (i % $scope.itemsPerPage === 0) {
                $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)] = [$scope.filteredItems[i]];
            } else {
                $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)].push($scope.filteredItems[i]);
            }
        }
    };
    ////////////
    $scope.range = function(size, start, end) {
        var ret = [];
        // console.log(size,start, end);
        if (size < end) {
            end = size;
            start = 0;
        }
        for (var i = start; i < end; i++) {
            ret.push(i);
        }
        //console.log(ret);        
        return ret;
    };
    ////////////
    $scope.prevPage = function() {
        if ($scope.currentPage > 0) {
            $scope.currentPage--;
        }
    };
    ///////////////
    $scope.nextPage = function() {
        if ($scope.currentPage < $scope.pagedItems.length - 1) {
            $scope.currentPage++;
        }
    };
    //////////////
    $scope.setPage = function() {
        $scope.currentPage = this.n;
    };
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //My Functions
    ////////
    $scope.GlobalSequence = function(id) {
        global_sequence = id;
    };
    $scope.customerdemo = function(item, type) {
        if (!item) { return; }
        var final = JSON.parse(item);

        final.avatar = './avatars/' + final.avatar;
        $scope.newassign = final;
        if (type == "customer") {
            adminside.Allocation.workerdetails.New.customer.id = final.id;
            adminside.Allocation.workerdetails.New.worker.id = global_sequence;
        } else {
            adminside.CAllocation.customerdetails.New.customer.id = global_sequence;
            adminside.CAllocation.customerdetails.New.worker.id = final.id;
            adminside.CAllocation.customerdetails.New.worker.role = final.role;
        }

        console.log(adminside.Allocation)
    };
    $scope.tabchange = function(type) {
        switch (type) {
            case 'Administrator':
                $scope.modalWorkers = $scope.modalAdministrators;
                break;
            case 'Operator':
                $scope.modalWorkers = $scope.modalOperators;
                break;
            case 'Agent':
                $scope.modalWorkers = $scope.modalAgents;
                break;
            default:
                $scope.modalWorkers = $scope.modalAdministrators;
        }
    };


    $scope.FinalSequence = function(item) {



        adminside.Feature.current.pre = item;


    }




    $scope.uploadFile = function() {
        $scope.$parent.Loadingstyle = true;
        var file = event.target.files[0];
        var Req_Url = '/Latitude/public/admin/user/crud';
        const formData = new FormData();
        formData.append('file', file);
        formData.append('type', 'ProfilePicture');
        formData.append('sequence', global_sequence);
        formData.append('data', global_sequence);
        $http.post(Req_Url, formData, { headers: { 'Content-Type': undefined } }).then(function(response) {
            if (response.data && !response.data['err']) {
                $scope.alertmessage = "Success";
                $scope.alertboxjs = {
                    'display': "block",
                    'background': "lightgray",
                    'color': "black"
                };
                $scope.items = response.data;

                adminside.Update.file_fields.Avatar.value = './avatars/' + file.name;
                $scope.search();
                $scope.currentPage = pageNum;
            }
        });
        $scope.$parent.Loadingstyle = false;
        //$scope.$parent.balls = false;
    };

    $scope.$on('eventBroadcastedName', function() {
        if ($scope.footerstate) {
            console.log($scope.footerstate);
            $scope.pagefooterstyle = {
                "width": "calc(100% - 5vw)",
            }
        } else {
            console.log($scope.footerstate);
            $scope.pagefooterstyle = {
                "width": "calc(100% - 17vw)",
            }
        }
    });
    ////////
    $scope.valuechecking = function() {
        return true;
    };
    $scope.FeatureCustomer = function(value, name) {
            if (name == 'CustomerName') {
                $scope.currCustomer = JSON.parse(value);
                global_sequence = $scope.currCustomer.id;
                initload();
            }
        }
        ////////
    $scope.search();
    initload();
});