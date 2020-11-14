app.controller('Documentation', function($scope, $filter, $http, $interval, $rootScope) {

    var initload = function() {
        var PipelineData = {
            sequence: global_sequence
        };
        $http.post('/Latitude/public/admin/customer/documentation/init', JSON.stringify(PipelineData)).then(function(response) {
            //console.log(response.data);
            if (response.data) {
                $scope.sites = response.data['sites'];
                $scope.items = response.data['confi'];
                $scope.customers = response.data['customers'];
                $scope.documents = response.data['documents'];
                adminside.Document.dropdown_fields.Type.option = []
                $scope.items.forEach(element => {;
                    adminside.Document.dropdown_fields.Type.options.push(element.field_name);
                    // $scope.documents['dropdown_fields']['Type']['options'].push(element.field_name);
                });
                //console.log(adminside.Document.dropdown_fields)
                $scope.search();
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
    $scope.formFields = { "dropdown": {}, "file": {} };
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


    $scope.FinalSequence = function(item, modaltype, functiontype) {

        $scope.serverAlertHide();
        var iterate = 0;
        var modallength = 0;
        $scope.FuncType = functiontype;
        if (item != null) {
            // global_sequence = item.id;
            pageNum = $scope.currentPage;
        }
        $scope.addModalClass("CRUDModal");
        $scope.formFields.dropdown = {};
        $scope.formFields.file = {};
        $scope.modalbodyshow = {
            "height": "0px"
        };
        timer = $interval(function() {
            iterate++;
            if (iterate >= 1) { $scope.addModalHeight(modallength); };
            if (iterate >= 3) {
                $interval.cancel(timer);
                $scope.removeModalClass("CRUDModal");
            }
        }, 100);
        $scope.modaltype = modaltype;
        $scope.modal = true;
        switch (functiontype) {
            case 'New':
                $scope.modalheader = "Add New Document";
                $scope.modalbutton = "Add";
                console.log(adminside.Document.dropdown_fields)
                $scope.formFields.dropdown = adminside.Document.dropdown_fields;
                $scope.formFields.file = adminside.Document.file_fields;
                modallength = 250 + 'px';
                break;
            case 'Delete':
                adminside.Document.current.pre = item.id
                $scope.modalheader = "Delete Document";
                $scope.modalbutton = "Delete";
                modallength = 30 + 'px';
                break;


            default:
                // code block
                break;
        }
    }
    $scope.addModalClass = function(id) {
        document.getElementById(id).classList.add("open");
    };
    $scope.addModalHeight = function(hei) {
        $scope.modalbodyshow = {
            "height": hei
        };
    };
    $scope.removeModalClass = function(id) {
        if (document.getElementById(id).classList.contains("open")) {
            document.getElementById(id).classList.remove("open");
        }

    };
    $scope.serverAlertShow = function($message) {
        $scope.serverMessage = $message;
        $scope.alertbox = {
            'display': "block",

        };
        $scope.flex_containerstyle = {
            "height": "440px",
        };
        $scope.custcardsecondstyle = {
            "height": "460px",
        };
    };
    $scope.serverAlertHide = function() {
        $scope.alertbox = {
            'display': "none"
        };
        $scope.flex_containerstyle = {
            "height": "460px"
        };
        $scope.custcardsecondstyle = {
            "height": "480px",
        };
    };

    ////////////////////////////////////////////////////////////////////////////////

    $scope.ModalRequest = function() {
        $scope.$parent.Loadingstyle = true;
        var Req_Url = '/Latitude/public/admin/customer/documentation/crud';
        //console.log(adminside);
        var Pipeline_Data = {
            sequence: global_sequence,
            data: adminside,
            type: $scope.FuncType
        };

        $scope.TablePostCall(Req_Url, Pipeline_Data);
        $scope.$parent.Loadingstyle = false;


    };
    $scope.TablePostCall = function(Req_Url, Pipeline_Data) {
        $http.post(Req_Url, JSON.stringify(Pipeline_Data)).then(function(response) {
            if (response.data && !response.data['err']) {
                $scope.serverAlertShow('Successful.');
                $scope.$parent.Loadingstyle = false;
                var users = response.data['users'];
                var customers = [];
                var administrators = [];
                var operators = [];
                var agents = [];
                for (var i = 0; i < users.length; i++) {
                    if (users.role == "Customer") {
                        customers.push(users[i])
                    } else if (users.role == "Administrator") {
                        administrators.push(users[i])
                    } else if (users[i].role == "Operator") {
                        operators.push(users[i])
                    } else if (users[i].role == "Agent") {
                        agents.push(users[i])
                    }

                }
                $scope.items = response.data['confi'];
                $scope.customers = response.data['customers'];
                $scope.modalAdministrators = administrators;
                $scope.modalOperators = operators;
                $scope.modalAgents = agents;
                $scope.currentPage = pageNum;
                $scope.search();

            } else if (response.data['err'] == "404") {
                $scope.serverAlertShow('Ambiguous Response from the server.');
            } else {
                $scope.serverAlertShow('Server Didnot Respond.');
            }

        }, function(response) {
            $scope.alertmessage = "Server Error!!!.";
            $scope.serverAlertShow('Out of bound Response.');
        });
    };
    $scope.uploadFile = function() {
        $scope.$parent.Loadingstyle = true;
        var New = "New";
        var file = event.target.files[0];
        var Req_Url = '/Latitude/public/admin/customer/documentation/crud';
        const formData = new FormData();
        formData.append('file', file);
        formData.append('type', $scope.FuncType);
        formData.append('sequence', global_sequence);
        formData.append('data', global_sequence);
        formData.append('field_name', adminside.Document.dropdown_fields.Type.value);
        formData.append('ftype', adminside.Document.dropdown_fields.Media.value);
        formData.append('site_id', $scope.currentSite);
        formData.append('data', global_sequence);
        console.log(adminside)
        $http.post(Req_Url, formData, { headers: { 'Content-Type': undefined } }).then(function(response) {
            if (response.data && !response.data['err']) {
                console.log(response.data);
                $scope.alertmessage = "Success";
                $scope.alertboxjs = {
                    'display': "block",
                    'background': "lightgray",
                    'color': "black"
                };
                $scope.items = response.data['confi'];
                $scope.customers = response.data['customers'];
                $scope.documents = response.data['documents'];
                adminside.Document.dropdown_fields.Type.option = []
                $scope.items.forEach(element => {;
                    adminside.Document.dropdown_fields.Type.options.push(element.field_name);
                    // $scope.documents['dropdown_fields']['Type']['options'].push(element.field_name);
                });
                $scope.search();
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
    $scope.FormCustomer = function(value, name) {
            if (name == 'CustomerName') {
                $scope.currCustomer = JSON.parse(value);
                global_sequence = $scope.currCustomer.id;
                initload();
            }
            if (name == 'InitName') {
                //$scope.currCustomer = value;
                //global_sequence = $scope.currCustomer.id;
            } else {


            }
        }
        ////////
    $scope.search();
    initload();
});