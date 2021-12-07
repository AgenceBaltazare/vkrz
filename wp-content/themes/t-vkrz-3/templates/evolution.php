<?php
/*
    Template Name: Évolution
*/
global $user_id;
global $user_infos;
get_header();
$level_user = $user_infos['level_number'];
?>
<div class="app-content content evolution">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="pricing-plan">
                <div class="text-center">
                    <h1 class="mt-5">
                        Ton projet d'évolution <span class="vap vap-rocket vap-z-30"></span>
                    </h1>
                    <p class="mb-4 mt-3">
                        En enchaînant les votes, tu accumules des <span class="vap vap-gem vap-z-17"></span>. Voici toutes les étapes à franchir pour devenir légendaire <span class="vap vap-backhand-index-pointing-down vap-z-17"></span>
                        <br><br>
                        Par contre, calmons-nous <span class="vap vap-woozy-face vap-z-17"></span> pour arriver au sommet il faudra sans doute attendre que de nouveaux moyens de gagner des <span class="vap vap-gem vap-z-17"></span> voient le jour #ProjetLongTerme
                    </p>
                </div>

                <div class="row pricing-card">
                    <div class="col-12">
                        <div class="row match-height">

                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center <?php if($level_user==0){echo 'popular';} ?>">
                                    <div class="card-body">
                                        <?php if($level_user == 0): ?>
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">Niveau actuel</div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="eh">
                                            <span class="ico-master vap vap-z-85 vap-egg"></span>
                                        </div>
                                        <h3>Niveau 0</h3>
                                        <?php if(is_user_logged_in()): ?>
                                            <p class="card-text eh2">
                                                Maintenant que tu fais parti des Vainkeurs, il te faut 50 <span class="ico vap vap-gem vap-lg"></span> pour éclore et passer au niveau 1.
                                            </p>
                                        <?php else: ?>
                                            <p class="card-text eh2">
                                                Il faut bien commencer quelque part. On t'invite à nous rejoindre pour briser la coquille <span class="vap vap-hugging-face vap-lg"></span>
                                            </p>
                                            <a href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>" class="btn btn-primary mt-1">
                                                Créer mon compte <span class="ico vap vap-party-popper vap-lg"></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center <?php if($level_user==1){echo 'popular';} ?>">
                                    <div class="card-body">
                                        <?php if($level_user == 1): ?>
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">Niveau actuel</div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="eh">
                                            <span class="ico-master vap vap-z-85 vap-hatching-chick"></span>
                                        </div>
                                        <h3>Niveau 1</h3>
                                        <p class="card-text eh2">
                                            La maitrise du concept de VAINKEURZ se fait petit à petit et c'est beau à voir !
                                        </p>
                                        <div class="annual-plan">
                                            <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                <div class="need">
                                                    <span class="pricing-basic-value font-weight-bolder text-primary">50 <span class="ico vap vap-gem vap-z-30"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center <?php if($level_user==2){echo 'popular';} ?>">
                                    <div class="card-body">
                                        <?php if($level_user == 2): ?>
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">Niveau actuel</div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="eh">
                                            <span class="ico-master vap vap-z-85 vap-chick"></span>
                                        </div>
                                        <h3>Niveau 2</h3>
                                        <p class="card-text eh2">
                                            Ça fait plaisir de te voir grandir et t'approprier de plus en plus VAINKEURZ.
                                        </p>
                                        <div class="annual-plan">
                                            <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                <div class="need">
                                                    <span class="pricing-basic-value font-weight-bolder text-primary">500 <span class="ico vap vap-gem vap-z-30"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center <?php if($level_user==3){echo 'popular';} ?>">
                                    <div class="card-body">
                                        <?php if($level_user == 3): ?>
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">Niveau actuel</div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="eh">
                                            <span class="ico-master vap vap-z-85 vap-rooster">
                                            </span>
                                        </div>
                                        <h3>Niveau 3</h3>
                                        <p class="card-text">
                                            Clairement tu fais parti des Boss de VAINKEURZ maintenant et on est fier de toi <span class="ico vap vap-star-struck vap-lg"></span>
                                        </p>
                                        <div class="annual-plan">
                                            <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                <div class="need">
                                                    <span class="pricing-basic-value font-weight-bolder text-primary">2 000 <span class="ico vap vap-gem vap-z-30"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center <?php if($level_user==4){echo 'popular';} ?>">
                                    <div class="card-body">
                                        <?php if($level_user == 4): ?>
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">Niveau actuel</div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="eh">
                                            <span class="ico-master vap vap-z-85 vap-turkey">
                                            </span>
                                        </div>
                                        <h3>Niveau 4</h3>
                                        <p class="card-text">
                                            Fini la rigolade, maintenant les <span class="ico vap vap-rooster vap-lg"></span> te doivent le respect
                                        </p>
                                        <div class="annual-plan">
                                            <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                <div class="need">
                                                    <span class="pricing-basic-value font-weight-bolder text-primary">5 000 <span class="ico vap vap-gem vap-z-30"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center <?php if($level_user==5){echo 'popular';} ?>">
                                    <div class="card-body">
                                        <?php if($level_user == 5): ?>
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">Niveau actuel</div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="eh">
                                            <span class="ico-master vap vap-z-85 vap-swan">
                                            </span>
                                        </div>
                                        <h3>Niveau 5</h3>
                                        <p class="card-text">
                                            Atteindre ce niveau, est le signe que tu adhères totalement au concept
                                        </p>
                                        <div class="annual-plan">
                                            <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                <div class="need">
                                                    <span class="pricing-basic-value font-weight-bolder text-primary">35 000 <span class="ico vap vap-gem vap-z-30"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center <?php if($level_user==6){echo 'popular';} ?>">
                                    <div class="card-body">
                                        <?php if($level_user == 6): ?>
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">Niveau actuel</div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="eh">
                                            <span class="ico-master vap vap-z-85 vap-flamingo">
                                            </span>
                                        </div>
                                        <h3>Niveau 6</h3>
                                        <p class="card-text">
                                            Uniquement l'élite atteindra ce niveau - le noyau dur. La crème de la crème <span class="ico vap vap-smiling-face-with-heart-eyes vap-lg"></span>
                                        </p>
                                        <div class="annual-plan">
                                            <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                <div class="need">
                                                    <span class="pricing-basic-value font-weight-bolder text-primary">100 000 <span class="ico vap vap-gem vap-z-30"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center <?php if($level_user==7){echo 'popular';} ?>">
                                    <div class="card-body">
                                        <?php if($level_user == 7): ?>
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">Niveau actuel</div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="eh">
                                            <span class="ico-master vap vap-z-85 vap-peacock">
                                            </span>
                                        </div>
                                        <h3>Niveau 7</h3>
                                        <p class="card-text">
                                            Majestueux - Admirable - Précieux - Tu as poncé le concept et tu mérites tout notre respect !
                                        </p>
                                        <div class="annual-plan">
                                            <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                <div class="need">
                                                    <span class="pricing-basic-value font-weight-bolder text-primary">450 000 <span class="ico vap vap-gem vap-z-30"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center <?php if($level_user==8){echo 'popular';} ?>">
                                    <div class="card-body">
                                        <?php if($level_user == 8): ?>
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">Niveau actuel</div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="eh">
                                            <span class="ico-master vap vap-z-85 vap-dragon">
                                            </span>
                                        </div>
                                        <h3>Niveau final</h3>
                                        <p class="card-text">
                                            Est-il seulement possible qu'un humain atteigne ce niveau ?
                                        </p>
                                        <div class="annual-plan">
                                            <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                <div class="need">
                                                    <span class="pricing-basic-value font-weight-bolder text-primary">1 MILLION<span class="ico vap vap-gem vap-z-30"></span></span>
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
<!-- END: Content-->
<?php get_footer(); ?>