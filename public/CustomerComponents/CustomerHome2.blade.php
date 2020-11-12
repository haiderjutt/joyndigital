<div class="lat-topbar2">
    <!-- <table class="onlinetable" ng-repeat="x in items">
        <thead class="onlinetableheader">
            <tr >
                <th  ng-repeat="(key, value) in x" style="padding:3px 7px 3px 3px; border:1px solid black;"><%value%></th>
            </tr>
            <th  ng-repeat="(key, value) in x" style="padding:3px 7px 3px 3px; border:1px solid black;"><%value%></th>
        </thead> 
    </table> -->
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Open</button>
    <button type="button" class="btn btn-info"><a href="#!CustomerHome3">Open Page 3</a></button>
  </div>
<div class="cust-mainbody">
    <div class="cust_side" ng-style="sidestyle">
        <div class="lat-sidebarcont" ng-style="sibarcontstyle" id="accordion">
            <ul>
                <li>
                    <div id="optionone" class="collapse options" data-parent="#accordion"></div>
                </li>
                <li>
                    <div id="optionone" class="collapse options" data-parent="#accordion"></div>
                </li>
            </ul>
        </div>
        <div class="footer row" ng-style="sibarfooterstyle">
            <div class="col-md-12">
                <div class="row">
                <div class="col-md-6">
                    <a href="#"><i class="fa fa-power-off"></i></a>
                </div>
                <div class="col-md-6">
                    <a href="" ng-click="isShowHide(1)" value="Show Div"><i class="fa fa-chevron-left"></i></a>
                </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="cust_main" ng-style="mainstyle">
        <div>
            <div class="firstfirst"></div>
            <div class="firstsecond">
                <div id="googleMap"></div>
            </div>
        </div>
        <div>
          <div class="secondfirst">
              <div class="first"></div>
              <div class="second"></div>
              <div class="third"></div>
              <div class="four"></div>
          </div>
          <div class="secondsecond">
              <div class="first">
                 <div class="charts">
                    <canvas id="bar" class="chart chart-doughnut" style="width:100%; height:100%; margin-top:10px;" ng-style="barchart"
                        chart-data="data" chart-labels="labels" chart-options="options">
                    </canvas>
                 </div>
              </div>
              <div class="second ">
                <div class="charts">
                    <canvas id="line " class="chart chart-line" chart-data="dataaa" style="width:100%; height:100%; margin-top:10px;" ng-style="barchart"
                        chart-labels="labelsss" chart-series="seriesss" chart-options="optionsss"
                        chart-dataset-override="datasetOverride">
                    </canvas>
                </div>
              </div>
              <div class="third ">
                 <div class="charts">
                    <canvas id="bar" class="chart chart-doughnut" style="width:100%; height:100%; margin-top:10px;" ng-style="barchart"
                        chart-data="data" chart-labels="labels" chart-options="options">
                    </canvas>
                 </div>
              </div>
              <div class="four"></div>
          </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog" > 
    <div class="modal-dialog" >
      </div>
      <div class="modal-content" style="background-color: rgb(19, 18, 18); color:white;">
        <div class="modal-body" >
            <table class="onlinetable" ng-repeat="x in items">
                <thead class="onlinetableheader">
                    <tr >
                        <th  ng-repeat="(key, value) in x" style="padding:3px 7px 3px 3px; border:1px solid black;"><%value%></th>
                    </tr>
                    <tr >
                   <th ng-repeat="(key, value) in x">
                   <input list="browsers" name="browser" id="browser" ng-model="myvalue" style="padding:3px 7px 3px 3px; border:1px solid black; width:30px;">
                        <datalist  id="browsers" style="padding:3px 7px 3px 3px; border:1px solid black; width:30px;">
                            <option  ><%value%></option>
                        </datalist>
                   </th>  
                     </tr>
                </thead> 
            </table>
        </div>
        <div class="modal-footer" style="background-color: rgb(19, 18, 18); color:white;">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>