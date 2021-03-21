<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021<a class="ml-25" href="https://1.envato.market/pixinvent_portfolio" target="_blank">Pixinvent</a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span><span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span></p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->

<!-- JS -->
<script src="<?php bloginfo('template_directory'); ?>/app-assets/vendors/js/vendors.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/app-assets/js/core/app-menu.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/app-assets/js/core/app.js"></script>

<!-- Context JS -->
<script src="<?php bloginfo('template_directory'); ?>/app-assets/js/scripts/pages/page-profile.js"></script>

<!-- Custom JS-->
<script>
    const vkrz_ajaxurl = "<?= admin_url('admin-ajax.php') ?>";
</script>
<script src="<?php bloginfo('template_directory'); ?>/function/ajax/contenders-ajax.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/function/ajax/jquery.cookie.js"></script>
<script type="text/javascript">
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

    jQuery.fn.equalHeights = function(){
        var max_height = 0;
        jQuery(this).each(function(){
            max_height = Math.max(jQuery(this).height(), max_height);
        });
        jQuery(this).each(function(){
            jQuery(this).height(max_height);
        });
    };

    jQuery(document).ready(function() {
        jQuery('.eh').equalHeights();
    });
</script>
<?php wp_footer(); ?>
</body>
</html>
