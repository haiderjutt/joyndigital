<div class="ohomepage">
    <div class="ohomepageL">
        <div class="page1">
            <div class="page11">
                <select>
                    <option value="">1</option>
                    <option value="">1</option>
                    <option value="">1</option>
                    <option value="">1</option>
                    <option value="">1</option>
                    <option value="">1</option>
                </select>
            </div>
            <div class="page12"></div>
            <div class="page13"><input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch"></div>
        </div>
        <div class="page2">
            <div class="page21">
                    <div class="page211">
                            <p style="font-size:12px;  padding-left:15px;"> <b>Items Per Page </b>  : </p>
                            <u style="font-size:12px;  padding-left:15px; padding-right:15px;"><%myValue%></u>
                            <select  ng-model="myValue" ng-change="myFunc()">
                                <option value="5" >5</option>
                                <option value="25" >25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="500">500</option>
                                <option value="1000">1000</option>
                                <option value="2000">2000</option>
                            </select>
                    </div>
                
                    <div class="page212" style="color:white;"> <b>Page</b> : <u><%currentPage+1|json%></u> <b>of</b> <u><%pagedItems.length|json%></u></div>
                    
            </div> 
            <div >
                <table class="onlinetable">
                    <thead class="onlinetableheader">
                        <tr >
                            <th class="name" custom-sort order="'name'" sort="sort" ><b  class="onlinetableheaderth">Name &nbsp;</b> <i class="fa fa-sort" id="flipflop"></i></th>
                            <th class="username" custom-sort order="'username'" sort="sort"><b  class="onlinetableheaderth">Username &nbsp;</b> <i class="fa fa-sort" id="flipflop"></i></th>
                            <th class="email" custom-sort order="'email'" sort="sort"> <b  class="onlinetableheaderth">Email &nbsp;</b><i class="fa fa-sort" id="flipflop"></i></th>
                            <th class="field3" custom-sort order="'field3'" sort="sort"> <b  class="onlinetableheaderth">Phone &nbsp;</b><i class="fa fa-sort" id="flipflop"></i></th>
                            <th class="field4" custom-sort order="'field4'" sort="sort"> <b  class="onlinetableheaderth">Ban Status &nbsp;</b><i class="fa fa-sort" id="flipflop"></i></th>
                            <th class="field5" custom-sort order="'field5'" sort="sort"> <b  class="onlinetableheaderth">Role &nbsp;</b><i class="fa fa-sort" id="flipflop"></i></th>
                            <th class="field6" custom-sort order="'field6'" sort="sort"> <b  class="onlinetableheaderth">Actions &nbsp;</b></th>
                        </tr>
                    </thead>
                            
                    <tbody style="font-size: 12px; background-color:#141414; hover:pointer;">
                        <tr ng-repeat="item in pagedItems[currentPage] | orderBy:sort.sortingOrder:sort.reverse | filter:test" class="tableentries">
                            <td><%item.name%></td>
                            <td><%item.username%></td>
                            <td><%item.email%></td>
                            <td><%item.phone%></td>
                            <td><%item.ban%></td>
                            <td><%item.role%></td>
                            <td class="menu1">
                                <label class="menu-open-button1">
                                    <i class="fa fa-cogs"></i>
                                </label>
                                <button  class="menu-item1 blue btn" title="Edit" ng-click="FinalSequence(item,'lg','Update')" data-toggle="modal" data-target="#FinalModal" ><img class="menu-item1 blue" src="./images/icons/Edit.png" height="60" width="60"> </button>
                                <button  class="menu-item1 blue btn" title="Change Pass" ng-click="FinalSequence(item,'sm','Password')" data-toggle="modal" data-target="#FinalModal" ><img class="menu-item1 blue" src="./images/icons/Password.png" height="60" width="60"></button>
                                <button  class="menu-item1 blue btn" title="Delete" ng-click="FinalSequence(item,'sm','Delete')" data-toggle="modal" data-target="#FinalModal" ><img class="menu-item1 blue" src="./images/icons/Delete.png" height="60" width="60"></button> 
                                <button  class="menu-item1 blue btn"  title="Ban" ng-click="FinalSequence(item,'sm','Ban')" data-toggle="modal" data-target="#FinalModal"><img class="menu-item1 blue" src="./images/icons/BanJoyn.png" height="60" width="60"></button> 
                                <button class="menu-item1 blue btn" ng-if="item.role == 'Customer'" ng-click="GlobalSequence(item.id)" title="Fields Configurations"><a href="#!InternalTemplate"   style="font-size:12px; color:white;"><i class="fa fa-list-ol"></i></a></button>
                                <button  class="menu-item1 blue btn"  title="Allocation" ng-if="item.role != 'Customer' && item.role != 'Super Admin'" ng-click="FinalSequence(item,'lg','Allocation')" data-toggle="modal" data-target="#FinalModal"><i class="fa fa-exchange"></i> </button>
                            
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
        
            </div>
        </div>
        <div class="page3">
            <div class="page31">
            <button class="blue btn btn-primary" title="Customerform"><a href="#!customersform"   style="font-size:12px; color:white;"> Enter New Site <img style="margin-top:-4px" src="./images/icons/Edit.png" height="30" width="30"></a></button>
            <button class="blue btn btn-primary" title="Customerform"><a href="#!customersform"   style="font-size:12px; color:white;"> Enter New Site <img style="margin-top:-4px" src="./images/icons/Edit.png" height="30" width="30"></a></button>
            <button class="blue btn btn-primary" title="Customerform"><a href="#!customersform"   style="font-size:12px; color:white;"> Enter New Site <img style="margin-top:-4px" src="./images/icons/Edit.png" height="30" width="30"></a></button>
            <button class="blue btn btn-primary" title="Customerform"><a href="#!customersform"   style="font-size:12px; color:white;"> Enter New Site <img style="margin-top:-4px" src="./images/icons/Edit.png" height="30" width="30"></a></button>
            </div>
            <div class="page32">
                <div>
                    <button class="btn btn-secondary "  ng-class="{disabled:currentPage == 0}">
                    <a style="color:white;" href ng-click="prevPage()">« Prev</a>
                    </button>
                    <button class="btn btn-secondary "  ng-repeat="n in range(pagedItems.length, currentPage, currentPage + gap) "
                        ng-class="{active: n == currentPage}" ng-click="setPage()"> <a style="color:white;" href ng-bind="n + 1">1</a> 
                    </button>
                    <button class="btn btn-secondary "  ng-class="{disabled: (currentPage) == pagedItems.length - 1}">
                            <a style="color:white;" href ng-click="nextPage()">Next »</a> 
                    </button> 
                </div>
                
            </div>
        </div>
    </div>
    <div class="ohomepageR">
        <div></div>
    </div>
</div>
