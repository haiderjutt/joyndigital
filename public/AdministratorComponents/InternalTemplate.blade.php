<div class="row">
  <div class="alertbox col-md-12" ng-style="alertboxjs" ng-model="alertmessage">
    <span class="closebtn" style="color:darkblue;" ng-click="hidealert()">&times;</span>
    <strong>Alert :</strong> <%alertmessage%>
  </div>
</div>
<div class="row " style="margin-bottom:10px;">
  <button class="tablink " id="home" ng-click="openPage('Home', 'home', 'red')">Text Fields</button>
  <button class="tablink" ng-click="openPage('News', 'news', 'green')" id="news">Date Fields</button>
  <button class="tablink" ng-click="openPage('Contact', 'contact', 'blue')" id="contact">Dropdown Fields</button>
  <button class="tablink" ng-click="openPage('Support', 'support', 'yellow')" id="support">Controlled Dropdown</button>
  <button class="tablink" ng-click="openPage('Range', 'range', 'pink')" id="range">Range</button>
  <div class="tablinkR">
    <button><a href="#!CustomerForm">View Form</a></button>
    <button><a href="#!CustomerForm">View Sites</a></button>
  </div>

</div>

<div id="Home" class="tabcontent">
  <div class="tabcontentone">
    <div class="tabcontentone1">
      <p> <a class="a" ng-click="FinalSequence('item','md','AddTextField','Input')" data-toggle="modal" data-target="#FinalModal" title="Add Text Field"><i class="fa fa-plus"></i> Add </a> </p>
    </div>
    <div class="tabcontentone2">Customer: <b><% name %></b></div>
    <div class="tabcontentone3">
      <input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch">
    </div>
  </div>
  <div class="tabcontenttwo">
    <table class="onlinetable ">
      <thead class="onlinetableheader">
        <tr>
          <th class="onlinetableheaderth">Name</th>
          <th class="onlinetableheaderth">Actions</th>
        </tr>
      </thead>
      <tbody style="font-size: 12px; background-color:#141414; cursor:pointer;">
        <tr ng-repeat="item in card['Input']" class="tableentries" style="height:35px;">
          <td><%item.field_name%></td>
          <td><a style="margin-left:10px; cursor:pointer;" title="Edit Text Field" ng-click="FinalSequence(item,'md','EditTextField','Input')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-list"></i></a><a style="margin-left:10px; cursor: pointer;" title="Delete Text Field" ng-click="FinalSequence(item,'md','DeleteTextField','Input')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-trash"></i></a></td>
        </tr>
      <tbody>
    </table>
  </div>

</div>

