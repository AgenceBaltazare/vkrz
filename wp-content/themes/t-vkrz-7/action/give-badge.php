<?php
/*
    Template Name: Give badge
*/
get_header();
if (isset($_GET['id_vainkeur']) && $_GET['id_vainkeur'] != "") {
    $id_vainkeur = $_GET['id_vainkeur'];
}
if (isset($_GET['badge-selection']) && $_GET['badge-selection'] != "") {
    $badge_selection = $_GET['badge-selection'];
}
$user = wp_get_current_user();
$roles = (array) $user->roles;
?>

<div class="blog-detail-wrapper">
    <div class="row">
        <?php if (is_user_logged_in() && $roles[0] == "administrator") : ?>
            <div class="col-12">

                <h1 class="text-center mt-2">
                    Attribution de trophées 🎖
                </h1>

                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card mt-2">
                            <div class="card-body">
                                <form action="<?php the_permalink(get_page_by_path('attribution')); ?>" method="get">
                                    <div class="row justify-content-center align-items-baseline">
                                        <div class="col-sm-4">
                                            <input class="form-control" type="number" name="id_vainkeur" placeholder="ID du Vainkeur">
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="badge-selection">
                                                <option value="">Choix du trophée</option>
                                                <?php
                                                $list_badge = get_terms(array(
                                                    'taxonomy'      => 'badges',
                                                    'orderby'       => 'title',
                                                    'order'         => 'ASC',
                                                    'hide_empty'    => false,
                                                ));
                                                foreach ($list_badge as $badge) : ?>
                                                    <option value="<?php echo $badge->name; ?>"><?php echo $badge->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="submit" value="Attribuer" class="btn btn-primary waves-effect waves-float waves-light">
                                        </div>
                                        <?php if (isset($id_vainkeur) && isset($badge_selection)) : ?>
                                            <div class="col-sm-2">
                                                <a href="<?php the_permalink(get_page_by_path('attribution')); ?>/" type="button" class="btn btn-outline-danger waves-effect">X</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (isset($id_vainkeur) && isset($badge_selection)) :
                    update_vainkeur_badge($id_vainkeur, $badge_selection);
                ?>
                    <section class="app-user-view mt-2">
                        <div class="row match-height">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h2>
                                            Le trophée <span class="t-rose"><?php echo $badge_selection; ?></span> a été attribué au vainkeur <a href="https://vainkeurz.com/wp-admin/post.php?post=<?php echo $id_vainkeur; ?>&action=edit"><?php echo $id_vainkeur; ?></a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="col">
                <h2 class="text-center">
                    Tu dois faire partie de la TEAM <span class="va-lama va va-lg"></span> pour te ballaber ici !
                </h2>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>