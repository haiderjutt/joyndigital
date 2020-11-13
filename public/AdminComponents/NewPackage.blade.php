<div class="tabledesignc">
    <div class="customertable">
        <div class="customertableone">
            <div class="customertableone1">
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
            <div class="customertableone2"> 
                    <p style="color:white;"> <b>Page</b> : <u><%currentPage+1|json%></u> <b>of</b> <u><%pagedItems.length|json%></u></p>
                </div>
            <div class="customertableone3">
                <p><input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch"></p>
            </div>
        </div>
        <div class="customertabletwo">
        <table class="onlinetable">
        <thead class="onlinetableheader">
            <tr>
                <th class="name" custom-sort order="'name'" sort="sort"><b  class="onlinetableheaderth">Name&nbsp;</b> <i class="fa fa-sort" id="flipflop"></i></th>
                <th class="email" custom-sort order="'email'" sort="sort"><b  class="onlinetableheaderth">Max Sites &nbsp; </b><i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field3" custom-sort order="'field3'" sort="sort"><b  class="onlinetableheaderth">Max Admins&nbsp; </b><i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field4" custom-sort order="'field4'" sort="sort"><b  class="onlinetableheaderth">Max Operators&nbsp;</b> <i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field5" custom-sort order="'field5'" sort="sort"><b  class="onlinetableheaderth">Max Agents&nbsp; </b><i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field6" custom-sort order="'field6'" sort="sort"><b  class="onlinetableheaderth">Max Partners&nbsp;</b> <i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field7" custom-sort order="'field7'" sort="sort"><b  class="onlinetableheaderth">Type&nbsp;</b> <i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field8" custom-sort order="'field8'" sort="sort"><b  class="onlinetableheaderth">Cost&nbsp;</b> <i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field9" custom-sort order="'field9'" sort="sort"><b  class="onlinetableheaderth">Cost (Words)&nbsp; </b><i class="fa fa-sort" id="flipflop"></i></th>
                <th class="field10" custom-sort order="'field10'" sort="sort"><b  class="onlinetableheaderth">Actions&nbsp;</b></th>
            </tr>
        </thead>
           
            <!-- <pre>currentPage: <%sort|json%></pre> -->
    
            
        <tbody style="font-size: 12px; background-color:#141414; hover:pointer;">
            <tr ng-repeat="item in pagedItems[currentPage] | orderBy:sort.sortingOrder:sort.reverse | filter:test" class="tableentries">
                <td><%item.name%></td>
                <td><%item.sites_num%></td>
                <td><%item.administrators_num%></td>
                <td><%item.operators_num%></td>
                <td><%item.agents_num%></td>
                <td><%item.partner_num%></td>
                <td><%item.package_type%></td>
                <td><%item.cost%></td>
                <td><%item.cost_in_letters%></td>
                <td class="menu1">
                   <label class="menu-open-button1">
                       <i class="fa fa-cogs"></i>
                   </label>
                   <button  class="menu-item1 blue btn" title="Edit" ng-click="FinalSequence(item,'md','UpdatePackage')" data-toggle="modal" data-target="#FinalModal" ><i class="fa fa-edit"></i></button>
                   <button  class="menu-item1 blue btn" title="Delete" ng-click="FinalSequence(item,'sm','DeletePackage')" data-toggle="modal" data-target="#FinalModal" ><i class="fa fa-trash"></i></button>
                   <button  class="menu-item1 blue btn" title="Assign" title="Assign" href ng-click="FinalSequence(item,'lg','AssignPackage')" data-toggle="modal" data-target="#FinalModal" ><i class="fa fa-exchange"></i> </button>
                </td>
            </tr>   
        </tbody>
    </table>
        </div>
    </div>
</div> 
<div class="row">
    <div class="alertbox col-md-12" ng-style="alertboxjs" ng-model="alertmessage">
        <span class="closebtn" style="color:darkblue;" ng-click="hidealert()">&times;</span> 
        <strong>Alert :</strong> <%alertmessage%>
    </div>
</div>
<div class="row">
    
