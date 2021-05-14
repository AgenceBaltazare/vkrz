<?php
wp_reset_query(); wp_reset_postdata();
?>
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
        <span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; <?php echo date('Y'); ?> </span>
    </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button">
    <i data-feather="arrow-up"></i>
</button>

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
    const vkrz_ajaxurl = "<?= admin_url('admin-ajax.php') ?>";
</script>
<script src="<?php bloginfo('template_directory'); ?>/function/ajax/contenders-ajax.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/function/ajax/jquery.cookie.js"></script>

<script type="application/javascript">
    function setCookie(_name, _value, _days) {
        var expiration = new Date();
        expiration.setDate(expiration.getDate() + _days);
        expiration.toUTCString();
        document.cookie = _name+'='+_value+'; expires='+expiration+'; path=/';
    }

    function getCookie(_name) {
        var keyValue = document.cookie.match('(^|;) ?' + _name + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }

    function checkCookie() {
        var has_vainkeurz_user_id = getCookie("vainkeurz_user_id");
        if (!has_vainkeurz_user_id) {
            setCookie('vainkeurz_user_id', '<?php echo uniqidReal(); ?>', 1000);
        }
    }
    checkCookie();
</script>

<?php wp_footer(); ?>

</body>
</html>