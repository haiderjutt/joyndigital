app.controller('CustomerFields', function ($scope, $filter, $http, $interval) {
    var temp_id = "";
    $scope.formFields = {"text":{},"dropdown":{}};
    var temp_data = "";
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
    $scope.setPage = function () {
      $scope.currentPage = this.n;
    };
    ///////////initial Data Loading /////////////////////
    var cardsload = function(){
      $scope.openPage();
      var PipelineData = {
        sequence: global_sequence
        };
      $http.post('/Latitude/public/administrator/customer/fields', JSON.stringify(PipelineData)).then(function (response) {
          console.log(response.data);
          $scope.card = response.data;
  
        //   if (response.data){
        //       global_sequence = response.data[0].id;
        //       $scope.currentname = response.data[0].template_name;
        //       if(response.data[0].allowed_scope == 'no'){}
        // }
      });
    };
   //alert(global_sequence);
   $scope.currentname = "Joyn";
     ////////
     $scope.FinalSequence = function(item, modaltype, functiontype,fieldType){
      if(administratorside.CustomerField.type.field_type.value == 'Option'){
        $scope.optShow = false;
      }else{
        $scope.optShow = true;
      }
      $scope.serverAlertHide();
      var iterate = 0;
      var modallength = 0;
      $scope.FuncType = functiontype;
      if(item != null){
        administratorside.CustomerField.type.field_type.pre = item.id;
      }
      administratorside.CustomerField.type.field_type.value = fieldType;
      $scope.addModalClass("CRUDModal");
      $scope.formFields.text = {};
      $scope.formFields.dropdown = {};
      $scope.formFields.allocation = {}; 
      $scope.modalbodyshow={
        "height":"0px"
      };
      timer = $interval( function(){iterate++;if(iterate>=1){$scope.addModalHeight(modallength);}; if(iterate >= 3){$interval.cancel(timer); $scope.removeModalClass("CRUDModal");}}, 100);
      $scope.modaltype = modaltype;
      $scope.modal = true;
       
      switch(functiontype) {
        case 'AddTextField':
          $scope.modalheader="Add Field";
          $scope.modalbutton = "Add";
          administratorside.CustomerField.text_fields.Name.value = ""; 
          administratorside.CustomerField.dropdown_fields.multi_select.value = 'no';
          administratorside.CustomerField.dropdown_fields.single_select.value = 'no';
          $scope.formFields.text=administratorside.CustomerField.text_fields;
          $scope.formFields.dropdown=administratorside.CustomerField.dropdown_fields;
          modallength=250+'px';
        break;
        case 'EditTextField':
          administratorside.CustomerField.text_fields.Name.value = item.field_name; 
          administratorside.CustomerField.dropdown_fields.multi_select.value = item.single_select;
          administratorside.CustomerField.dropdown_fields.single_select.value = item.multi_select;
          $scope.modalheader="Update Field";
          $scope.modalbutton = "Update";
          $scope.formFields.text=administratorside.CustomerField.text_fields;
          $scope.formFields.dropdown=administratorside.CustomerField.dropdown_fields;
          modallength=250+'px';  
        break;
        case 'DeleteTextField':
      
          $scope.modalheader="Delete Field";
          $scope.modalbutton = "Delete";
          modallength=30+'px';  
        break;
        default:
          // code block
        break;
      }
      
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
    $scope.serverAlertShow = function($message){
      $scope.serverMessage = $message;
      $scope.alertbox = {
        'display': "block"
      };
    };
    $scope.serverAlertHide = function(){
      $scope.alertbox = {
        'display': "none"
      };
    };
  
  
    ////////////////
    $scope.ModalRequest = function(){
        var Req_Url = '/Latitude/public/administrator/customer/fields/crud';
        var Pipeline_Data = {
          sequence: global_sequence,
          data: administratorside,
          type: $scope.FuncType
        };
          
          $scope.TablePostCall1(Req_Url,Pipeline_Data); 
          
      };
      $scope.TablePostCall1 = function(Req_Url,Pipeline_Data){
        $http.post(Req_Url, JSON.stringify(Pipeline_Data)).then(function (response) {
          console.log(response.data);
          if (response.data && !response.data['err']){
            $scope.card = response.data;
            $scope.alertmessage = 'success';
              $scope.alertboxjs = {
                'display': "block",
                'background': "black",
                'color': "white"
              };
      
          }else if(response.data['err'] == "404"){
            $scope.alertmessage = response.data['message'];
              $scope.alertboxjs = {
                'display': "block",
                'background': "black",
                'color': "white"
              };
          }else{
            $scope.alertmessage = 'err';
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
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //My Functions
  ////////
  $scope.hidealert = function(){
    $scope.alertboxjs = {
      'display': "none"
    };
  };
  
  var modalControl = function (direction){
    if(direction == "Date" || direction == "Option"){
      $scope.fieldControl = {
        'display': "none"
      };
  
    }else{
      $scope.fieldControl = {
        'display': "block"
      };
  
    }
  };
  $scope.newtextconfig = function(direction,sequence){
    temp_id = sequence;
    $scope.newtext = "";
    $scope.texttype =  direction;
    $scope.textsingle= "no";
    $scope.textmultiple= "no";
    modalControl(direction);
  };
  $scope.edittextconfig = function(item){
    temp_id = item.id;
    $scope.edittext = item.field_name;
    $scope.edittexttype = item.field_type;
    $scope.edittextsingle= item.single_select;
    $scope.edittextmultiple= item.multi_select;
    modalControl(item.field_type);
  };
    ////////////////////////////////
    $scope.addfield = function(){
      if($scope.newtext == ""){
          alert('Field Name cannot be empty');
      }else{
          var Req_Url = '/Latitude/public/admin/customer/newinput';
          var Success_Message = "Added Successfully.";
          var Fail_Message = "A problem was detected while adding the field.";
          if($scope.texttype == "Option"){
            var Pipeline_Data = {
              past : temp_id,
              sequence: global_sequence,
              name: $scope.newtext,
              type: $scope.texttype,
              single: $scope.textsingle,
              multiple: $scope.textmultiple
              };
              $scope.PostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message,'yes');
          }else{
            var Pipeline_Data = {
              sequence: global_sequence,
              name: $scope.newtext,
              type: $scope.texttype,
              single: $scope.textsingle,
              multiple: $scope.textmultiple
              };
              $scope.PostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message,'yes');
          }
          
          
  
      }
      
    };
    ////////////////////////////////
    $scope.editfield = function(){
      if($scope.edittext == ""){
          alert('Field Name cannot be empty');
      }else{
          var Req_Url = '/Latitude/public/admin/customer/editinput';
          var Success_Message = "Edited Successfully.";
          var Fail_Message = "A problem was detected while editing the field.";
          var Pipeline_Data = {
          past : temp_id,
          sequence: global_sequence,
          name: $scope.edittext,
          type: $scope.edittexttype,
          single: $scope.edittextsingle,
          multiple: $scope.edittextmultiple
          };
          $scope.PostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message,'yes');
    
      }
      
    };
    ////////////////////////////////
    $scope.Delete = function(){
  
          var Req_Url = '/Latitude/public/admin/customer/deleteinput';
          var Success_Message = "Deleted Successfully.";
          var Fail_Message = "A problem was detected while deleting the field.";
          var Pipeline_Data = {
          id : temp_id,
          sequence: global_sequence,
          };
          $scope.PostCall(Req_Url,Pipeline_Data,Success_Message,Fail_Message,'yes');
    
      
      
    };
   ////////
   $scope.PostCall = function(Req_Url,Pipeline_Data,Success_Message,Fail_Message,perm){
      $http.post(Req_Url, JSON.stringify(Pipeline_Data)).then(function (response) {
        //console.log(response);
        if (response.data && !response.data['err']){
          if(perm == "yes"){
            $scope.card = response.data;
          }
          
          $scope.alertmessage = Success_Message;
          $scope.alertboxjs = {
            'display': "block",
            'background': "lightgray",
            'color': "black"
          };
          //$scope.items = response.data;
          
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
    $scope.openPage=function(pageName,id,color){
      var i, tabcontent, tablinks;
      if(pageName==null){
        document.getElementById("home").click();
        document.getElementById("home").style.backgroundColor="rgb(26, 25, 25)";
        document.getElementById("Home").style.display = "block";
      }
    else{
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
      }
      document.getElementById(id).style.backgroundColor="rgb(26, 25, 25)";
      document.getElementById(pageName).style.display = "block";
    }
    };
    $scope.$on('eventBroadcastedName', function(){
      if($scope.footerstate){
        console.log($scope.footerstate);
        $scope.pagefooterstyle={
          "width" : "calc(100% - 5vw)",
        }
      }
      else{
        console.log($scope.footerstate);
        $scope.pagefooterstyle={
          "width" : "calc(100% - 17vw)",
        }
      }
    });
    //////////////////////////////////////
    cardsload();
  
  
  });