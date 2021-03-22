<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

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
<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });
</script>
<?php wp_footer(); ?>
</body>
</html>
