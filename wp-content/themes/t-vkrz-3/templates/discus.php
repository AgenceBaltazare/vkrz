<?php
/*
    Template Name: Discussions
*/
global $uuiduser;
if(isset($_GET['id_top'])){
    $id_top  = $_GET['id_top'];
}
else{
    header('Location: ' . get_bloginfo('url'));
}
get_header();
?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top <?php echo $top_infos['top_number']; ?> <span class="ico text-center">🏆</span> <?php echo $top_infos['top_title']; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_infos['top_question']; ?>
                    </h4>
                </div>
            </div>

            <div class="classement">

                <div class="container">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="card">

                                <div class="card-body">

                                    <?php comment_form(array(), $id_top); ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<?php get_footer(); ?>