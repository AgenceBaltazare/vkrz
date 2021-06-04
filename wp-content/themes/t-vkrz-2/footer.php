<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
        <span class="float-md-left d-block d-md-inline-block mt-25">VAINKEURZ  ©<?php echo date('Y'); ?>
            <a class="ml-25" href="<?php the_permalink(get_page_by_path('ml')); ?>">CGU</a>
            -
            <a class="ml-25" href="mailto:vainkeurz@gmail.com">Nous contacter</a>
        </span>
        <span class="float-md-right d-none d-md-block">
            <a href="https://discord.gg/PhjrFtwx" class="btn-footer" target="_blank">
                Discord
            </a>
            <span class="space"></span>
            <a href="https://twitter.com/Vainkeurz" target="_blank" class="btn-footer">
                Twitter
            </a>
            <span class="space"></span>
            <a href="https://www.facebook.com/vainkeurz" target="_blank" class="btn-footer">
                Facebook
            </a>
        </span>
    </p>
</footer>

<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/vendors.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/extensions/polyfill.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/app-menu.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/app.js"></script>

<!-- Home -->
<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/extensions/swiper.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/scripts/extensions/ext-component-swiper.js"></script>


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