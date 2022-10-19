<?php
/*
    Template Name: User settings
*/
get_header();
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
                                                    Rézeaux
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profileIcon-tab" data-toggle="tab" href="#tab3" aria-controls="profile" role="tab" aria-selected="false">
                                                    Paramètres
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profileIcon-tab" data-toggle="tab" href="#tab4" aria-controls="profile" role="tab" aria-selected="false">
                                                    Parrainage
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

                                                <div class="auth-register-form">
                                                    <div class="classic-form">
                                                        <?php echo do_shortcode('[wppb-edit-profile form_name="parametres"]'); ?>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="tab3">

                                                <div class="auth-register-form">
                                                    <div class="classic-form">
                                                        <form action="">
                                                            
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
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