</div> 
<div class="row pagefootert" ng-style="pagefooterstyle">
    <div class="col-sm-12">
        <div class="row pagefooter">
            <div class="col-md-6">
             <button class="btn btn-outline-secondary onlinetablecreateuserbtn" ng-click="FinalSequence(item,'lg','CreateUser')" title="Create New User" data-toggle="modal" data-target="#FinalModal"><img src="./images/icons/Packages.png" height="30" width="30" style="margin-top:-6px;"> Create New User</button>
             <button class="btn btn-outline-secondary onlinetablecreateuserbtn" ng-click="FinalSequence(item,'md','NewPackage')" title="New Package" data-toggle="modal" data-target="#FinalModal"><img src="./images/icons/Packages.png" height="30" width="30" style="margin-top:-6px;">Create New Package</button>
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

<div class="modal" id="FinalModal" tabindex="-1" role="dialog" aria-labelledby="FinalModal" aria-hidden="true">
    <div class="modal-dialog  " role="document" ng-class="{'modal-sm':modaltype == 'sm', 'modal-md':modaltype == 'md','modal-lg':modaltype == 'lg','modal-xl':modaltype == 'xl'}">
        <div class="modal-content">
            <div class="modalheader">
                <h6 class="modal-title" id="FinalModal"><%modalheader%></h6>
            </div>
            <div class="modalbody"  ng-style="modalbodyshow" ng-class="{modalbodyshow:modal == true}">
                <div ng-style="alertbox" style="display:none; width: 100%; height:20px; border:1px solid rgb(128, 218, 68); background:rgba(75, 48, 48, 0.589); border-radius:5px;">
                    <p style="text-align: center; color:white;">Alert: <% serverMessage %><a style="float:right; cursor:pointer;" ng-click="serverAlertHide()"><i class="fa fa-times"></i></a></p>
                </div>
                <div id="CRUDModal">
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
                    <div class="custcard2" ng-repeat="item in formFields.assignment">
                        <div class="custcard2first" >
                            <p>Package Details</p>
                   
                            <div >
                                <b style="float:left"> Name:</b>   <%item.details.Name%> <br><br>
                                <b style="float:left">Administrators :</b> <%item.details.administrators_num%><br><br>
                                <b style="float:left">Operators  :</b>  <%item.details.operators_num%><br><br>
                                <b style="float:left">Agents : </b> <%item.details.agents_num%><br><br>
                                <b style="float:left">Sites :</b> <%item.details.sites_num%><br><br>
                                <b style="float:left">Cost:</b>  <%item.details.Cost%><br><br>
                            </div>

                        </div>
                        <div class="custcard2second">
                            <p>Allocations</p>
                            <div>
                               <div ng-repeat="row in item.assigned">
                                   <div class="custcard2secondinfo">
                                       <b>Name</b>  : <% row.name%> <br>
                                       <b>Email</b>  : <% row.email%> <br>
                                       <b>Phone</b>  : <% row.phone%> <br>
                                   </div>
                                   <div class="custcard2secondimage"> <img src="./avatars/<%row.avatar%>" height="80px" width="80px"></div>
                                   <div class="custcard2secondbuttons">
                                       <a><i class="fa fa-times"></i></a><br>
                                       <a><i class="fa fa-envelope"></i></a>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="custcard2third">
                            <h6>New Allocations</h6>
                             <div>
                                <div>
                                    <select class="form-control" ng-model="CustomerSelect" ng-change="customerdemo(CustomerSelect)">
                                        <option ng-repeat="item in modalCustomers" value="<% item %>" ><% item.name %></option>
                                    </select>
                                </div>
                                <div ng-if="newassign">
                                    <img ng-src="<%newassign.avatar%>" width="100%">
                                </div>
                                <div ng-if="newassign">
                                   <b>Name</b>  : <% newassign.name %> <br>
                                   <b>Email</b>  : <% newassign.email %> <br>
                                   <b>Phone</b>  : <% newassign.phone %> <br>
                                </div>

                                <div class="arrow">
                                   <div>
                                    <div id="arrowAnim">
                                        <div class="arrowSliding">
                                          <div class="arrow"></div>
                                        </div>
                                        <div class="arrowSliding delay1">
                                          <div class="arrow"></div>
                                        </div>
                                        <div class="arrowSliding delay2">
                                          <div class="arrow"></div>
                                        </div>
                                        <div class="arrowSliding delay3">
                                          <div class="arrow"></div>
                                        </div>
                                      </div>
                                   </div> 
                                </div>

                             </div>

                        </div>
                    
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