<div id="News" class="tabcontent">
  <div class="tabcontentone">
    <div class="tabcontentone1">
      <p> <a class="a" ng-click="FinalSequence('item','md','AddTextField','Date')" data-toggle="modal" data-target="#FinalModal" title="Add Text Field"><i class="fa fa-plus"></i> Add </a> </p>
    </div>
    <div class="tabcontentone2">Customer: <b><% name %></b></div>
    <div class="tabcontentone3">
      <input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch">
    </div>
  </div>
  <div class="tabcontenttwo">
    <table class="onlinetable">
      <thead class="onlinetableheader">
        <tr>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody style="font-size: 12px; background-color:#141414; hover:pointer;">
        <tr ng-repeat="item in card['Date']" class="tableentries" style="height:35px;">
          <td><%item.field_name%></td>
          <td><a style="margin-left:10px; cursor:pointer;" title="Edit Text Field" ng-click="FinalSequence(item,'md','EditTextField','Date')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-list"></i></a><a style="margin-left:10px; cursor: pointer;" title="Delete Text Field" ng-click="FinalSequence(item,'md','DeleteTextField','Date')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-trash"></i></a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div id="Contact" class="tabcontent">
  <div class="tabcontentone">
    <div class="tabcontentone1">
      <p> <a class="a" ng-click="FinalSequence('item','md','AddTextField','Dropdown')" data-toggle="modal" data-target="#FinalModal" title="Add Text Field"><i class="fa fa-plus"></i> Add </a> </p>
    </div>
    <div class="tabcontentone2">Customer: <b><% name %></b></div>
    <div class="tabcontentone3">
      <input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch">
    </div>
  </div>
  <div class="tabcontenttwo">
    <table class="onlinetable">
      <thead class="onlinetableheader">
        <tr>
          <th>Name</th>

          <th>Actions</th>
          <th>Options Name</th>
          <th>Option Actions</th>
        </tr>
      </thead>
      <tbody style="font-size: 12px; background-color:#141414; hover:pointer;">
        <tr ng-repeat="item in card['Dropdown'] | orderBy:sort.sortingOrder:sort.reverse | filter:test" class="tableentries">
          <td><%item.field_name%></td>
          <td><a ng-click="FinalSequence(item,'md','AddTextField','Option')" data-toggle="modal" data-target="#FinalModal" title="Add Option Field"><i class="fa fa-plus"></i> </a><a style="margin-left:10px; cursor:pointer;" title="Edit Text Field" ng-click="FinalSequence(item,'md','EditTextField','Dropdown')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-list"></i></a><a style="margin-left:10px; cursor: pointer;" title="Delete Text Field" ng-click="FinalSequence(item,'md','DeleteTextField','Dropdown')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-trash"></i></a></td>
          <td>
            <ol>
              <li ng-repeat="options in card['Option'][item.field_name]"><% options.field_name %> </li>
            </ol>
          </td>
          <td>
            <ol>
              <li ng-repeat="options in card['Option'][item.field_name]"><a style="margin-left:10px; cursor:pointer;" title="Edit Text Field" ng-click="FinalSequence(options,'md','EditTextField','Option')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-list"></i></a><a style="margin-left:10px; cursor: pointer;" title="Delete Text Field" ng-click="FinalSequence(options,'md','DeleteTextField','Option')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-trash"></i></a></li>
            </ol>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div id="Support" class="tabcontent">
  <div class="tabcontentone">
    <div class="tabcontentone1">
      <p> <a class="a" ng-click="FinalSequence('item','md','AddTextField','Controlled')" data-toggle="modal" data-target="#FinalModal" title="Add Text Field"><i class="fa fa-plus"></i> Add </a> </p>
    </div>
    <div class="tabcontentone2">Customer: <b><% name %></b></div>
    <div class="tabcontentone3">
      <input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch">
    </div>
  </div>
  <div class="tabcontenttwo">
    <table class="onlinetable">
      <thead class="onlinetableheader">
        <tr>
          <th>Name</th>
          <th>Actions</th>
          <th>Options Name</th>
          <th>Option Actions</th>
        </tr>
      </thead>
      <tbody style="font-size: 12px; background-color:#141414; hover:pointer;">
        <tr ng-repeat="item in card['Controlled'] | orderBy:sort.sortingOrder:sort.reverse | filter:test" class="tableentries">
          <td><%item.field_name%></td>
          <td><a ng-click="FinalSequence(item,'md','AddTextField','Option')" data-toggle="modal" data-target="#FinalModal" title="Add Option Field"><i class="fa fa-plus"></i> </a><a style="margin-left:10px; cursor:pointer;" title="Edit Text Field" ng-click="FinalSequence(item,'md','EditTextField','Controlled')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-list"></i></a><a style="margin-left:10px; cursor: pointer;" title="Delete Text Field" ng-click="FinalSequence(item,'md','DeleteTextField','Dropdown')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-trash"></i></a>
            <a style="margin-left:10px; cursor: pointer;" title="Controlled Permission" ng-click="AssignSequence(item,'xl')" data-toggle="modal" data-target="#Gridmodal"><i class="fa fa-user"></i></a> </td>
          <td>
            <ol>
              <li ng-repeat="options in card['Option'][item.field_name]"><% options.field_name %> </li>
            </ol>
          </td>
          <td>
            <ol>
              <li ng-repeat="options in card['Option'][item.field_name]"><a style="margin-left:10px; cursor:pointer;" title="Edit Text Field" ng-click="FinalSequence(options,'md','EditTextField','Option')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-list"></i></a><a style="margin-left:10px; cursor: pointer;" title="Delete Text Field" ng-click="FinalSequence(options,'md','DeleteTextField','Option')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-trash"></i></a></li>
            </ol>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div id="Range" class="tabcontent">
  <div class="tabcontentone">
    <div class="tabcontentone1">
      <p> <a class="a" ng-click="FinalSequence('item','md','AddTextField','Range')" data-toggle="modal" data-target="#FinalModal" title="Add Text Field"><i class="fa fa-plus"></i> Add </a> </p>
    </div>
    <div class="tabcontentone2">Customer: <b><% name %></b></div>
    <div class="tabcontentone3">
      <input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch">
    </div>
  </div>
  <div class="tabcontenttwo">
    <p class="tabsearch"> <a class="a" ng-click="FinalSequence('item','md','AddTextField','Range')" data-toggle="modal" data-target="#FinalModal" title="Add Text Field"><i class="fa fa-plus"></i> Add </a> Customer: <b><% currentname %></b> <input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch input"></p>
    <table class="onlinetable">
      <thead class="onlinetableheader">
        <tr>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody style="font-size: 12px; background-color:#141414; hover:pointer;">
        <tr ng-repeat="item in card['Range'] | orderBy:sort.sortingOrder:sort.reverse | filter:test" class="tableentries">
          <td><%item.field_name%></td>
          <td><a style="margin-left:10px; cursor:pointer;" title="Edit Text Field" ng-click="FinalSequence(item,'md','EditTextField','Range')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-list"></i></a><a style="margin-left:10px; cursor: pointer;" title="Delete Text Field" ng-click="FinalSequence(item,'md','DeleteTextField','Dropdown')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-trash"></i></a></td>

        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="formfooter" ng-style="formfooterstyle">
      <div class="formfooter1">
      <span class="input-group-addon">Active Customer</span>
      <select class="btn btn-outline-secondary" ng-model="currentCustomer" ng-change="FormCustomer(currentCustomer,'CustomerName')">
          <option ng-repeat="item in customers" value="<%item%>"><%item.name%></option>
        </select>
      </div >
