app.controller('AllOperators', function ($scope, $filter, $http) {

  ///////////initial Data Loading /////////////////////
  var initload = function(){
    var PipelineData = {
      role_name: 'Operator'
      };
      $http.post('/Latitude/public/admin/random/all', JSON.stringify(PipelineData)).then(function (response) {
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
      PipelineData = {
        role_name: 'Customer'
        };
        $http.post('/Latitude/public/admin/random/all', JSON.stringify(PipelineData)).then(function (response) {
          console.log(response.data);
          if (response.data){
            $scope.cus = response.data;
            
            $scope.search();
          }else{
            $scope.alertmessage = "Please RELOAD the page!";
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
    $scope.newpass = "";
  };

  ////////
  $scope.GlobalSequencedata = function(sequence){
    pageNum = $scope.currentPage;
    global_sequence = sequence.id;
    $scope.newpass = "";
    $scope.editname = sequence.name;
    $scope.editusername = sequence.username;
    $scope.editemail = sequence.email;
    $scope.editphone = sequence.phone;
  };

  ////////
  $scope.GlobalSequenceEdit = function(sequence,ban){
    pageNum = $scope.currentPage;
    global_sequence = sequence;
    $scope.newpass = "";
    if(ban == "no"){
      $scope.blockheader="Block User";
      $scope.ActDisp = "Block";
    }else{
      $scope.blockheader="Unblock User";
      $scope.ActDisp = "Unblock";
    }  
  };
  ////////
  $scope.fillup = function(sequence){
    global_sequence = sequence.id;
    //console.log(global_sequence);
    var PipelineData = {
      sequence: global_sequence
      };
      $http.post('/Latitude/public/admin/user/customer/assigns', JSON.stringify(PipelineData)).then(function (response) {
        //console.log(response.data);
        if (response.data){
          $scope.cusName = "";
          $scope.cusName = response.data;
          //console.log(response.data);
        }else{
          $scope.alertmessage = "Please RELOAD the page.";
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

  /////////
  $scope.Delete = function(){
    var Req_Url = '/Latitude/public/admin/random/delete';
    var Success_Message = "Deleted Successfully.";
    var Fail_Message = "A problem was detected while deleting.";
    var Pipeline_Data = {
      sequence: global_sequence,
      role_name: 'Operator'
    };
    $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message,'yes');
  };

  ////////
  $scope.Ban = function(){
    var Req_Url = '/Latitude/public/admin/random/ban';
    var Success_Message = "Operation was Successful.";
    var Fail_Message = "A problem was detected while changing ban status.";
    var Pipeline_Data = {
      sequence: global_sequence,
      role_name: 'Operator'
    };
    $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message,'yes');
  };

  ////////
  $scope.PassUpdate = function(){
    var Req_Url = '/Latitude/public/admin/random/passChange';
    var Success_Message = "Password Updated Successfully.";
    var Fail_Message = "A problem was detected changing the password.";
    var Pipeline_Data = {
      sequence: global_sequence,
      role_name: 'Operator',
      newPass: $scope.newpass
    };
    if($scope.newpass != ''){
      $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message,'yes');
    }else{
      $scope.alertmessage = "Operation Failed! Password cannot be empty or less than 4 characters.";
      $scope.alertboxjs = {
        'display': "block",
        'background': "red",
        'color': "white"
      };
    }
  };

  ////////
  $scope.UserUpdate = function(){
    var Req_Url = '/Latitude/public/admin/random/edit';
    var Success_Message = "User Details Changed Successfully.";
    var Fail_Message = "A problem was detected while changing User Details.";
    var Pipeline_Data = {
      sequence: global_sequence,
      role_name: 'Operator',
      name: $scope.editname,
      username: $scope.editusername,
      email: $scope.editemail,
      phone: $scope.editphone
    };
    if($scope.editname != '' && $scope.editemail != '' && $scope.editphone != ''){
      pageNum = 0;
      $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message,'yes');
    }else{
      $scope.alertmessage = "Operation Failed! Please fill all the fields.";
      $scope.alertboxjs = {
        'display': "block",
        'background': "red",
        'color': "white"
      };
    }
  };

  //////////////////////////////
  $scope.customerAssign = function(){
    var Req_Url = '/Latitude/public/admin/customer/worker/assign';
    var Success_Message = "Operator Assigned to Customer Successfully.";
    var Fail_Message = "A problem was detected while assigning the Operator.";
    var Pipeline_Data = {
      sequence: $scope.newcus,
      role_name: 'Customer',
      roleID: global_sequence,
      worker: 'Operator'
    };
    //console.log(Pipeline_Data);
    if($scope.newcus != null){
      $scope.newcus = null;
      $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message,'no');
    }else{
      $scope.alertmessage = "Please select a Customer first then try to assign.";
      $scope.alertboxjs = {
        'display': "block",
        'background': "red",
        'color': "white"
      };
    }
    
  };

  /////////
  $scope.deleteassignment = function(id){
    var Req_Url = '/Latitude/public/admin/customer/worker/remove';
    var Success_Message = "Deleted Successfully.";
    var Fail_Message = "A problem was detected while deleting.";
    var Pipeline_Data = {
      sequence: id,
      worker: global_sequence,
      role_name:"Customer"
    };
    $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message,'no');
  };
 ////////
 
 $scope.TablePostCall = function(Req_Url,Pipeline_Data,Success_Message,Fail_Message,stat){
  $http.post(Req_Url, JSON.stringify(Pipeline_Data)).then(function (response) {
    if (response.data && !response.data['err']){
      $scope.alertmessage = Success_Message;
      $scope.alertboxjs = {
        'display': "block",
        'background': "lightgray",
        'color': "black"
      };
      if(stat == 'yes'){
        $scope.items = response.data;
        $scope.search();
        $scope.currentPage = pageNum;
      }else{
        var data = {'id':global_sequence};
        $scope.fillup(data);
      }
      
    }else if(response.data['err'] == "404"){
      //console.log();
      $scope.alertmessage = response.data['message'];
      $scope.alertboxjs = {
        'display': "block",
        'background': "black",
        'color': "white"
      };
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
  $scope.valuechecking = function(){
    return true;
  };
  ////////
  $scope.search();
  initload();
});