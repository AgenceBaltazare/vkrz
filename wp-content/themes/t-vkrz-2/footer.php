<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
        <span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021 </span>
    </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button">
    <i data-feather="arrow-up"></i>
</button>

<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/vendors.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/app-menu.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/app.js"></script>

<!-- Home -->
<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/extensions/swiper.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/scripts/extensions/ext-component-swiper.js"></script>

<!-- VKRZ -->
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/main.js"></script>

<!-- Custom JS-->
<script>
    const vkrz_ajaxurl = "<?= admin_url('admin-ajax.php') ?>";
</script>
<script src="<?php bloginfo('template_directory'); ?>/function/ajax/contenders-ajax.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/function/ajax/jquery.cookie.js"></script>

<?php wp_footer(); ?>

</body>
</html>