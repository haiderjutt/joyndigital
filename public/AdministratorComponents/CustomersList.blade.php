<div class="row">  
    <div class="alertbox col-md-12" ng-style="alertboxjs" ng-model="alertmessage">
        <span class="closebtn" style="color:darkblue;" ng-click="hidealert()">&times;</span> 
        <strong>Alert :</strong> <%alertmessage%>
    </div> 
</div>
<div class="tabledesignad">
<div class="customertable">
        <div class="customertabletwo">
            <div class="customertabletwo1">
                <p style="font-size:12px;  padding-left:15px;"> <b>Items Per Page </b> : </p>
                <u style="font-size:12px;  padding-left:10px;"><%myValue%></u>
                <select ng-model="myValue" ng-change="myFunc()" class="onlinetableddvalue">
                    <option value="5">5</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                    <option value="2000">2000</option>
                </select>
            </div>
            <div class="customertabletwo2">

                <p style="color:white;"> <b>Page</b> : <u><%currentPage+1|json%></u> <b>of</b> <u><%pagedItems.length|json%></u></p>
            </div>
            <div class="customertabletwo3">
            <p><input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch"></p>
            </div>
        </div>
        <div class="customertablethree">
        <table class="onlinetable ">
        <thead class="onlinetableheader">
            <tr>
                <th class="name"  custom-sort order="'name'" sort="sort"><b class="onlinetableheaderth">Name&nbsp;</b><i class="fa fa-sort" id="flipflop"></i></th>
                <th class="email " custom-sort order="'email'" sort="sort"><b class="onlinetableheaderth">Email&nbsp;</b> <i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field3" custom-sort order="'field3'" sort="sort"><b class="onlinetableheaderth">Phone&nbsp; </b><i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field4"  custom-sort order="'field4'" sort="sort"><b class="onlinetableheaderth">Ban Status&nbsp; </b><i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field5 "  custom-sort order="'field5'" sort="sort"><b class="onlinetableheaderth">Actions&nbsp;</b></th>
                <th class="field6 "  custom-sort order="'field6'" sort="sort"><b class="onlinetableheaderth">Config&nbsp;</b></th>
            </tr>
        </thead>

            
        <tbody style="font-size: 12px; background-color:#141414; hover:pointer;">
            <tr ng-repeat="item in pagedItems[currentPage] | orderBy:sort.sortingOrder:sort.reverse | filter:test" style="border-bottom:1px solid rgba(22, 99, 241, 0.849)">
                <td><%item.name%></td>
                <td><%item.email%></td>
                <td><%item.phone%></td>
                <td><%item.ban%></td>
                <td class="menu1">
                  <label class="menu-open-button1">
                         <i class="fa fa-cogs"></i>
                  </label>
                    <button class="menu-item1 blue btn" title="Edit" ng-click="FinalSequence(item,'lg','Update')" data-toggle="modal" data-target="#FinalModal"><img class="menu-item1 blue" src="./images/icons/Edit.png" height="60" width="60"></button>
                    <button class="menu-item1 blue btn" title="Change Pass" ng-click="FinalSequence(item,'sm','Password')" data-toggle="modal" data-target="#FinalModal" ><img class="menu-item1 blue" src="./images/icons/Password.png" height="60" width="60"></i></button>
                    <!-- <button class="menu-item1 blue btn" title="Delete" ng-click="FinalSequence(item,'sm','Delete')" data-toggle="modal" data-target="#FinalModal" ><img class="menu-item1 blue" src="./images/icons/Delete.png" height="60" width="60"></button>
                    <button class="menu-item1 blue btn" title="Ban" ng-click="FinalSequence(item,'sm','Ban')" data-toggle="modal" data-target="#FinalModal" ><img class="menu-item1 blue" src="./images/icons/BanJoyn.png" height="60" width="60"></button> -->

                </td>
                <td class="menu1">
                  <label class="menu-open-button1">
                         <i class="fa fa-cogs"></i>
                  </label>
                    <button class="menu-item1 blue btn" title="Allocation" ng-click="AssignSequence(item,'lg')" data-toggle="modal" data-target="#Gridmodal"><img class="menu-item1 blue" src="./images/icons/BanJoyn.png" height="60" width="60"></button>
                    <button class="menu-item1 blue btn" title="Feature Assignment" ng-click="fillup(item)" data-toggle="modal" data-target="#"><img class="menu-item1 blue" src="./images/icons/BanJoyn.png" height="60" width="60"></button>
                    <!-- <button class="menu-item1 blue btn" title="Assign Package" ng-click="fillup(item)" data-toggle="modal" data-target="#"><img class="menu-item1 blue" src="./images/icons/BanJoyn.png" height="60" width="60"></button> -->
                    <button class="menu-item1 blue btn" title="Field Configuration" ng-click="GlobalSequence(item.id)" href="#!InternalTemplate" ><a href="#!InternalTemplate"><img class="menu-item1 blue" src="./images/icons/BanJoyn.png" height="60" width="60"></a></button>
                    <button class="menu-item1 blue btn" title="view sites" ng-click="GlobalSequence(item.id)" data-toggle="modal" data-target="#" ><img class="menu-item1 blue" src="./images/icons/BanJoyn.png" height="60" width="60"></button>
                    <button class="menu-item1 blue btn" title="view form" ng-click="GlobalSequence(item.id)" data-toggle="modal" data-target="#" ><img class="menu-item1 blue" src="./images/icons/BanJoyn.png" height="60" width="60"></button>
                    <button class="menu-item1 blue btn" title="enter sites" ng-click="GlobalSequence(item.id)" data-toggle="modal" data-target="#" ><img class="menu-item1 blue" src="./images/icons/BanJoyn.png" height="60" width="60"></button>
                </td>
            </tr>
            
        </tbody>
    </table>
        </div>
    </div>
