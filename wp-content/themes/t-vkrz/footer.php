<?php
global $id_top;
global $infos_vainkeur;
global $id_vainkeur;
?>
</div>
</div>
<!--/ Content -->

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="container-xxl">
    <div class="footer-container d-flex align-items-center justify-content-between flex-md-row flex-column">
      <div class="copyright">
        <span class="float-md-left d-block d-md-inline-block">
          <span class="me-2">
            VAINKEURZ ©<?php echo date('Y') + 100; ?>
          </span>
          <a class="me-2" href="mailto:weare@vainkeurz.com">Contact</a>
          <a href="<?php the_permalink(get_page_by_path('ml')); ?>">CGU</a>
        </span>
      </div>
      <div class="d-none d-sm-block">
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
          <a href="https://www.tiktok.com/@vainkeurz" target="_blank" class="btn-footer">
            TikTok
          </a>
        </span>
      </div>
    </div>
  </div>
</footer>
<!-- / Footer -->

<?php get_template_part('partials/rechercher'); ?>

<div class="content-backdrop fade"></div>
</div>
<!--/ Content wrapper -->
</div>

<!--/ Layout container -->
</div>
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>

<!--/ Layout wrapper -->

<script>
  const vkrz_ajaxurl = "<?= admin_url('admin-ajax.php') ?>";
  const id_vainkeur = "<?= $id_vainkeur ?>";
</script>

<?php if ($infos_vainkeur['user_role'] != "administrator" && env() != "local") : ?>
  <script type="text/javascript">
    window.$crisp = [];
    window.CRISP_WEBSITE_ID = "ec6a3187-bf39-4eb5-a90d-dda00a2995c8";
    (function() {
      d = document;
      s = d.createElement("script");
      s.src = "https://client.crisp.chat/l.js";
      s.async = 1;
      d.getElementsByTagName("head")[0].appendChild(s);
    })();
  </script>
  <script>
    $crisp.push(["set", "user:email", ["<?php echo $infos_vainkeur['user_email']; ?>"]]);
    $crisp.push(["set", "user:nickname", ["<?php echo $infos_vainkeur['pseudo']; ?>"]]);
    $crisp.push(["set", "user:avatar", ["<?php echo $infos_vainkeur['avatar']; ?>"]]);
    $crisp.push(["safe", true]);
  </script>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>