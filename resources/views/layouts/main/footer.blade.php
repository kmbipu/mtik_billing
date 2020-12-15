    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="post">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id">
              Are you sure to delete?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    

    @php $version = env('APP_VERSION'); @endphp
    <script src="{{ asset('resources/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}?ver={{$version}}"></script>
    <script src="{{ asset('resources/assets/js/theme.js') }}?ver={{$version}}"></script>
    <script src="{{ asset('resources/assets/js/main.js') }}?ver={{$version}}"></script>

    @yield('bottomScripts')

  </body>

</html>