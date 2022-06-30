<?php
/*
    Template Name: Discussions
*/
if(isset($_GET['id_top'])) {
  $id_top = $_GET['id_top'];
  if (isset($_GET['post'])) {
    header("Location: " . $_GET['post'] . "#comments");
  }
} 
else {
  header('Location: ' . get_bloginfo('url'));
}
get_header();
?>
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">

    <div class="content-header mt-1">
      <a href="#" onclick="window.history.back();" class="btn btn-outline-primary waves-effect mb-1 mr-1">
        <span class="ico va va-left-arrow va-lg"></span> Retour en arrière
      </a>
    </div>

    <div class="content-body mt-2">

      <div class="classement">

        <div class="row">

          <div class="col-md-12">

            <?php
            global $top_comments_id;
            $top_comments_id = $id_top;
            ?>
            <?php echo get_template_part('comments'); ?>

          </div>

        </div>

      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>