
 
<div class="alertbox col-md-12" ng-style="alertboxjs" ng-model="alertmessage">
        <span class="closebtn" style="color:darkblue;" ng-click="hidealert()">&times;</span> 
        <strong>Alert :</strong> <%alertmessage%>
    </div> 
<div class="customerform" ng-style="customerformstyle">

    <div class="leftside" ng-style="leftsidestyle">
    <h5 class="heading1">Locations</h5>
        <div class="leftsidetop" ng-style="leftsidetopstyle">
          
            <div ng-style="leftsidetopstyle1">
              <label for="Latitude" ng-style="leftsidetopstyle2">Latitude</label><br>
              <input ng-style="leftsidetopstyle2" class="form-control" type="text" ng-model="lat" ng-change="markerposition()">
            </div>
            <div ng-style="leftsidetopstyle1">
              <label for="Latitude" ng-style="leftsidetopstyle2">Longitude</label><br>
              <input ng-style="leftsidetopstyle2" class="form-control" type="text" ng-model="long" ng-change="markerposition()">
            </div>
        </div>
        <h5 class="heading1" class="heading1">Text Fields</h5 >
        <div class="leftsideone" >
            <div  ng-repeat="(key, item) in inputform.form.Input" ng-style="leftsideonestyle">
              <label for=""><%item.field_name%></label><br>
              <input type="text" ng-model="item.value" class="form-control" placeholder="Enter here" ng-style="leftsideone1style">
            </div>
            <div  ng-repeat="(key, item) in inputform.form.Range" ng-style="leftsideonestyle">
              <label for=""><%item.field_name%></label><br>
              <input type="number" ng-model="item.value" class="form-control" placeholder="Enter here" ng-style="leftsideone1style">
            </div>
        </div>
        <h5 class="heading1">Date Fields</h5>
        <div class="leftsidetwo" >
            <div  ng-repeat="item in inputform.form.Date" ng-style="leftsideonestyle">
              <label for=""><%item.field_name%></label><br>
              <input type="date" ng-model="item.value" class="form-control" placeholder="Enter here" ng-style="leftsideone1style">
            </div>
        </div>
        <h5 class="heading1">DropDown Fields</h5 class="heading1">
        <div class="leftsidethree" >
          <div ng-repeat="item in inputform.form.Dropdown"  ng-style="leftsideonestyle" >
              <label><%item.field_name%></label><br>
              <select type="text" ng-model="item.value" ng-style="leftsideone1style" ng-options="option.field_name as option.field_name for option in inputform.form.Option[item.field_name]">

              </select>
          </div>
        </div>
        <div class="leftsidefour" >
          <div ng-repeat="item in inputform.form.Controlled"  ng-style="leftsideonestyle" >
              <label><%item.field_name%></label><br>
              <select type="text" ng-model="item.value" ng-style="leftsideone1style" ng-options="option.field_name as option.field_name for option in inputform.form.Option[item.field_name]">
              </select>
          </div>
        </div>
    </div>
    <div class="rightside" ng-style="rightsidestyle">
    <div class="cform">
        <div class="cform1">
           <span class="input-group-addon">Latitude</span>
           <input type="text" placeholder="Search" class="form-control" ng-change="windowposition()" ng-model="maplat">
        </div>
        <div class="cform2">
          <span class="input-group-addon">Longitude</span>
          <input type="text" placeholder="Search" class="form-control" ng-change="windowposition()" ng-model="maplong">
        </div>
        <div class="cform3">
          <span class="input-group-addon">Search Area</span>
          <input type="text" placeholder="Search" class="form-control controls" id="pac-input">
        </div>
        <div class="cform4">
        <button class="btn btn-outline-secondary">Reset</button>
        </div>
     </div>
      <div id="googleMap" ng-style="rightsidestylemap"></div>
      <div class="sitesdetail">
        
        <div class="sitesdetail3">
        <h6><u>Project Data Entry Trend</u></h6>
         <canvas id="line" class="chart chart-line" chart-data="dataaa" style="width:50%; height:90%;"
            chart-labels="labelsss" chart-series="seriesss" chart-options="optionsss"
            chart-dataset-override="datasetOverride">
            </canvas>
        </div>
     
        <div class="sitesdetail4">
        <h6><u>Your Data Entry Trend</u></h6>
        <canvas id="line" class="chart chart-line" chart-data="dataaa" style="width:50%; height:90%;"
          chart-labels="labelsss" chart-series="seriesss" chart-options="optionsss"
          chart-dataset-override="datasetOverride">
          </canvas>
        </div>
        <div class="sitesdetail1">
          <h6><u>Project Data Information</u> </h6>
          <div><b>Allowed Sites :</b><%currCustomer.allowed_entries%></div>
          <div><b>Entered Sites :</b> <%currCustomer.entries_done%></div>
          <div><b>Your Entries :</b> <%currCustomer.entries_done%></div>
        </div>
        <div class="sitesdetail2">
        <h6><u>Customer Information Information</u></h6>
        <div><b>Name :</b> <%currCustomer.name%></div>
          <div><b>Email :</b> <%currCustomer.email%></div>
          <div><b>Phone :</b> <%currCustomer.phone%></div>
        </div>
      </div>
    </div>
</div>
<div class="formfooter" ng-style="formfooterstyle">
      <div class="formfooter1">
      <span class="input-group-addon">Active Customer</span>
      <select class="btn btn-outline-secondary" ng-model="currentCustomer" ng-change="FormCustomer(currentCustomer,'CustomerName')">
          <option ng-repeat="item in customers" value="<%item%>"><%item.name%></option>
        </select>
        <span class="input-group-addon">Active Site</span>
      <select class="btn btn-outline-secondary" ng-model="currentSite" ng-change="FormCustomer(currentSite,'SiteId')">
          <option ng-repeat="item in sites" value="<%item%>"><%item.id%></option>
        </select>
      </div >

      <div class="formfooter2">
      <button ng-click="FormData()" class="btn btn-outline-secondary">Enter Data</button>
      </div>
      <div class="formfooter3">
      <button ng-repeat="i in [1, 2, 3, 4]" class="btn btn-outline-secondary">Feature <%i%></button>
      </div>
</div>
