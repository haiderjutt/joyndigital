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
            <table class="onlinetable ">
                <thead class="onlinetableheader">
                    <tr>
                        <th class="name" custom-sort order="'name'" sort="sort"><b class="onlinetableheaderth">Name&nbsp;</b><i class="fa fa-sort" id="flipflop"></i></th>
                        <th class="field2 " custom-sort order="'field5'" sort="sort"><b class="onlinetableheaderth">Actions&nbsp;</b></th>
                    </tr>
                </thead>


                <tbody style="font-size: 12px; background-color:#141414; cursor:pointer;">
                    <tr ng-repeat="item in pagedItems[currentPage] | orderBy:sort.sortingOrder:sort.reverse | filter:test" style="border-bottom:1px solid rgba(22, 99, 241, 0.849)">
                        <td><%item.feature_name%></td>
                        <td class="menu1">
                            <label class="menu-open-button1">
                                <i class="fa fa-cogs"></i>
                            </label>
                            <button class="menu-item1 blue btn" title="Configure Docx " ng-if="item.id == 1" ng-click="FinalSequence(item)"> <a href="#!FeatureConfig"> <i class="fa fa-exchange"></i></a></button>
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

<div class="row pagefootert" ng-style="pagefooterstyle">
    <div class="col-sm-12">
        <div class="row pagefooter">
            <div class="col-md-6">
                <span class="input-group-addon">Active Customer</span>
                <select class="btn btn-outline-secondary" name="users" ng-options="user.name for user in customers" ng-model="currentCustomer" ng-change="FeatureCustomer(currentCustomer,'CustomerName')">
                    <option value="">Selected: <%currentCustomers%></option>
                </select>
                <!-- <select class="btn btn-outline-secondary" ng-model="currentCustomer" ng-change="FeatureCustomer(currentCustomer,'CustomerName')">
                    <option ng-repeat="item in customers" value="<%item%>"><%item.name%></option>
                </select> -->
            </div>
            <div class="col-md-6" style=" text-align: right;">
                <button class="btn btn-secondary onlinetablecreateuserbtn" ng-class="{disabled:currentPage == 0}">
                    <a style="color:white;" href ng-click="prevPage()">« Prev</a>
                </button>
                <button class="btn btn-secondary onlinetablecreateuserbtn" ng-repeat="n in range(pagedItems.length, currentPage, currentPage + gap) " ng-class="{active: n == currentPage}" ng-click="setPage()"> <a style="color:white;" href ng-bind="n + 1">1</a>
                </button>
                <button class="btn btn-secondary onlinetablecreateuserbtn" ng-class="{disabled: (currentPage) == pagedItems.length - 1}">
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
            <div class="modalbody" ng-style="modalbodyshow" ng-class="{modalbodyshow:modal == true}">
                <div ng-style="alertbox" style="display:none; width: 100%; height:20px; border:1px solid rgb(128, 218, 68); background:rgba(75, 48, 48, 0.589); border-radius:5px;">
                    <p style="text-align: center; color:white;">Alert: <% serverMessage %><a style="float:right; cursor:pointer;" ng-click="serverAlertHide()"><i class="fa fa-times"></i></a></p>
                </div>
                <div id="CRUDModal">
                    <div ng-repeat="item in formFields.file">
                        <label><%item.label%></label>
                        <div class="newregisterimage">
                            <input type="file" custom-on-change="uploadFile" />
                            <img ng-src="<% item.value %>" width="100px" height="100px" alt="Profile Pic">
                        </div>
                    </div>
                    <div ng-repeat="item in formFields.text">
                        <label><%item.label%></label>
                        <input class="form-control" type="text" ng-model="item.value">
                    </div>
                    <div ng-repeat="item in formFields.dropdown">
                        <label><%item.label%></label>
                        <select class="form-control" type="text" ng-model="item.value">
                            <option ng-repeat="opt in item.options" value="<%opt%>">
                                <%opt%>
                            </option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="modalfooter">
                <button type="button" ng-click="ModalRequest()" style="z-index:1000;"><%modalbutton%></button>
                <button type="button" data-dismiss="modal" style="z-index:1000;">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="Gridmodal" tabindex="-1" role="dialog" aria-labelledby="Gridmodal" aria-hidden="true">
    <div class="modal-dialog" ng-class="{'modal-sm':m_type == 'sm', 'modal-lg':m_type == 'lg','modal-xl':m_type == 'xl'}">
        <div class="modal-content">
            <div class="modalheader">
                <h6 class="modal-title" id="Gridmodal"><%modalheader%></h6>
            </div>
            <div id="modalcontent2" class="modalbody" ng-style="modalbodyshow" ng-class="{modalbodyshow:modal == true}">
                <div ng-style="alertbox" style="display:none; width: 100%; height:20px; border:1px solid rgb(128, 218, 68); background:rgba(75, 48, 48, 0.589); border-radius:5px;">
                    <p style="text-align: center; color:white;">Alert: <% serverMessage %><a style="float:right; cursor:pointer;" ng-click="serverAlertHide()"><i class="fa fa-times"></i></a></p>
                </div>
                <div ng-repeat="item in formFields.callocation">
                    <div class="row customermodalheader">
                        <div class="left">
                            <p>Customer : <b><img ng-src="<%item.Avatar.url%>" height="25" width="25"> <%item.Name.value%></b></p>
                        </div>
                        <div class="right">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active " id="#" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" ng-click="tabchange('Administrator')"><i class="fa fa-user"> Administrator</i> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="#" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false" ng-click="tabchange('Operator')"><i class="fa fa-user"> Operator</i> </a>
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
                                            <div> <b>Name:</b> <%indv.name%></div>
                                            <div><b>Email:</b> <%indv.email%></div>
                                            <div><b>Pnone:</b> <%indv.phone%></div>
                                        </div>
                                        <div class="classtwo">
                                            <button class="btn"> <i class="fa fa-envelope"></i></button>
                                            <button class="btn"> <i class="fa fa-trash"></i></button>
                                            <button class="btn"> <i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-container1">
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
                <button type="button" ng-click="ModalRequest()" style="z-index:1000;"><%modalbutton%></button>
                <button type="button" data-dismiss="modal" style="z-index:1000;">Close</button>
            </div>
        </div>
    </div>
</div>