app.controller('InternalTemplate', function($scope, $filter, $http, $interval) {
    var temp_id = "";
    $scope.formFields = { "text": {}, "dropdown": {} };
    var temp_data = "";
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
    $scope.setPage = function() {
        $scope.currentPage = this.n;
    };
    ///////////initial Data Loading /////////////////////
    var cardsload = function() {
        $scope.openPage();
        var PipelineData = {
            sequence: global_sequence
        };
        $http.post('/Latitude/public/administrator/assigned/customer/fields', JSON.stringify(PipelineData)).then(function(response) {
            $scope.card = response.data;
            $scope.customers = response.data['customers'];
            $scope.name = response.data['name'];
        });
        PipelineData = {};
        $http.post('/Latitude/public/admin/random/all', JSON.stringify(PipelineData)).then(function(response) {
            if (response.data) {
                var operators = [];
                var agents = [];
                for (var i = 0; i < response.data.length; i++) {
                    if (response.data[i].role == "Operator") {
                        operators.push(response.data[i])
                    } else if (response.data[i].role == "Agent") {
                        agents.push(response.data[i])
                    }

                }
                $scope.modalOperators = operators;
                $scope.modalAgents = agents;
                $scope.modalWorkers = $scope.modalOperators;
            }
        });
    };
    $scope.customerdemo = function(item, type) {
        var yoo = $scope.permname;
        if (!item) { return; }
        $scope.permname = yoo;

        var final = JSON.parse(item);

        final.avatar = './avatars/' + final.avatar;
        $scope.newassign = final;

        console.log(adminside.Allocation)
    };
    $scope.tabchange = function(type) {
        switch (type) {

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
    //alert(global_sequence);
    ////////
    $scope.AssignSequence = function(item, modaltype) {
        $scope.serverAlertHide();
        $scope.addModalClass("modalcontent2");
        $scope.formFields.callocation = {};
        $scope.modalheader = "Controlled Dropdown Permissions";
        $scope.modalbutton = "Assign";
        var iterate = 0;
        var modallength = 0;
        $scope.modalbodyshow = {
            "height": "0px"
        };
        timer = $interval(function() {
            console.log(iterate);
            iterate++;
            if (iterate >= 1) { $scope.addModalHeight(iterate + "00px"); };
            if (iterate >= 4) {
                $interval.cancel(timer);
                $scope.removeModalClass("modalcontent2");
            }
        }, 100);
        $scope.m_type = modaltype;
        $scope.modal = true;
        $scope.permname = item.field_name;


    };
    $scope.FinalSequence = function(item, modaltype, functiontype, fieldType) {
        if (adminside.CustomerField.type.field_type.value == 'Option') {
            $scope.optShow = false;
        } else {
            $scope.optShow = true;
        }
        $scope.serverAlertHide();
        var iterate = 0;
        var modallength = 0;
        $scope.FuncType = functiontype;
        if (item != null) {
            adminside.CustomerField.type.field_type.pre = item.id;
        }
        adminside.CustomerField.type.field_type.value = fieldType;
        $scope.addModalClass("CRUDModal");
        $scope.formFields.text = {};
        $scope.formFields.dropdown = {};
        $scope.formFields.allocation = {};
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
            case 'AddTextField':
                $scope.modalheader = "Add Field";
                $scope.modalbutton = "Add";
                adminside.CustomerField.text_fields.Name.value = "";
                $scope.formFields.text = adminside.CustomerField.text_fields;
                $scope.formFields.dropdown = adminside.CustomerField.dropdown_fields;
                modallength = 90 + 'px';
                break;
            case 'EditTextField':
                adminside.CustomerField.text_fields.Name.value = item.field_name;
                $scope.modalheader = "Update Field";
                $scope.modalbutton = "Update";
                $scope.formFields.text = adminside.CustomerField.text_fields;
                $scope.formFields.dropdown = adminside.CustomerField.dropdown_fields;
                modallength = 90 + 'px';
                break;
            case 'DeleteTextField':

                $scope.modalheader = "Delete Field";
                $scope.modalbutton = "Delete";
                modallength = 30 + 'px';
                break;
            case 'Perm':

                $scope.modalheader = "Controlled Dropdown Permissions";
                $scope.modalbutton = "Assign";
                modallength = 500 + 'px';
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
    $scope.Permstate = function(id, key) {
        if ($scope.card['Option'][$scope.permname][key]['perm'] == null) {
            var temp = [id];
            $scope.card['Option'][$scope.permname][key]['perm'] = temp;
        } else {
            var temp = $scope.card['Option'][$scope.permname][key]['perm'];
            console.log(temp)
            if (temp.indexOf(id) == -1) {
                temp.push(id);

            }
            $scope.card['Option'][$scope.permname][key]['perm'] = temp;
            console.log(temp)
            console.log($scope.card['Option'][$scope.permname][key]['perm'])

        }
        console.log($scope.card['Option'][$scope.permname][key])

    };
    ////////////////
    $scope.ModalRequest = function() {
        var Req_Url = '/Latitude/public/administrator/assigned/customer/fields/crud';
        console.log(adminside);
        var Pipeline_Data = {
            sequence: global_sequence,
            data: adminside,
            type: $scope.FuncType
        };

        $scope.TablePostCall1(Req_Url, Pipeline_Data);

    };
    $scope.ModalRequest2 = function() {
        var Req_Url = '/Latitude/public/administrator/assigned/customer/fields/perm';
        var Pipeline_Data = {
            sequence: global_sequence,
            perm: $scope.card['Option'][$scope.permname]
        };

        $scope.TablePostCall1(Req_Url, Pipeline_Data);
        console.log($scope.card['Option'][$scope.permname]);

    };
    $scope.TablePostCall1 = function(Req_Url, Pipeline_Data) {
        $http.post(Req_Url, JSON.stringify(Pipeline_Data)).then(function(response) {
            console.log(response.data);
            if (response.data && !response.data['err']) {
                $scope.card = response.data;
                $scope.alertmessage = 'success';
                $scope.alertboxjs = {
                    'display': "block",
                    'background': "black",
                    'color': "white"
                };

            } else if (response.data['err'] == "404") {
                $scope.alertmessage = response.data['message'];
                $scope.alertboxjs = {
                    'display': "block",
                    'background': "black",
                    'color': "white"
                };
            } else {
                $scope.alertmessage = 'err';
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

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //My Functions
    ////////
    $scope.hidealert = function() {
        $scope.alertboxjs = {
            'display': "none"
        };
    };

    var modalControl = function(direction) {
        if (direction == "Date" || direction == "Option") {
            $scope.fieldControl = {
                'display': "none"
            };

        } else {
            $scope.fieldControl = {
                'display': "block"
            };

        }
    };
    $scope.newtextconfig = function(direction, sequence) {
        temp_id = sequence;
        $scope.newtext = "";
        $scope.texttype = direction;
        $scope.textsingle = "no";
        $scope.textmultiple = "no";
        modalControl(direction);
    };
    $scope.edittextconfig = function(item) {
        temp_id = item.id;
        $scope.edittext = item.field_name;
        $scope.edittexttype = item.field_type;
        $scope.edittextsingle = item.single_select;
        $scope.edittextmultiple = item.multi_select;
        modalControl(item.field_type);
    };
    ////////////////////////////////
    ////////
    $scope.PostCall = function(Req_Url, Pipeline_Data, Success_Message, Fail_Message, perm) {
        $http.post(Req_Url, JSON.stringify(Pipeline_Data)).then(function(response) {
            //console.log(response);
            if (response.data && !response.data['err']) {
                if (perm == "yes") {
                    $scope.card = response.data;
                }

                $scope.alertmessage = Success_Message;
                $scope.alertboxjs = {
                    'display': "block",
                    'background': "lightgray",
                    'color': "black"
                };
                //$scope.items = response.data;

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
    $scope.openPage = function(pageName, id, color) {
        var i, tabcontent, tablinks;
        if (pageName == null) {
            document.getElementById("home").click();
            document.getElementById("home").style.backgroundColor = "rgb(26, 25, 25)";
            document.getElementById("Home").style.display = "block";
        } else {
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }
            document.getElementById(id).style.backgroundColor = "rgb(26, 25, 25)";
            document.getElementById(pageName).style.display = "block";
        }
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
    $scope.FormCustomer = function(value, name) {
            if (name == 'CustomerName') {
                $scope.currCustomer = JSON.parse(value);
                global_sequence = $scope.currCustomer.id;
                cardsload();
            }
        }
        //////////////////////////////////////
    cardsload();


});