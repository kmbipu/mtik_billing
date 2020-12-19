@extends('layouts.main') 
@section('pageTitle', 'Dashboard')

@section('content')
<div class="row mb-3">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Admin</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_admin}}</div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <span>Total admins</span>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users-cog fa-2x text-primary"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Resellers</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_admin}}</div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <span>Total resellers</span>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-tag fa-2x text-success"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- New User Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Customer</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$total_customer}}</div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <span>Total customers</span>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-info"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">PPPoe</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_active}}</div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <span>Total active users</span>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-check fa-2x text-warning"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

 </div>
@endsection