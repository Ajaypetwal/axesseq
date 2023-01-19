 <!-- JS Links Start -->
 <script src="{{ URL::asset('admin/js/popper.min.js') }}"></script>
  <script src="{{ URL::asset('admin/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ URL::asset('admin/js/custom.js') }}"></script>
  <script src="{{ URL::asset('admin/js/jquery.js') }}"></script>

  <script>
    $(document).ready(function () {
      $("#sidebar-control").click(function () {
        $(".sidebarMenu").toggleClass("hide");
      });
    });
  </script>
  <!-- JS Links End -->
</body>

</html>
