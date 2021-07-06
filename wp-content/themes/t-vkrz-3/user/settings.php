<?php
/*
    Template Name: User settings
*/
global $uuiduser;
global $current_user;
global $user_id;
global $nb_user_votes;
global $user_full_data;
global $info_user_level;
global $list_t_done;
get_header();
global $user_role;
$list_t_begin   = $user_full_data[0]['list_user_ranking_begin'];
$data_t_created = get_creator_t($user_id);
$list_t_created = $data_t_created[0]['creator_tops'];
?>
<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">
            <div id="user-profile">
                <div class="row">
                    <div class="col-12">

                        <?php get_template_part('partials/profil'); ?>

                    </div>
                </div>

                <section id="profile-info">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php echo do_shortcode('[wppb-edit-profile form_name="edition-profil"]'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>

