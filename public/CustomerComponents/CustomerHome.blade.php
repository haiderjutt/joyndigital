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
    <div class="cust_main1" ng-style="mainstyle">
        <div class="firstsecond1">
            <div id="googleMap"></div>
        </div>
    </div>
</div>

<div class="row markerinfostyle" id="markerinfostyle">
    <div class="markerinfo" >
        <div class="markerinfo1">
            <i class="fa fa-times-circle" ng-click="markerinfo('markerinfostyle')"></i>
        </div>
        <div class="markerinfo2">
            <div class="markerinfo21" >
                <p ng-repeat="(key, value) in items['Current'][0]" ng-if="!['id','created_by_id','created_by_id','updated_by','updated_by_id','updated_at','created_by','created_at','site_cost'].includes(key)"> <b><%key%> :</b> <%value%> <br></p>
            </div>
        </div>
    </div>
</div>
<!-- //ng-style="chartsinfostyle" -->
<div class="row chartsinfo" ng-style="chartsinfostyle">
    <div class="infobuttons">
        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#myModal">Show Filters</button>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog"></div>
    <div class="modal-content animate-bottom" style="background-color: rgba(0, 0, 0, .6); color:white;">
        <div class="modal-body row xl"  style="padding-bottom: 0px; padding-top: 0px;">
            <div class="customerfilters">
                <div class="customerfilters3">
                    <div class="customerfilters31">
                        <div ng-repeat="(key, value) in items['Input']" class="customerfilters311">
                            <div class="fieldtitle" ><%value.field_name%></div>
                            <div isteven-multi-select="" input-model="value.option" output-model="value.output" button-label="icon name" item-label="icon name maker" tick-property="ticked" class="ng-isolate-scope"><span class="multiSelect inlineBlock">
                                    <button type="button" ng-click="toggleCheckboxes( $event ); refreshSelectedItems(); refreshButton(); prepareGrouping; prepareIndex();" ng-bind-html="varButtonLabel" ng-disabled="disable-button" class="ng-binding">
                                    </button>
                                    <div class="checkboxLayer">
                                        <div class="helperContainer ng-scope" ng-if="helperStatus.filter || helperStatus.all || helperStatus.none || helperStatus.reset ">
                                            <div class="line ng-scope" ng-if="helperStatus.all || helperStatus.none || helperStatus.reset ">
                                                <button type="button" class=" font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; ng-binding ng-scope" ng-disabled="isDisabled" ng-if="helperStatus.all" ng-click="select( 'all', $event );" ng-bind-html="lang.selectAll">✓&nbsp;&nbsp;Select All</button>
                                                <button type="button" class="helperButton ng-binding ng-scope" ng-disabled="isDisabled" ng-if="helperStatus.none" ng-click="select( 'none', $event );" ng-bind-html="lang.selectNone">×&nbsp;&nbsp;Select None</button>
                                                <button type="button" class="helperButton reset ng-binding ng-scope" ng-disabled="isDisabled" ng-if="helperStatus.reset" ng-click="select( 'reset', $event );" ng-bind-html="lang.reset">
                                                    ↶&nbsp;&nbsp;Reset</button>
                                            </div>
                                            <div class="line ng-scope" style="position:relative" ng-if="helperStatus.filter"><input placeholder="Search..." type="text" ng-click="select( 'filter', $event )" ng-model="inputLabel.labelFilter" ng-change="searchChanged()" class="inputFilter ng-pristine ng-untouched ng-valid"><button type="button" class="clearButton" ng-click="clearClicked( $event )">×</button> </div>
                                        </div>
                                        <div class="checkBoxContainer">
                                            <div ng-repeat="item in x | filter:removeGroupEndMarker" class="multiSelectItem ng-scope selected vertical" ng-class="{selected: item[ tickProperty ], 
                                                horizontal: orientationH, vertical: orientationV, multiSelectGroup:item[ groupProperty ], disabled:itemIsDisabled( item )}" ng-click="syncItems( item, $event, $index );" ng-mouseleave="removeFocusStyle( tabIndex );">
                                                <div class="acol"><label><input class="checkbox focusable" type="checkbox" ng-disabled="itemIsDisabled( item )" ng-checked="item[ tickProperty ]" ng-click="syncItems( item, $event, $index )" checked="checked"><span ng-class="{disabled:itemIsDisabled( item )}" ng-bind-html="writeLabel( item, 'itemLabel' )" class="ng-binding"></span></label></div>
                                                <span class="tickMark ng-binding ng-scope" ng-if="item[ groupProperty ] !== true &amp;&amp; 
                                                    item[ tickProperty ] === true" ng-bind-html="icon.tickMark">✓</span>
                                            </div>

                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div ng-repeat="(key, value) in items['Dropdown']" class="customerfilters311">
                            <div class="fieldtitle"><%value.field_name%></div>
                            <div>
                                <div isteven-multi-select="" input-model="value.option" output-model="value.output" button-label="icon name" item-label="icon name maker" tick-property="ticked" class="ng-isolate-scope"><span class="multiSelect inlineBlock">
                                        <button type="button" ng-click="toggleCheckboxes( $event ); refreshSelectedItems(); refreshButton(); prepareGrouping; prepareIndex();" ng-bind-html="varButtonLabel" ng-disabled="disable-button" class="ng-binding">
                                        </button>
                                        <div class="checkboxLayer">
                                            <div class="helperContainer ng-scope" ng-if="helperStatus.filter || helperStatus.all || helperStatus.none || helperStatus.reset ">
                                                <div class="line ng-scope" ng-if="helperStatus.all || helperStatus.none || helperStatus.reset ">
                                                    <button type="button" class="helperButton ng-binding ng-scope" ng-disabled="isDisabled" ng-if="helperStatus.all" ng-click="select( 'all', $event );" ng-bind-html="lang.selectAll">✓&nbsp;&nbsp;Select All</button>
                                                    <button type="button" class="helperButton ng-binding ng-scope" ng-disabled="isDisabled" ng-if="helperStatus.none" ng-click="select( 'none', $event );" ng-bind-html="lang.selectNone">×&nbsp;&nbsp;Select None</button>
                                                    <button type="button" class="helperButton reset ng-binding ng-scope" ng-disabled="isDisabled" ng-if="helperStatus.reset" ng-click="select( 'reset', $event );" ng-bind-html="lang.reset">
                                                        ↶&nbsp;&nbsp;Reset</button>
                                                </div>
                                                <div class="line ng-scope" style="position:relative" ng-if="helperStatus.filter"><input placeholder="Search..." type="text" ng-click="select( 'filter', $event )" ng-model="inputLabel.labelFilter" ng-change="searchChanged()" class="inputFilter ng-pristine ng-untouched ng-valid"><button type="button" class="clearButton" ng-click="clearClicked( $event )">×</button> </div>
                                            </div>
                                            <div class="checkBoxContainer">
                                                <div ng-repeat="item in x | filter:removeGroupEndMarker" class="multiSelectItem ng-scope selected vertical" ng-class="{selected: item[ tickProperty ], 
                                                horizontal: orientationH, vertical: orientationV, multiSelectGroup:item[ groupProperty ], disabled:itemIsDisabled( item )}" ng-click="syncItems( item, $event, $index );" ng-mouseleave="removeFocusStyle( tabIndex );">
                                                    <div class="acol"><label><input class="checkbox focusable" type="checkbox" ng-disabled="itemIsDisabled( item )" ng-checked="item[ tickProperty ]" ng-click="syncItems( item, $event, $index )" checked="checked"><span ng-class="{disabled:itemIsDisabled( item )}" ng-bind-html="writeLabel( item, 'itemLabel' )" class="ng-binding"></span></label></div>
                                                    <span class="tickMark ng-binding ng-scope" ng-if="item[ groupProperty ] !== true &amp;&amp; 
                                                    item[ tickProperty ] === true" ng-bind-html="icon.tickMark">✓</span>
                                                </div>

                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div ng-repeat="(key, value) in items['Controlled']" class="customerfilters311">
                            <div class="fieldtitle"><%value.field_name%></div>
                            <div>
                                <div isteven-multi-select="" input-model="value.option" output-model="value.output" button-label="icon name" item-label="icon name maker" tick-property="ticked" class="ng-isolate-scope"><span class="multiSelect inlineBlock">
                                        <button type="button" ng-click="toggleCheckboxes( $event ); refreshSelectedItems(); refreshButton(); prepareGrouping; prepareIndex();" ng-bind-html="varButtonLabel" ng-disabled="disable-button" class="ng-binding">
                                        </button>
                                        <div class="checkboxLayer">
                                            <div class="helperContainer ng-scope" ng-if="helperStatus.filter || helperStatus.all || helperStatus.none || helperStatus.reset ">
                                                <div class="line ng-scope" ng-if="helperStatus.all || helperStatus.none || helperStatus.reset ">
                                                    <button type="button" class="helperButton ng-binding ng-scope" ng-disabled="isDisabled" ng-if="helperStatus.all" ng-click="select( 'all', $event );" ng-bind-html="lang.selectAll">✓&nbsp;&nbsp;Select All</button>
                                                    <button type="button" class="helperButton ng-binding ng-scope" ng-disabled="isDisabled" ng-if="helperStatus.none" ng-click="select( 'none', $event );" ng-bind-html="lang.selectNone">×&nbsp;&nbsp;Select None</button>
                                                    <button type="button" class="helperButton reset ng-binding ng-scope" ng-disabled="isDisabled" ng-if="helperStatus.reset" ng-click="select( 'reset', $event );" ng-bind-html="lang.reset">
                                                        ↶&nbsp;&nbsp;Reset</button>
                                                </div>
                                                <div class="line ng-scope" style="position:relative" ng-if="helperStatus.filter"><input placeholder="Search..." type="text" ng-click="select( 'filter', $event )" ng-model="inputLabel.labelFilter" ng-change="searchChanged()" class="inputFilter ng-pristine ng-untouched ng-valid"><button type="button" class="clearButton" ng-click="clearClicked( $event )">×</button> </div>
                                            </div>
                                            <div class="checkBoxContainer">
                                                <div ng-repeat="item in x | filter:removeGroupEndMarker" class="multiSelectItem ng-scope selected vertical" ng-class="{selected: item[ tickProperty ], 
                                                horizontal: orientationH, vertical: orientationV, multiSelectGroup:item[ groupProperty ], disabled:itemIsDisabled( item )}" ng-click="syncItems( item, $event, $index );" ng-mouseleave="removeFocusStyle( tabIndex );">
                                                    <div class="acol"><label><input class="checkbox focusable" type="checkbox" ng-disabled="itemIsDisabled( item )" ng-checked="item[ tickProperty ]" ng-click="syncItems( item, $event, $index )" checked="checked"><span ng-class="{disabled:itemIsDisabled( item )}" ng-bind-html="writeLabel( item, 'itemLabel' )" class="ng-binding"></span></label></div>
                                                    <span class="tickMark ng-binding ng-scope" ng-if="item[ groupProperty ] !== true &amp;&amp; 
                                                    item[ tickProperty ] === true" ng-bind-html="icon.tickMark">✓</span>
                                                </div>

                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="customerfilters2">
                    <div class="customerfilters21">
                        <div ng-repeat="(key, value) in items['Range']">
                            <div class="fieldtitle"><%value.field_name%></div>
                            <div class="customerfilters211">
                                <input type="number" ng-model="value.from">
                                <div style="font-size:10px; font-weight:bold;">To</div>
                                <input type="number" ng-model="value.to">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="customerfilters1">
                    <div class="customerfilters11">
                        <div ng-repeat="(key, value) in items['Date']">
                            <div class="fieldtitle"><%value.field_name%></div>
                            <div class="customerfilters111">
                                <div>
                                    <input type="date"  ng-model="value.from">
                                </div>
                                <div style="font-size:10px; font-weight:bold;">To</div>
                                <div>
                                    <input type="date"  ng-model="value.to">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="customerfiltersbutton">
                <div class="customerfiltersbutton1">
                    <div class="customerfiltersbutton11">
                        <h6>Basic search</h6>
                    </div>
                    <div class="customerfiltersbutton111">
                        <button class="btn btn-outline-secondary" data-dismiss="modal" ng-click="isShowHide(showcontrol)">Submit</button>
                    </div>
                </div>
                <div class="customerfiltersbutton2">
                    <div class="customerfiltersbutton21">
                        <h6>Range search</h6>
                    </div>
                    <div class="customerfiltersbutton211">
                        <button class="btn btn-outline-secondary" data-dismiss="modal" ng-click="isShowHide(showcontrol)">Submit</button>
                    </div>
                </div>
                <div class="customerfiltersbutton3">
                    <div class="customerfiltersbutton31">
                        <h6>Date search</h6>
                    </div>
                    <div class="customerfiltersbutton311">
                        <button class="btn btn-outline-secondary" data-dismiss="modal" ng-click="isShowHide(showcontrol)">Submit</button>
                    </div>
                </div>
            </div>
            <div class="customerfiltersbuttonsecond">
                <div class="first">
                    <h6>All filter Search</h6>
                </div>
                <div class="second">
                    <button class="btn btn-outline-secondary" data-dismiss="modal" ng-click="isShowHide(showcontrol)">Search All</button>
                </div>
            </div>

        </div>
    </div>