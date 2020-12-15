@include('layouts.main.head')
  <div id="wrapper">

    @include('layouts.main.sidebar')

    <div id="content-wrapper" class="d-flex flex-column" >

      <div id="content">

        @include('layouts.main.topbar')

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper" >

            <div class="d-sm-flex align-items-center justify-content-between mb-4" style="border-bottom: 1px solid gainsboro;padding: 0 0 10px 0;">
                <h4>@yield('pageTitle')</h4>
                <ol class="breadcrumb mb-0" style="padding:0">
                  @yield('headerRight')
              </ol>          
            </div>
            @include('flash')
            
            @yield('content')

        </div>
        <!---Container Fluid-->

      </div>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; 2020 - Developed by
              <b><a href="http://codexwp.com" target="_blank">CodexWP</a></b>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->

    </div>
  </div>

@include('layouts.main.footer')

