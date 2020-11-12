app.controller('online', function ($scope, $filter, $http, $interval) {
  
  ///////////initial Data Loading /////////////////////
  var initload = function(){
    var PipelineData = {
      sequence: 'joynDigital'
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
      
  };
//////////////////////Variable Defination ///////////////////////
  $scope.items = [];
  var timer = false;
  var pageNum = 0;
  $scope.myValue=5;
  $scope.gap = 5;
  $scope.filteredItems = [];
  $scope.groupedItems = [];
  $scope.itemsPerPage = 5;
  $scope.pagedItems = [];
  $scope.currentPage = 0;
  $scope.formFields = {"text":{},"dropdown":{}, "file":{}, "allocation":{}};
  $scope.modal = true;
  $scope.FuncType = "";
  $scope.sort = {       
    sortingOrder : 'id',
    reverse : false
  };
  $scope.serverMessage = 'none';
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// Table Functions /////////////////////////////////
  
  $scope.serverAlert = function(){
    $scope.serverMessage = 'yoo';
    setTimeout(function(){
      $scope.alertbox = {
        'display': "block"
      };
      console.log('kjdfnvij');
    },1000);
    setTimeout(function(){
      $scope.alertbox = {
        'display': "none"
      };
      console.log('kjdfnvij');
    },3000);
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
$scope.AssignSequence = function(item,modaltype,fields){
  $scope.addModalClass("modalcontent2");
  var iterate = 0;
  var modallength = 0;
  $scope.modalbodyshow = {
      "height" : "0px"
  };
  timer = $interval( function(){console.log(iterate);iterate++;if(iterate>=1){$scope.addModalHeight(iterate+"00px");}; if(iterate >= 5){$interval.cancel(timer);$scope.removeModalClass("modalcontent2");}}, 100);
  pageNum = $scope.currentPage;
  $scope.m_type = modaltype;
  $scope.modal = true;
};
$scope.FinalSequence = function(item, modaltype, functiontype){
  var iterate = 0;
  var modallength = 0;
  $scope.FuncType = functiontype;
  if(item != null){
    global_sequence = item.id;
    pageNum = $scope.currentPage;
  }
  $scope.addModalClass("CRUDModal");
  $scope.formFields.text = {};
  $scope.formFields.dropdown = {};
  $scope.formFields.file = {}; 
  $scope.formFields.allocation = {}; 
  $scope.modalbodyshow={
    "height":"0px"
  };
  timer = $interval( function(){iterate++;if(iterate>=1){$scope.addModalHeight(modallength);}; if(iterate >= 5){$interval.cancel(timer); $scope.removeModalClass("CRUDModal");}}, 100);
  $scope.modaltype = modaltype;
  $scope.modal = true;
  switch(functiontype) {
    case 'Register':
      $scope.modalheader="Register New User";
      $scope.modalbutton = "Register";
      $scope.formFields.text=adminside.Register.text_fields;
      $scope.formFields.dropdown=adminside.Register.dropdown_fields;
      $scope.formFields.file=adminside.Register.file_fields;
      modallength=400+'px';
    break;
    case 'Update':
      adminside.Update.text_fields.Name.value = item.name; 
      adminside.Update.text_fields.Username.value = item.username;
      adminside.Update.text_fields.Email.value = item.email;
      adminside.Update.text_fields.Phone.value = item.phone;
      adminside.Update.file_fields.Avatar.value = './avatars/'+item.avatar;
      $scope.modalheader="Edit User Credentials";
      $scope.modalbutton = "Update";
      $scope.formFields.text=adminside.Update.text_fields;
      $scope.formFields.file=adminside.Update.file_fields;
      modallength=400+'px';  
    break;
    case 'Delete':
      $scope.modalheader="Delete User";
      $scope.modalbutton = "Delete";
      modallength=0+'px';
    break;
    case 'Ban':
      if(item.ban == "yes"){
        $scope.modalheader="Unban User";
        $scope.modalbutton = "Unban";
      }else{
        $scope.modalheader="Ban User";
        $scope.modalbutton = "Ban";
      }  
    break;
    case 'Password':
      $scope.modalheader="Change Password";
      $scope.modalbutton = "Update";
      $scope.formFields.text=adminside.Password.text_fields;
      modallength=100+'px';
    break;
    case 'Allocation':
      $scope.modalheader="Worker Allocation";
      $scope.modalbutton = "Assign";
      adminside.Allocation.workerdetails.Name.value = item.name; 
      adminside.Allocation.workerdetails.Username.value = item.username;
      adminside.Allocation.workerdetails.Email.value = item.email;
      adminside.Allocation.workerdetails.Phone.value = item.phone;
      adminside.Allocation.workerdetails.Avatar.url = './avatars/'+item.avatar;
      $scope.formFields.allocation=adminside.Allocation;
      
      modallength=500+'px'; 
    break;
    
    default:
      // code block
    break;
  }
  console.log($scope.formFields.allocation);
};
$scope.addModalClass = function(id){
  document.getElementById(id).classList.add("open");
};
$scope.addModalHeight = function(hei){
  $scope.modalbodyshow={
    "height": hei
  };
};
$scope.removeModalClass = function(id){
  if(document.getElementById(id).classList.contains("open")){
    document.getElementById(id).classList.remove("open");
  }
  
};


////////////////////////////////////////////////////////////////////////////////

$scope.ModalRequest = function(){
  var Req_Url = '/Latitude/public/admin/user/crud';
  console.log(adminside);
  var Pipeline_Data = {
    sequence: global_sequence,
    data: adminside,
    type: $scope.FuncType
  };
    
    $scope.testcall(Req_Url,Pipeline_Data);
    $scope.serverAlert();
  
};
$scope.uploadFile = function(){
  var file = event.target.files[0];
  var Req_Url = '/Latitude/public/admin/user/crud';
  const formData = new FormData();
  formData.append('file', file);
  formData.append('type', 'ProfilePicture');
  formData.append('sequence', global_sequence);
  formData.append('data', global_sequence);
  $http.post(Req_Url, formData,{ headers: {'Content-Type' : undefined}}).then(function (response) {
    if (response.data && !response.data['err']){
      $scope.alertmessage = "Success";
      $scope.alertboxjs = {
        'display': "block",
        'background': "lightgray",
        'color': "black"
      };
      $scope.items = response.data;
      $scope.currentPage = pageNum;
      adminside.Update.file_fields.Avatar.value = './avatars/'+file.name;
      $scope.search();
    }
  });
};
$scope.testcall = function(Req_Url,Pipeline_Data){
  $http.post(Req_Url, JSON.stringify(Pipeline_Data)).then(function (response) {
    console.log(response);
    if (response.data && !response.data['err']){
      $scope.alertmessage = "Success";
      $scope.alertboxjs = {
        'display': "block",
        'background': "lightgray",
        'color': "black"
      };
      $scope.items = response.data;
      
      $scope.search();
      $scope.currentPage = pageNum;
    }else if(response.data['err'] == "404"){
      //console.log();
      $scope.alertmessage = response.data['message'];
      $scope.alertboxjs = {
        'display': "block",
        'background': "black",
        'color': "white"
      };
    }else{
      $scope.alertmessage = "Failed";
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



////////new user
  $scope.GlobalSequence = function(sequence){
    pageNum = $scope.currentPage;
    global_sequence = sequence;
    $scope.newpass = "";
    $scope.newname =  '';
    $scope.newusername =  '';
    $scope.newemail= "";
    $scope.newpassword= "";
    $scope.newphone= "";
    $scope.newrole= "Administrator";
    $scope.newtype= "GIS";
    $scope.customeronly = {
      'display': "none"
    };
  };
  
  ////////edit
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
  $scope.CustomerCheck = function(role){
    if(role == "Customer"){
      $scope.customeronly = {
        'display': "block"
      };
    }else{
      $scope.customeronly = {
        'display': "none"
      };
      $scope.newtype = "GIS";
    }
  }

  /////////
  $scope.Delete = function(){
    var Req_Url = '/Latitude/public/admin/random/delete';
    var Success_Message = "Deleted Successfully.";
    var Fail_Message = "A problem was detected while deleting.";
    var Pipeline_Data = {
      sequence: global_sequence
    };
    $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message);
    $scope.valuechecking();
  };

  ////////
  $scope.Ban = function(){
    var Req_Url = '/Latitude/public/admin/random/ban';
    var Success_Message = "Operation was Successful.";
    var Fail_Message = "A problem was detected while changing ban status.";
    var Pipeline_Data = {
      sequence: global_sequence
    };
    $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message);
  };

  ////////
  $scope.NewUser = function(){
    var Req_Url = '/Latitude/public/admin/random/regNew';
    var Success_Message = "New User Added Successfully.";
    var Fail_Message = "A problem was detected while registration of New User.";
    var Pipeline_Data = {
      sequence: '0',
      name: $scope.newname,
      username: $scope.newusername,
      email: $scope.newemail,
      password:$scope.newpassword,
      phone: $scope.newphone,
      role: $scope.newrole,
      type: $scope.newtype
    };
    if($scope.newname != '' && $scope.newusername != '' && $scope.newemail != '' && $scope.newpassword != '' && $scope.newphone != '' && $scope.newrole != '' && $scope.newtype != ''){
      $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message);
    }else{
      $scope.alertmessage = "Operation Failed! Please fill all the fields.";
      $scope.alertboxjs = {
        'display': "block",
        'background': "red",
        'color': "white"
      };
    }

    $scope.valuechecking();
    
  };

  ////////
  $scope.PassUpdate = function(){
    var Req_Url = '/Latitude/public/admin/random/passChange';
    var Success_Message = "Password Updated Successfully.";
    var Fail_Message = "A problem was detected changing the password.";
    var Pipeline_Data = {
      sequence: global_sequence,
      newPass: $scope.newpass
    };
    if($scope.newpass != ''){
      $scope.TablePostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message);
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
      name: $scope.editname,
      username: $scope.editusername,
      email: $scope.editemail,
      phone: $scope.editphone
    };
    if($scope.editname != '' && $scope.editusername != '' && $scope.editemail != '' && $scope.editphone != ''){
      pageNum = 0;
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
      console.log(response);
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
  $scope.valuechecking = function(){
    var Pipeline_Data = {
      sequence: '0'
    };
    $http.post('/Latitude/public/admin/random/all/card', JSON.stringify(Pipeline_Data)).then(function (response) {
      if (response.data){
        console.log(response.data);
        $scope.cusnum = response.data['customers'];
        $scope.admnum = response.data['administrators'];
        $scope.opnum = response.data['operators'];
        $scope.agnum = response.data['agents'];
        $scope.venum = response.data['vendors'];
      }else{
        $scope.usernum = 0;
        $scope.cusnum = 0;
        $scope.admnum = 0;
        $scope.opnum = 0;
        $scope.venum = 0;
      }
      
    });
  };
  ////////
  $scope.Footerfunction = function(){
    if($scope.footerstate==1){
      console.log("state 1");
      console.log($scope.footerstate);
     $scope.pagefooterstyle={
      "width"       : "calc(100% - 100px)",
     }
    }
    else{
      console.log("state 0");
      console.log($scope.footerstate);
      $scope.pagefooterstyle={
          "width"       : "calc(100% - 250px)",
          "left"        : "260px",
      }
    }

  }
  ///////
  $scope.search();
  $scope.valuechecking();
  initload();
  $scope.Footerfunction();
  // $interval( function(){ $scope.valuechecking(); }, 2000);
  });