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

                <section id="nav-filled">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="basic-tabs-components">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="homeIcon-tab" data-toggle="tab" href="#tab1" aria-controls="home" role="tab" aria-selected="true">
                                                    Infos générales
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profileIcon-tab" data-toggle="tab" href="#tab2" aria-controls="profile" role="tab" aria-selected="false">
                                                    Réseaux
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profileIcon-tab" data-toggle="tab" href="#tab3" aria-controls="profile" role="tab" aria-selected="false">
                                                    Paramètres
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content mt-3">
                                            <div class="tab-pane active" id="tab1" aria-labelledby="homeIcon-tab" role="tabpanel">

                                                <?php echo do_shortcode('[wppb-edit-profile form_name="presentation"]'); ?>

                                            </div>
                                            <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="tab2">

                                                <?php echo do_shortcode('[wppb-edit-profile form_name="reseaux"]'); ?>

                                            </div>
                                            <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="tab3">

                                                <?php echo do_shortcode('[wppb-edit-profile form_name="parametres"]'); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>

