app.controller('AllTemplates', function ($scope, $filter, $http) {
  ///////////initial Data Loading /////////////////////
  var initload = function(){
    var PipelineData = {
      sequence: 'joynDigital'
      };
      $http.post('/Latitude/public/admin/template/all', JSON.stringify(PipelineData)).then(function (response) {
        //console.log(response.data);
        if (response.data){
          $scope.items = response.data;
          
          $scope.search();
        }else{
          $scope.alertmessage = "Something Wrong went with the table.";
          $scope.alertboxjs = {
            'display': "block",
            'background': "black",
            'color': "white"
          };
        }
          
      }, function (response) {
        $scope.alertmessage = "Server Error!!!.";
          $scope.alertboxjs = {
            'display': "block",
            'background': "black",
            'color': "white"
          };
      });
  };
//////////////////////Variable Defination ///////////////////////
  $scope.items = [];
  var pageNum = 0;
  $scope.myValue=5;
  $scope.gap = 5;
  $scope.filteredItems = [];
  $scope.groupedItems = [];
  $scope.itemsPerPage = 5;
  $scope.pagedItems = [];
  $scope.currentPage = 0;
  $scope.sort = {       
    sortingOrder : 'id',
    reverse : false
  };
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// Table Functions /////////////////////////////////
  
  $scope.hidealert = function(){
    $scope.alertboxjs = {
      'display': "none"
    };
  };
  ////////
  $scope.myFunc = function() {
    $scope.itemsPerPage=$scope.myValue;
    $scope.search();
  };
  ////////
  var searchMatch = function (haystack, needle) {
    if (!needle) {
      return true;
    }
    return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
  };

  ////////
  $scope.search = function () {
    $scope.filteredItems = $filter('filter')($scope.items, function (item) {
      for(var attr in item) {
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
  $scope.groupToPages = function () {
    $scope.pagedItems = [];
    for (var i = 0; i < $scope.filteredItems.length; i++) {
      if (i % $scope.itemsPerPage === 0) {
        $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)] = [ $scope.filteredItems[i] ];
      } else {
          $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)].push($scope.filteredItems[i]);
      }
    }
  };
  ////////////
  $scope.range = function (size,start, end) {
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
  $scope.prevPage = function () {
    if ($scope.currentPage > 0) {
      $scope.currentPage--;
    }
  };
  ///////////////
  $scope.nextPage = function () {
    if ($scope.currentPage < $scope.pagedItems.length - 1) {
      $scope.currentPage++;
    }
  };
  //////////////
  $scope.setPage = function () {
    $scope.currentPage = this.n;
  };

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//My Functions
////////
  $scope.GlobalSequence = function(sequence){
    pageNum = $scope.currentPage;
    global_sequence = sequence;
    $scope.newname ="";
    $scope.newscope ="no";
    $scope.newcamera ="no";
    $scope.newapp ="no";
    $scope.newdocs ="no";
    $scope.newiot ="no";
    $scope.newsensornum ="0";
    $scope.newanalytics ="no";
    $scope.newagent ="no";
    $scope.newhardware ="no";
    $scope.newhardwareanalytics ="no";
  };
  
  ////////
  $scope.GlobalSequencedata = function(sequence){
    pageNum = $scope.currentPage;
    global_sequence = sequence.id;
    $scope.editname = sequence.template_name;
    $scope.editscope =sequence.allowed_scope;
    $scope.editcamera =sequence.allowed_camera;
    $scope.editapp =sequence.app_data_upload;
    $scope.editdocs =sequence.allowed_document;
    $scope.editiot =sequence.allowed_iot;
    $scope.editsensornum =sequence.allowed_sensor_num;
    $scope.editanalytics =sequence.analytics;
    $scope.editagent =sequence.agent_tracking;
    $scope.edithardware =sequence.hardware;
    $scope.edithardwareanalytics =sequence.hardware_analytics;
  };

  ////////
  $scope.NewTemplate = function(){
    var Req_Url = '/Latitude/public/admin/template/new';
    var Success_Message = "New Template Added Successfully.";
    var Fail_Message = "A problem was detected while creating of New Template.";
    var Pipeline_Data = {
      sequence: '0',
      template_name: $scope.newname,
      allowed_camera: $scope.newcamera,
      allowed_iot:$scope.newiot,
      allowed_sensor_num:$scope.newsensornum,
      allowed_document:$scope.newdocs,
      hardware:$scope.newhardware,
      hardware_analytics:$scope.newhardwareanalytics,
      analytics:$scope.newanalytics,
      agent_tracking:$scope.newagent,
      app_data_upload:$scope.newapp,
      allowed_scope:$scope.newscope
    };
    if($scope.newname != '' ){
      $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message);
    }else{
      $scope.alertmessage = "Operation Failed! Please fill all the fields.";
      $scope.alertboxjs = {
        'display': "block",
        'background': "red",
        'color': "white"
      };
    }
    
  };
  /////////
  $scope.Delete = function(){
    var Req_Url = '/Latitude/public/admin/template/delete';
    var Success_Message = "Deleted Successfully.";
    var Fail_Message = "A problem was detected while deleting.";
    var Pipeline_Data = {
      sequence: global_sequence
    };
    $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message);
  };

    ////////
  $scope.TemplateUpdate = function(){
    var Req_Url = '/Latitude/public/admin/template/update';
    var Success_Message = "Template Details Changed Successfully.";
    var Fail_Message = "A problem was detected while changing Template Details.";
    var Pipeline_Data = {
      sequence: global_sequence,
      template_name: $scope.editname,
      allowed_camera: $scope.editcamera,
      allowed_iot:$scope.editiot,
      allowed_sensor_num:$scope.editsensornum,
      allowed_document:$scope.editdocs,
      hardware:$scope.edithardware,
      hardware_analytics:$scope.edithardwareanalytics,
      analytics:$scope.editanalytics,
      agent_tracking:$scope.editagent,
      app_data_upload:$scope.editapp,
      allowed_scope:$scope.editscope
    };
    if($scope.editname != '' && $scope.editiot != '' && $scope.editcam != ''){
      $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message);
    }else{
      $scope.alertmessage = "Operation Failed! Please fill all the fields.";
      $scope.alertboxjs = {
        'display': "block",
        'background': "red",
        'color': "white"
      };
    }
  };
  ////////
  $scope.TablePostCall = function(Req_Url,Pipeline_Data,Success_Message,Fail_Message){
    $http.post(Req_Url, JSON.stringify(Pipeline_Data)).then(function (response) {
      //console.log(response);
      if (response.data){
        $scope.alertmessage = Success_Message;
        $scope.alertboxjs = {
          'display': "block",
          'background': "lightgray",
          'color': "black"
        };
        $scope.items = response.data;
        
        $scope.search();
        $scope.currentPage = pageNum;
      }else{
        $scope.alertmessage = Fail_Message;
        $scope.alertboxjs = {
          'display': "block",
          'background': "black",
          'color': "white"
        };
      }
        
    }, function (response) {
      $scope.alertmessage = "Server Error!!!.";
        $scope.alertboxjs = {
          'display': "block",
          'background': "black",
          'color': "white"
        };
    });
  };

  ////////
  $scope.search();
  initload();

});