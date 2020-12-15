<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
          <!--<img src="{{ asset('resources/assets/img/logo/logo.png') }}">-->
          <i class="fa fa-wifi fa-lg"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SHORIF ISP</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="{{ url("admin") }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Home</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Billing
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Users</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Users</h6>
            <a class="collapse-item" href="{{ url("admin/users") }}">View All</a>
            <a class="collapse-item" href="{{ url("admin/users/add") }}">Add New</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePPPoe" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Prepaids</span>
        </a>
        <div id="collapsePPPoe" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Prepaids</h6>
            <a class="collapse-item" href="alerts.html">Users</a>    
            <a class="collapse-item" href="alerts.html">Recharge</a>        
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayment" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Payments</span>
        </a>
        <div id="collapsePayment" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Payments</h6>
            <a class="collapse-item" href="alerts.html">Transfer</a>
            <a class="collapse-item" href="buttons.html">Transactions</a>
          </div>
        </div>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Network
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRouters" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Routers</span>
        </a>
        <div id="collapseRouters" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Routers</h6>
            <a class="collapse-item" href="{{ url("admin/routers") }}">View All</a>
            <a class="collapse-item" href="{{ url("admin/routers/add") }}">Add New</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePools" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pools</span>
        </a>
        <div id="collapsePools" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pools</h6>
            <a class="collapse-item" href="{{ url("admin/pools") }}">View All</a>
            <a class="collapse-item" href="{{ url("admin/pools/add") }}">Add New</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBandwidths" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Bandwidths</span>
        </a>
        <div id="collapseBandwidths" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Bandwidths</h6>
            <a class="collapse-item" href="{{ url("admin/bandwidths") }}">View All</a>
            <a class="collapse-item" href="{{ url("admin/bandwidths/add") }}">Add New</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePlans" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Plans</span>
        </a>
        <div id="collapsePlans" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Plans</h6>
            <a class="collapse-item" href="{{ url("admin/plans") }}">View All</a>
            <a class="collapse-item" href="{{ url("admin/plans/add") }}">Add New</a>
          </div>
        </div>
      </li>

     
      <hr class="sidebar-divider">
      <div class="version" id="version-ruangadmin">Version 1.1</div>
    </ul>