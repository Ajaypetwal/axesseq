 <!-- JS Links Start -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

 <script src="{{ URL::asset('admin/js/popper.min.js') }}"></script>
  <script src="{{ URL::asset('admin/js/bootstrap.bundle.min.js') }}"></script>
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
