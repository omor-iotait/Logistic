
<script src="<?php echo BASE_URL; ?>assets/scripts/plugins/jquery/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo BASE_URL; ?>assets/scripts/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo BASE_URL; ?>assets/scripts/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- overlayScrollbars -->
<script src="<?php echo BASE_URL; ?>assets/scripts/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BASE_URL; ?>assets/scripts/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo BASE_URL; ?>assets/scripts/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo BASE_URL; ?>assets/scripts/dist/js/demo.js"></script>

<script>

    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }


</script>