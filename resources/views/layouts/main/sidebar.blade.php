@php
  $con = explode('Controllers\\',explode('@', Route::getCurrentRoute()->getActionName())[0])[1];
  define('ROUTE_NAME',Route::getCurrentRoute()->getName());
  function checkIfActive($str){if(strpos(ROUTE_NAME,$str)!==false){return 'active';}else{ return '';}}
  function checkIfShow($str){if(strpos(ROUTE_NAME,$str)!==false){return 'show';}else{return '';}}
@endphp

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
      <li class="nav-item {{ checkIfActive('admin.users') }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="fas fa-users"></i>
          <span>Users</span>
        </a>
        <div id="collapseUsers" class="collapse {{ checkIfShow('admin.users') }}" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Users</h6>
            <a class="collapse-item {{ checkIfActive('admin.users.view') }}" href="{{ url("admin/users") }}">View All</a>
            <a class="collapse-item {{ checkIfActive('admin.users.add') }}" href="{{ url("admin/users/add") }}">Add New</a>
          </div>
        </div>
      </li>
      <li class="nav-item {{ checkIfActive('admin.prepaids') }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrepaids" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="fas fa-running"></i>
          <span>Prepaids</span>
        </a>
        <div id="collapsePrepaids" class="collapse {{ checkIfShow('admin.prepaids') }}" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Prepaids</h6>
            <a class="collapse-item {{ checkIfActive('admin.prepaids.view') }}" href="{{ url("admin/prepaids") }}">PPPoe</a>    
            <a class="collapse-item {{ checkIfActive('admin.prepaids.recharge') }}" href="{{ url("admin/prepaids/recharge") }}">Recharge</a>        
          </div>
        </div>
      </li>
      <li class="nav-item {{ checkIfActive('admin.transactions') }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayment" aria-expanded="false" aria-controls="collapseBootstrap">
         <i class="fas fa-search-dollar"></i>
          <span>Payments</span>
        </a>
        <div id="collapsePayment" class="collapse {{ checkIfShow('admin.transactions') }}" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Payments</h6>
            <a class="collapse-item {{ checkIfActive('admin.transactions.transfer') }}" href="{{ url("admin/transactions/transfer") }}">Transfer</a>
            <a class="collapse-item {{ checkIfActive('admin.transactions.view') }}" href="{{ url("admin/transactions") }}">Transactions</a>
          </div>
        </div>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Network
      </div>
      <li class="nav-item {{ checkIfActive('admin.routers') }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRouters" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="fas fa-globe-asia"></i>
          <span>Routers</span>
        </a>
        <div id="collapseRouters" class="collapse {{ checkIfShow('admin.routers') }}" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Routers</h6>
            <a class="collapse-item {{ checkIfActive('admin.routers.view') }}" href="{{ url("admin/routers") }}">View All</a>
            <a class="collapse-item {{ checkIfActive('admin.routers.add') }}" href="{{ url("admin/routers/add") }}">Add New</a>
          </div>
        </div>
      </li>

      <li class="nav-item {{ checkIfActive('admin.pools') }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePools" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="fas fa-network-wired"></i>
          <span>Pools</span>
        </a>
        <div id="collapsePools" class="collapse {{ checkIfShow('admin.pools') }}" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pools</h6>
            <a class="collapse-item {{ checkIfActive('admin.pools.view') }}" href="{{ url("admin/pools") }}">View All</a>
            <a class="collapse-item {{ checkIfActive('admin.rpools.add') }}" href="{{ url("admin/pools/add") }}">Add New</a>
          </div>
        </div>
      </li>

      <li class="nav-item {{ checkIfActive('admin.bandwidths') }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBandwidths" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="fas fa-exchange-alt"></i>
          <span>Bandwidths</span>
        </a>
        <div id="collapseBandwidths" class="collapse {{ checkIfShow('admin.bandwidths') }}" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Bandwidths</h6>
            <a class="collapse-item {{ checkIfActive('admin.bandwidths.view') }}" href="{{ url("admin/bandwidths") }}">View All</a>
            <a class="collapse-item {{ checkIfActive('admin.bandwidths.add') }}" href="{{ url("admin/bandwidths/add") }}">Add New</a>
          </div>
        </div>
      </li>

      <li class="nav-item {{ checkIfActive('admin.plans') }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePlans" aria-expanded="false" aria-controls="collapseBootstrap">
          <i class="fas fa-server"></i>
          <span>Plans</span>
        </a>
        <div id="collapsePlans" class="collapse {{ checkIfShow('admin.plans') }}" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Plans</h6>
            <a class="collapse-item {{ checkIfActive('admin.plans.view') }}" href="{{ url("admin/plans") }}">View All</a>
            <a class="collapse-item {{ checkIfActive('admin.plans.add') }}" href="{{ url("admin/plans/add") }}">Add New</a>
          </div>
        </div>
      </li>

     
      <hr class="sidebar-divider">
      <div class="version" id="version-ruangadmin">Version 1.1</div>
    </ul>