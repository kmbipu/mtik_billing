<!DOCTYPE html>
<html lang="en">
@php $version = env('APP_VERSION'); @endphp
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="site-url" content="{{url('/')}}">
  <link href="{{ asset('resources/assets/img/logo/logo.png') }}" rel="icon">
  <title>@yield('pageTitle')</title>
  <link href="{{ asset('resources/assets/vendor/fontawesome-free/css/all.min.css') }}?ver={{$version}}" rel="stylesheet" type="text/css">
  <link href="{{ asset('resources/assets/vendor/bootstrap/css/bootstrap.min.css') }}?ver={{$version}}" rel="stylesheet" type="text/css">
  <link href="{{ asset('resources/assets/css/theme.css') }}?ver={{$version}}" rel="stylesheet">
  <link href="{{ asset('resources/assets/css/main.css') }}?ver={{$version}}" rel="stylesheet">
  <script src="{{ asset('resources/assets/vendor/jquery/jquery.min.js') }}?ver={{$version}}"></script>

</head>

<body class="bg-gradient-login" ng-app="publicApp">
<!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">  
                <div class="login-form">              
                  @yield('content');
                  @include('flash')
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->

  <script>
    setTimeout(() => {
      $(".alert").fadeOut();
    }, 3000);
  </script>

</body>

</html>