</div>



<div class="row pagefootert" ng-style="pagefooterstyle">
    <div class="col-sm-12">
        <div class="row pagefooter">
            <div class="col-md-6">
     </div>
         <div class="col-md-6" style=" text-align: right;">
            <button class="btn btn-secondary onlinetablecreateuserbtn"  ng-class="{disabled:currentPage == 0}">
            <a style="color:white;" href ng-click="prevPage()">« Prev</a>
            </button>
            <button class="btn btn-secondary onlinetablecreateuserbtn"  ng-repeat="n in range(pagedItems.length, currentPage, currentPage + gap) "
                ng-class="{active: n == currentPage}" ng-click="setPage()"> <a style="color:white;" href ng-bind="n + 1">1</a> 
            </button>
            <button class="btn btn-secondary onlinetablecreateuserbtn"  ng-class="{disabled: (currentPage) == pagedItems.length - 1}">
                    <a style="color:white;" href ng-click="nextPage()">Next »</a> 
            </button> 
         </div>
        </div>      
    </div>
</div>

<!-- Modal -->
<div class="modal" id="FinalModal" tabindex="-1" role="dialog" aria-labelledby="FinalModal" aria-hidden="true" >
    <div class="modal-dialog  " role="document" ng-class="{'modal-sm':modaltype == 'sm', 'modal-md':modaltype == 'md','modal-lg':modaltype == 'lg','modal-xl':modaltype == 'xl'}">
        <div class="modal-content">
            <div class="modalheader">
                <h6 class="modal-title" id="FinalModal"><%modalheader%></h6>
            </div>
            <div class="modalbody"  ng-style="modalbodyshow" ng-class="{modalbodyshow:modal == true}">
                <div ng-style="alertbox" style="display:none; width: 100%; height:20px; border:1px solid rgb(128, 218, 68); background:rgba(75, 48, 48, 0.589); border-radius:5px;">
                    <p style="text-align: center; color:white;">Alert: <% serverMessage %><a style="float:right; cursor:pointer;" ng-click="serverAlertHide()"><i class="fa fa-times"></i></a></p>
                </div>
                <div id="CRUDModal" >
                    <div  ng-repeat="item in formFields.file" >
                        <label><%item.label%></label>
                        <div class="newregisterimage">
                            <input type="file" custom-on-change="uploadFile" />
                            <img ng-src="<% item.value %>"width="100px" height="100px" alt="Profile Pic">
                        </div>
                    </div>
                     <div ng-repeat="item in formFields.text" >
                        <label><%item.label%></label>
                        <input class="form-control" type="text" ng-model="item.value">
                    </div>
                    <div ng-repeat="item in formFields.dropdown" >
                        <label><%item.label%></label>
                        <select class="form-control" type="text" ng-model="item.value">
                            <option ng-repeat="opt in item.options" value="<%opt%>">
                                <%opt%>
                            </option>
                        </select>
                    </div> 
             
                </div>
            </div>
            <div class="modalfooter" >
              <button type="button" ng-click="ModalRequest()" style="z-index:1000;"><%modalbutton%></button>
              <button type="button" data-dismiss="modal" style="z-index:1000;">Close</button>
            </div>
        </div>
    </div>    
