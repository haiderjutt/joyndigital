
  <div class="cform">
        <div class="cform1"><input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch"></div>
        <div class="cform2"><input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch"></div>
        <div class="cform3"><input type="text" ng-model="test" placeholder="Search" class="onlinetablesearch"></div>
  </div>
<div class="customerform">
    <div class="leftside">
        <div class="leftsidetop">
            <div>
              <label for="Latitude">Latitude</label><br>
              <input type="text" ng-model="latitude" id="" placeholder="Enter Latitude">
            </div>
            <div >
              <label for="Longitude">Longitude</label><br>
              <input type="text" ng-model="longitude" id="" placeholder="Enter Longitude">
            </div>
        </div>
        <div class="leftsideone">
            <div  ng-repeat="item in inputform.form.Input">
              <label for=""><%item.field_name%></label><br>
              <input type="text" ng-model="item.value" placeholder="Enter here">
            </div>
        </div>
        
        <div class="leftsidetwo">
            <div  ng-repeat="item in inputform.form.Date">
              <label for=""><%item.field_name%></label><br>
              <input type="date" ng-model="item.value" placeholder="Enter here">
            </div>
        </div>
        <div class="leftsidethree">
             <div ng-repeat="item in inputform.form.Dropdown" >
                    <label><%item.field_name%></label>
                    <select class="form-control" type="text" ng-model="item.value">
                        <option ng-repeat="opt in inputform.form.Option[item.field_name]">
                          <%opt.field_name%>
                        </option>
                    </select>
                </div> 
        </div>
        <div class="leftsidefour">
          <button>Submit</button>
        </div>
    </div>
    <div class="rightside">
       <div id="googleMap"></div>
    </div>
    <div class=""></div>
</div>
