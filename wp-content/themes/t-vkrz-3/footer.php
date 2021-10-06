<?php
  global $id_top;
?>

<?php if (!get_field('marqueblanche_t', $id_top)): ?>
    <div class="sidenav-overlay"></div>
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0">
            <span class="float-md-left d-block d-md-inline-block mt-25">VAINKEURZ ©<?php echo date('Y'); ?>
                <a class="ml-25" href="<?php the_permalink(104853); ?>">A propos</a>
                -
                <a class="ml-25" href="<?php the_permalink(get_page_by_path('ml')); ?>">CGU</a>
                -
                <a class="ml-25" href="mailto:vainkeurz@gmail.com">Contact</a>
            </span>
            <span class="float-md-right social-links">
                <a href="https://discord.gg/E9H9e8NYp7" class="btn-footer" target="_blank">
                    Discord
                </a>
                <span class="space"></span>
                <a href="https://www.instagram.com/wearevainkeurz/" class="btn-footer" target="_blank">
                    Insta
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
<?php endif; ?>

<?php global $id_vainkeur; ?>
<script>
    const vkrz_ajaxurl = "<?= admin_url('admin-ajax.php') ?>";
    const id_vainkeur = "<?= $id_vainkeur ?>";
</script>

<?php wp_footer(); ?>

</body>

</html>