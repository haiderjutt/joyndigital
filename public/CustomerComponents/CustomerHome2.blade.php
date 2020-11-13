<div class="cust-mainbody">
    <div class="cust_side" ng-style="sidestyle">
        <div class="lat-sidebarcont" ng-style="sibarcontstyle" id="accordion">
            <div class="cust_sideheader"> Selected Configuration</div>
            <div class="custentries1">
                <h6>Basic Info</h6>
                <div class="custentries11" ng-repeat="(key, value) in items['Input']">
                    <div>
                        <div class="custentries111" >
                        <b style="color:wheat;"><% value.field_name %></b>
                        </div>
                        <div class="custentries112">
                            <div ng-repeat="x in value.output"><%x.name%>,</div>


                        </div>
                    </div>
                </div>
                <div class="custentries11" ng-repeat="(key, value) in items['Dropdown']">
                    <div>
                        <div class="custentries111" >
                            <b style="color:wheat;"><% value.field_name %></b>
                        </div>
                        <div class="custentries112">
                            <div ng-repeat="x in value.output"><%x.name%>,</div>


                        </div>
                    </div>
                </div>
                <div class="custentries11" ng-repeat="(key, value) in items['Controlled']">
                    <div>
                        <div class="custentries111" >
                        <b style="color:wheat;"><% value.field_name %></b>
                        </div>
                        <div class="custentries112">
                            <div ng-repeat="x in value.output"><%x.name%>,</div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="custentries2">
                <h6>Date</h6>
                <div class="custentries21" ng-repeat="(key, value) in items['Date']">
                    <div>
                        <div class="custentries211">
                        <b style="color:wheat;"><% value.field_name %></b>
                        </div>
                        <div class="custentries212">
                        <div><%value.from%> <b> to </b> </div>
                            <div> <%value.to%></div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="custentries3">
                <h6>Range</h6>
                <div class="custentries31" ng-repeat="(key, value) in items['Range']">
                    <div>
                        <div class="custentries311">
                        <b style="color:wheat;"><% value.field_name %></b>
                        </div>
                        <div class="custentries312" >
                            <div><%value.from%> <b> to </b> </div>
                            <div> <%value.to%></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
</div>