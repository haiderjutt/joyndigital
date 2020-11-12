<div class="col-md-3 left_col">
    <div class="left_col scroll-view" >
      <div class="navbar nav_title" style="border: 0;" >
        <a href="" class="site_title latitude1" style="margin-top:-30px;"><img src="https://img.icons8.com/officel/80/000000/globe-earth.png" width=50/></a>
        <svg class="latitude" viewBox="0 0 600 400" title="new here" >
            <symbol id="s-text" class="prom">
                <text text-anchor="middle" x="50%" y="60">Latitude</text>
            </symbol>

            <g class = "g-ants">
                <use xlink:href="#s-text" class="text-copy"></use>
                <use xlink:href="#s-text" class="text-copy"></use>
                <use xlink:href="#s-text" class="text-copy"></use>
                <use xlink:href="#s-text" class="text-copy"></use>
                <use xlink:href="#s-text" class="text-copy"></use>
                <use xlink:href="#s-text" class="text-copy"></use>
            </g>
        </svg>
        
      </div>

      <div class="clearfix"></div>

      <!-- menu profile quick info -->
      <div class="profile clearfix">
        <div class="profile_pic">
          <img src="images/user.png" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
          <span>Welcome,</span>
          <h2>{{ Auth::user()->name }}</h2>
        </div>
      </div>
      <!-- /menu profile quick info -->

      <br />

      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu" >
        <div class="menu_section">
          <h3>Admin Dashboard</h3>
          <ul class="nav side-menu">
            <li><a id="opt_home" href="#!"><i class="fa fa-home"></i> Home</a></li>
            <li><a id="opt_customers" href="#!AllCustomers"><i class="fa fa-user-secret"></i> Customers</a></li>
            <li><a><i class="fa fa-users"></i> Workers <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a id="opt_administrators" href="#!AllAdministrator"><i class="fa fa-user"></i> Administrator</a>
                <li><a id="opt_operators" href="#!AllOperators"><i class="fa fa-user-md"></i> Operators</a></li>
                <li><a id="opt_agents" href="#!AllAgents"><i class="fa fa-road"></i> Agents</a></li>
                <li><a id="opt_vendors" href="#!AllVendors"><i class="fa fa-male"></i> Vendors</a></li>
              </ul>
            </li>
            
            
            
            
            <li><a id="opt_packages" href="#!AllPackages"><i class="fa fa-money"></i> Packages</a></li>
            <li><a id="opt_templates" href="#!AllTemplates"><i class="fa fa-list-ol"></i> Templates</a></li>
            
            

            <li><a><i class="fa fa-cubes"></i> Others <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                
                  <li><a id="opt_inventory" href="#!Inventory"><i class="fa fa-houzz"></i> Inventory</a></li> 
              </ul>
            </li>
          </ul>
        </div>
      
      </div>
      <!-- /sidebar menu -->

      <!-- /menu footer buttons -->
      <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Settings">
          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
          <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Lock">
          <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
      </div>
      <!-- /menu footer buttons -->
    </div>
  </div>