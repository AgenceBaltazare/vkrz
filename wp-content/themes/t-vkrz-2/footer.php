<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/vendors.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/extensions/polyfill.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/app-menu.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/app.js"></script>

<!-- Home -->
<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/extensions/swiper.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/scripts/extensions/ext-component-swiper.js"></script>

<!-- Général -->
<script src="<?php bloginfo('template_directory'); ?>/assets/js/scripts/extensions/ext-component-sweet-alerts.js"></script>


<!-- VKRZ -->
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/main.js"></script>

<!-- Custom JS-->
<script>
    const vkrz_ajaxurl  = "<?= admin_url('admin-ajax.php') ?>";
    const vkrz_template = "<?= get_bloginfo('template_directory'); ?>";
</script>
<script src="<?php bloginfo('template_directory'); ?>/function/ajax/contenders-ajax.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/function/ajax/meca.js"></script>

<?php wp_footer(); ?>

</body>
</html>