</div>
<!--
    modal 
 -->
<div class="modal" id="FinalModal" tabindex="-1" role="dialog" aria-labelledby="FinalModal" aria-hidden="true">
  <div class="modal-dialog  " role="document" ng-class="{'modal-sm':modaltype == 'sm', 'modal-md':modaltype == 'md','modal-lg':modaltype == 'lg','modal-xl':modaltype == 'xl'}">
    <div class="modal-content">
      <div class="modalheader">
        <h6 class="modal-title" id="FinalModal"><%modalheader%></h6>
      </div>
      <div class="modalbody" ng-style="modalbodyshow" ng-class="{modalbodyshow:modal == true}">
        <div ng-style="alertbox" style="display:none; width: 100%; height:20px; border:1px solid rgb(128, 218, 68); background:rgba(75, 48, 48, 0.589); border-radius:5px;">
          <p style="text-align: center; color:white;">Alert: <% serverMessage %><a style="float:right; cursor:pointer;" ng-click="serverAlertHide()"><i class="fa fa-times"></i></a></p>
        </div>
        <div id="CRUDModal">
          <div ng-repeat="item in formFields.text">
            <label><%item.label%></label>
            <input class="form-control" type="text" ng-model="item.value">
          </div>
        </div>
      </div>
      <div class="modalfooter">
        <button type="button" data-dismiss="modal" ng-click="ModalRequest()"><%modalbutton%></button>
        <button type="button" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="Gridmodal" tabindex="-1" role="dialog" aria-labelledby="Gridmodal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modalheader">
        <h6 class="modal-title" id="Gridmodal"><%modalheader%></h6>
      </div>
      <div id="modalcontent2" class="modalbody" ng-style="modalbodyshow" ng-class="{modalbodyshow:modal == true}">
        <div ng-style="alertbox" style="display:none; width: 100%; height:20px; border:1px solid rgb(128, 218, 68); background:rgba(75, 48, 48, 0.589); border-radius:5px;">
          <p style="text-align: center; color:white;">Alert: <% serverMessage %><a style="float:right; cursor:pointer;" ng-click="serverAlertHide()"><i class="fa fa-times"></i></a></p>
        </div>
        <div>
          <div class="row customermodalheader">
            <div class="left">
              <p><%permname%></p>
            </div>
            <div class="right">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="#" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false" ng-click="tabchange('Operator')"><i class="fa fa-user"> Operator</i> </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="#" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false" ng-click="tabchange('Agent')"><i class="fa fa-user"> Agent </i> </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="flex-container2">
              <div ng-repeat="(key,indv) in card['Option'][permname]">
                <div><label for=""><%indv.field_name%></label></div>
                <div> <input id="checkFollower" type="checkbox" ng-checked="card['Option'][permname][key]['perm'].includes(newassign.id)" aria-label="Follower input" ng-click="Permstate(newassign.id,key)"></div>
              </div>
            </div>
            <div class="flex-container3">
              <select class="form-control" ng-model="WorkerSelect" ng-change="customerdemo(WorkerSelect,'worker');">
                <option ng-repeat="item in modalWorkers" value="<% item %>"><% item.name %></option>
              </select> <br>
              <div ng-if="newassign">
                <img ng-src="<%newassign.avatar%>" width="90%">
              </div> <br>
              <div ng-if="newassign">
                <b>Name:</b> <% newassign.name %> <br>
                <b>Email:</b> <% newassign.email %> <br>
                <b>Pnone:</b> <% newassign.phone %> <br>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modalfooter">
        <button type="button" ng-click="ModalRequest2()"><%modalbutton%></button>
        <button type="button" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>