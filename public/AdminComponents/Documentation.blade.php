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
                        
                        <th class="field5 " custom-sort order="'field5'" sort="sort"><b class="onlinetableheaderth">Actions&nbsp;</b></th>
                    </tr>
                </thead>


                <tbody style="font-size: 12px; background-color:#141414; cursor:pointer;">
                    <tr ng-repeat="item in pagedItems[currentPage] | orderBy:sort.sortingOrder:sort.reverse | filter:test" style="border-bottom:1px solid rgba(22, 99, 241, 0.849)">
                        <td><%item.field_name%></td>

                        <td class="menu1">
                            <label class="menu-open-button1">
                                <i class="fa fa-cogs"></i>
                            </label>
                            <button class="menu-item1 blue btn" title="Edit" ng-click="FinalSequence(item,'lg','Update')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-edit"></i></button>
                            
                            <button class="menu-item1 blue btn" title="Delete" ng-click="FinalSequence(item,'sm','Delete')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-trash"></i></button>
                           

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
                <button class="btn btn-outline-secondary onlinetablecreateuserbtn" ng-click="FinalSequence(item,'lg','New')" data-toggle="modal" data-target="#FinalModal"><i style="color:white;" class="fa fa-user"></i> New Domument Type</button>
                <span class="input-group-addon">Active Customer</span>
      <select class="btn btn-outline-secondary" ng-model="currentCustomer" ng-change="FormCustomer(currentCustomer,'CustomerName')">
          <option ng-repeat="item in customers" value="<%item%>"><%item.name%></option>
        </select>
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

                    <div ng-repeat="item in formFields.text">
                        <label><%item.label%></label>
                        <input class="form-control" type="text" ng-model="item.value">
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

