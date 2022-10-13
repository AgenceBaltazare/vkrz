<?php global $id_top; ?>
<div class="come-back d-none">
    <div class="d-flex">
        <div class="text-center w-100">
            <b>🎉 Nouvelles fonctionnalités 🎉</b> <a href="https://vainkeurz.com/nouvelle-version">Click ici pour les découvrir 👀</a>. Tes retours sont les bienvenues sur le chat ou <a href="https://discord.gg/E9H9e8NYp7" target="_blank">Discord</a> 🙏
        </div>
        <button type="button" class="come-back-closeBtn" data-bs-dismiss="alert" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<?php if (!get_field('marqueblanche_t', $id_top)) : ?>
    <div class="sidenav-overlay"></div>
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0">
            <span class="float-md-left d-block d-md-inline-block mt-25">VAINKEURZ ©<?php echo date('Y') + 1000; ?>
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