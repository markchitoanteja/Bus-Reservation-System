<!-- Footer -->
<footer class="main-footer">
    <strong>&copy; 2025 Eastern Goldtrans Tours Inc.</strong> All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0
    </div>
</footer>
</div>

<!-- Scripts -->
<!-- Add these in your HTML head or before closing </body> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="<?= base_url() ?>public/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>public/plugins/moment/moment.min.js"></script>
<script src="<?= base_url() ?>public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?= base_url() ?>public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= base_url() ?>public/dist/admin/js/adminlte.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="<?= base_url() ?>public/dist/admin/js/main/main.js"></script>

<?php if ( session()->get( 'active_tab' ) === 'routes' ) : ?>
    <script src="<?= base_url() ?>public/dist/admin/js/pages/routes.script.js"></script>
<?php endif; ?>

<?php if ( session()->get( 'active_tab' ) === 'buses' ) : ?>
    <script src="<?= base_url() ?>public/dist/admin/js/pages/buses.script.js"></script>
<?php endif; ?>

<?php if ( session()->has( 'swalAlert' ) ) : ?>
    <script>
        Swal.fire({
            title: '<?= esc( session( 'swalAlert' )[ 'title' ] ) ?>',
            text: '<?= esc( session( 'swalAlert' )[ 'text' ] ) ?>',
            icon: '<?= esc( session( 'swalAlert' )[ 'icon' ] ) ?>',
            timer: 2000, // 3 seconds
            showConfirmButton: false,
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false
        });
    </script>
<?php endif; ?>

</body>

</html>