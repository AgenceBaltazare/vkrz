<?php
/*
    Template Name: Duplicate Top
*/
acf_form_head();
get_header();
$user   = wp_get_current_user();
$roles  = (array) $user->roles;
$id_top = "";
if (isset($_GET['id_top']) && $_GET['id_top'] != "") {
    $id_top = $_GET['id_top'];
}
?>

<div class="blog-detail-wrapper">
    <div class="row">
        <?php if (is_user_logged_in() && $roles[0] == "administrator") : ?>
            <div class="col-12">

                <h1 class="text-center mt-2">
                    Duplication de Top 👯
                </h1>

                <?php if (!$id_top) : ?>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card mt-2">
                                <div class="card-body">
                                    <form action="#" method="get">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input class="form-control" type="number" name="id_top" placeholder="ID du Top" value="">
                                                <input type="hidden" name="duplication" value="yes">
                                            </div>
                                            <div class="col-sm-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Valider
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['duplication']) && $_GET['duplication'] == "yes") :

                    $id_top_duplicated = duplicatator($id_top);
                    update_field('id_du_resume_t', '', $id_top_duplicated);
                    $creator_id        = get_post_field('post_author', $id_top);
                    update_field('duplication_top_t', $id_top, $id_top_duplicated);
                    update_field('duplication_createur_t', $creator_id, $id_top_duplicated);

                    $contenders_t = new WP_Query(array(
                        'post_type' => 'contender',
                        'posts_per_page' => '-1',
                        'meta_query'     => array(
                            array(
                                'key'     => 'id_tournoi_c',
                                'value'   => $id_top,
                                'compare' => '=',
                            )
                        )
                    ));
                    while ($contenders_t->have_posts()) : $contenders_t->the_post();

                        $id_contender            = get_the_ID();
                        $id_contender_duplicated = duplicatator($id_contender);
                        update_field('id_tournoi_c', $id_top_duplicated, $id_contender_duplicated);
                        update_field('ELO_c', 1200, $id_contender_duplicated);

                    endwhile;

                    $redirect_url = get_bloginfo('url') . "/wp-admin/post.php?post=" . $id_top_duplicated . "&action=edit";
                    wp_safe_redirect($redirect_url);
                ?>
                    <div class="row">
                        <div class="col text-center">
                            <a href="<?php echo $redirect_url; ?>" class="btn btn-primary" target="_blank">
                                Editer le Top
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="col">
                <h2 class="text-center">
                    Tu dois faire partie de la TEAM <span class="va-lama va va-lg"></span> pour dupliquer un Top !
                </h2>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>