</div>


<div class="modal" id="Gridmodal" tabindex="-1" role="dialog" aria-labelledby="Gridmodal" aria-hidden="true">
    <div class="modal-dialog" ng-class="{'modal-sm':m_type == 'sm', 'modal-lg':m_type == 'lg','modal-xl':m_type == 'xl'}">
        <div class="modal-content" >
            <div class="modalheader">
                <h6 class="modal-title" id="Gridmodal"><%modalheader%></h6>
            </div>
            <div id="modalcontent2" class="modalbody" ng-style="modalbodyshow" ng-class="{modalbodyshow:modal == true}"  >
                <div ng-style="alertbox" style="display:none; width: 100%; height:20px; border:1px solid rgb(128, 218, 68); background:rgba(75, 48, 48, 0.589); border-radius:5px;">
                    <p style="text-align: center; color:white;">Alert: <% serverMessage %><a style="float:right; cursor:pointer;" ng-click="serverAlertHide()"><i class="fa fa-times"></i></a></p>
                </div>
                <div ng-repeat="item in formFields.callocation">
                <div class="row customermodalheader" >
                  <div class="left">
                    <p>Customer : <b><img ng-src="<%item.Avatar.url%>" height="25" width="25"> <%item.Name.value%></b></p>
                  </div>
                <div class="right" style="float:right">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="#" data-toggle="tab"  role="tab" aria-controls="profile" aria-selected="false" ng-click="tabchange('Operator')"><i class="fa fa-user"> Operator</i> </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="#" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false" ng-click="tabchange('Agent')"><i class="fa fa-user"> Agent </i> </a>
                            </li>
                        </ul>
                </div>
                      
                  </div>
                  <div class="row">
                  <div class="flex-container" ng-style="flex_containerstyle">
                  <div ng-repeat="indv in item.Allocated.workerdetails">
                      <div> <img src="./images/user.png" style="border-radius:0px;"></div>
                      <div> 
                         <div>
                            <div class="classone">
                                <div> <b>Name:</b>  <%indv.name%></div>
                                <div><b>Email:</b>  <%indv.email%></div>
                                <div><b>Pnone:</b>  <%indv.phone%></div>
                            </div>
                            <div class="classtwo">
                                <button class="btn" > <i class="fa fa-envelope"></i></button>
                                <button class="btn"> <i class="fa fa-trash"></i></button>
                                <button class="btn"> <i class="fa fa-times"></i></button>
                            </div>
                         </div>
                      </div>
                    </div>
                  </div>
                  <div class="flex-container1">
                    <select class="form-control" ng-model="WorkerSelect" ng-change="customerdemo(WorkerSelect,'worker');">
                        <option ng-repeat="item in modalWorkers" value="<% item %>" ><% item.name %></option>
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
            <div class="modalfooter" >
              <button type="button"  ng-click="ModalRequest()" style="z-index:1000;"><%modalbutton%></button>
              <button type="button" data-dismiss="modal" style="z-index:1000;">Close</button>
            </div>
        </div>
    </div>    
</div>