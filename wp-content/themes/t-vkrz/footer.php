<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    const vkrz_ajaxurl = "<?= admin_url('admin-ajax.php') ?>";
</script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/contenders-ajax.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/jquery.cookie.js"></script>
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
</script>
<?php wp_footer(); ?>
</body>
</html>
