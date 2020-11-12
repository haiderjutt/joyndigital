app.controller('NewPackage', function($scope, $filter, $http, $interval) {
    ///////////initial Data Loading /////////////////////
    var initload = function() {
        var PipelineData = {
            sequence: 'joynDigital'
        };
        $http.post('/Latitude/public/admin/package/init', JSON.stringify(PipelineData)).then(function(response) {
            //console.log(response.data);
            if (response.data) {
                $scope.items = response.data['packages'];
                var customers = [];
                for (var i = 0; i < response.data['users'].length; i++) {
                    customers.push(response.data['users'][i]);
                }
                $scope.modalCustomers = customers;
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
    $scope.formFields = { "text": {}, "dropdown": {}, "assignment": {} };
    $scope.items = [];
    var pageNum = 0;
    $scope.myValue = 5;
    $scope.gap = 5;
    $scope.filteredItems = [];
    $scope.groupedItems = [];
    $scope.itemsPerPage = 5;
    $scope.pagedItems = [];
    $scope.currentPage = 0;
    $scope.sort = {
        sortingOrder: 'id',
        reverse: false
    };
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
    $scope.customerdemo = function(item) {
        if (!item) { return; }
        var final = JSON.parse(item);

        final.avatar = './avatars/' + final.avatar;
        $scope.newassign = final;
        adminside.Package.current.config.new.id = final.id;
        // adminside.Allocation.workerdetails.New.worker.id = global_sequence;
    };
    $scope.FinalSequence = function(item, modaltype, functiontype) {
        $scope.serverAlertHide();
        var iterate = 0;
        var modallength = 0;
        $scope.FuncType = functiontype;
        if (item != null) {
            global_sequence = item.id;
            pageNum = $scope.currentPage;
        }
        $scope.addModalClass("CRUDModal");
        $scope.formFields.text = {};
        $scope.formFields.dropdown = {};
        $scope.formFields.assignment = {};
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
            case 'NewPackage':
                document.getElementById("CRUDModal").classList.add("CRUDModalP");
                $scope.modalheader = "Create New Package";
                $scope.modalbutton = "Create";
                adminside.Package.text_fields.Name.value = '';
                adminside.Package.text_fields.Cost.value = '0';
                adminside.Package.text_fields.CostLetters.value = '';
                adminside.Package.dropdown_fields.package_type.value = 'Monthly';
                adminside.Package.dropdown_fields.sites_num.value = '0';
                adminside.Package.dropdown_fields.administrators_num.value = '0';
                adminside.Package.dropdown_fields.operators_num.value = '0';
                adminside.Package.dropdown_fields.agents_num.value = '0';
                $scope.formFields.text = adminside.Package.text_fields;
                $scope.formFields.dropdown = adminside.Package.dropdown_fields;
                modallength = 350 + 'px';

                break;
            case 'UpdatePackage':
                document.getElementById("CRUDModal").classList.add("CRUDModalP");
                adminside.Package.text_fields.Name.value = item.name;
                adminside.Package.text_fields.Cost.value = item.cost;
                adminside.Package.text_fields.CostLetters.value = item.cost_in_letters;
                adminside.Package.dropdown_fields.package_type.value = item.package_type;
                adminside.Package.dropdown_fields.sites_num.value = item.sites_num;
                adminside.Package.dropdown_fields.administrators_num.value = item.administrators_num;
                adminside.Package.dropdown_fields.operators_num.value = item.operators_num;
                adminside.Package.dropdown_fields.agents_num.value = item.agents_num;
                $scope.modalheader = "Update Package";
                $scope.modalbutton = "Update";
                $scope.formFields.text = adminside.Package.text_fields;
                $scope.formFields.dropdown = adminside.Package.dropdown_fields;
                modallength = 400 + 'px';
                break;
            case 'DeletePackage':
                document.getElementById("CRUDModal").classList.remove("CRUDModalP");
                $scope.modalheader = "Delete Package";
                $scope.modalbutton = "Delete";
                modallength = 30 + 'px';
                break;
            case 'AssignPackage':
                adminside.Package.current.config.assigned = {};
                document.getElementById("CRUDModal").classList.remove("CRUDModalP");
                $scope.modalheader = "Package Allocation";
                $scope.modalbutton = "Assign";
                for (var i = 0; i < $scope.modalCustomers.length; i++) {
                    if ($scope.modalCustomers[i].package_id == global_sequence) {
                        adminside.Package.current.config.assigned[i] = $scope.modalCustomers[i];
                    }
                }
                adminside.Package.current.config.details.Name = item.name;
                adminside.Package.current.config.details.Cost = item.cost;
                adminside.Package.current.config.details.sites_num = item.sites_num;
                adminside.Package.current.config.details.administrators_num = item.administrators_num;
                adminside.Package.current.config.details.operators_num = item.operators_num;
                adminside.Package.current.config.details.agents_num = item.agents_num;
                $scope.formFields.assignment = adminside.Package.current;
                modallength = 500 + 'px';
                break;
            case 'CreateUser':
                document.getElementById("CRUDModal").classList.remove("CRUDModalP");
                $scope.modalheader = "Register New User";
                $scope.modalbutton = "Register";
                $scope.formFields.text = adminside.Register.text_fields;
                $scope.formFields.dropdown = adminside.Register.dropdown_fields;
                $scope.formFields.file = adminside.Register.file_fields;
                modallength = 450 + 'px';
                break;
            default:
                // code block
                break;
        }
    };
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
            'display': "block"
        };
    };
    $scope.serverAlertHide = function() {
        $scope.alertbox = {
            'display': "none"
        };
    };

    ////////////////
    $scope.ModalRequest = function() {
        var Req_Url = '/Latitude/public/admin/package/crud';
        console.log(adminside);
        var Pipeline_Data = {
            sequence: global_sequence,
            data: adminside,
            type: $scope.FuncType
        };

        $scope.TablePostCall1(Req_Url, Pipeline_Data);

    };
    $scope.TablePostCall1 = function(Req_Url, Pipeline_Data) {
        $http.post(Req_Url, JSON.stringify(Pipeline_Data)).then(function(response) {
            //console.log(response.data);
            if (response.data && !response.data['err']) {
                $scope.items = response.data['packages'];
                var customers = [];
                for (var i = 0; i < response.data['users'].length; i++) {
                    customers.push(response.data['users'][i]);
                }
                $scope.modalCustomers = customers;
                for (var i = 0; i < $scope.modalCustomers.length; i++) {
                    if ($scope.modalCustomers[i].package_id == global_sequence) {
                        adminside.Package.current.config.assigned[i] = $scope.modalCustomers[i];
                    }
                }

                $scope.search();
                $scope.currentPage = pageNum;
                $scope.serverAlertShow('Successful.');
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
    ////////
    $scope.GlobalSequenceNew = function(sequence, ban) {
        $scope.packageName = "";
        $scope.sitesNum = "0";
        $scope.adminsNum = "0";
        $scope.operatorsNum = "0";
        $scope.agentsNum = "0";
        $scope.vendorsNum = "0";
        $scope.Type = "Monthly";
        $scope.Cost = 0;
        $scope.CostLetters = "";
    };
    /////////
    $scope.Delete = function() {
        var Req_Url = '/Latitude/public/admin/package/delete';
        var Success_Message = "Deleted Successfully.";
        var Fail_Message = "A problem was detected while deleting.";
        var Pipeline_Data = {
            sequence: global_sequence
        };
        $scope.TablePostCall(Req_Url, Pipeline_Data, Success_Message, Fail_Message);
    };
    ////////
    $scope.NewPackage = function() {
        var Req_Url = '/Latitude/public/admin/package/new';
        var Success_Message = "New Package Added Successfully.";
        var Fail_Message = "A problem was detected while creating the Package.";
        var Pipeline_Data = {
            sequence: '0',
            name: $scope.packageName,
            sitesNum: $scope.sitesNum,
            adminsNum: $scope.adminsNum,
            operatorsNum: $scope.operatorsNum,
            agentsNum: $scope.agentsNum,
            vendorsNum: $scope.vendorsNum,
            Type: $scope.Type,
            Cost: $scope.Cost,
            CostLetters: $scope.CostLetters
        };
        if ($scope.packageName != '' && $scope.sitesNum != '' && $scope.adminsNum != '' && $scope.operatorsNum != '' && $scope.Type != '' && $scope.agentsNum != null && $scope.vendorsNum != null) {
            $scope.TablePostCall(Req_Url, Pipeline_Data, Success_Message, Fail_Message);
        } else {
            $scope.alertmessage = "Operation Failed! Please fill all the fields.";
            $scope.alertboxjs = {
                'display': "block",
                'background': "red",
                'color': "white"
            };
        }

    };

    ////////
    $scope.PackageUpdate = function() {
        var Req_Url = '/Latitude/public/admin/package/update';
        var Success_Message = "Package Details Changed Successfully.";
        var Fail_Message = "A problem was detected while changing Package Details.";
        var Pipeline_Data = {
            sequence: global_sequence,
            name: $scope.editPackageName,
            sitesNum: $scope.editSitesNum,
            adminsNum: $scope.editAdminsNum,
            operatorsNum: $scope.editOperatorsNum,
            agentsNum: $scope.editAgentsNum,
            vendorsNum: $scope.editVendorsNum,
            editType: $scope.editType,
            editCost: $scope.editCost,
            editCostLetters: $scope.editCostLetters,

        };
        if ($scope.editPackageName != '' && $scope.editAdminsNum != '' && $scope.editOperatorsNum != '' && $scope.editType != '' && $scope.editAgentsNum != '' && $scope.editVendorsNum != '') {
            $scope.TablePostCall(Req_Url, Pipeline_Data, Success_Message, Fail_Message);
        } else {
            $scope.alertmessage = "Operation Failed! Please fill all the fields.";
            $scope.alertboxjs = {
                'display': "block",
                'background': "red",
                'color': "white"
            };
        }
    };

    ////////
    $scope.TablePostCall = function(Req_Url, Pipeline_Data, Success_Message, Fail_Message) {
        $http.post(Req_Url, JSON.stringify(Pipeline_Data)).then(function(response) {
            //console.log(response);
            if (response.data && !response.data['err']) {
                $scope.alertmessage = Success_Message;
                $scope.alertboxjs = {
                    'display': "block",
                    'background': "lightgray",
                    'color': "black"
                };
                $scope.items = response.data;

                $scope.search();
                $scope.currentPage = pageNum;
            } else if (response.data['err'] == "404") {
                //console.log();
                $scope.alertmessage = response.data['message'];
                $scope.alertboxjs = {
                    'display': "block",
                    'background': "black",
                    'color': "white"
                };
            } else {
                $scope.alertmessage = Fail_Message;
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
    $scope.search();
    initload();
});