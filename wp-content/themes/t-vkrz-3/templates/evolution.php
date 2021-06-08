<?php
/*
    Template Name: Évolution
*/
global $user_id;
get_header();
if(is_user_logged_in()){
    $level_user = get_field('level_user', 'user_' . $user_id);
}
else{
    $level_user = 0;
}
?>
    <div class="app-content content evolution">
        <div class="content-wrapper">
            <div class="content-body">
                <section id="pricing-plan">
                    <div class="text-center">
                        <h1 class="mt-5">
                            Ton projet d'évolution 🚀
                        </h1>
                        <p class="mb-4 mt-3">
                            En enchaînant les votes, tu accumules des 💎. Voici toutes les étapes à franchir pour devenir légendaire 👇
                            <br><br>
                            Par contre, calmons-nous - pour arriver au sommet il faudra attendre que de nouveaux Tops soit publiés #ProjetLongTerme
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
                                                <span class="ico-master">🥚</span>
                                            </div>
                                            <h3>Niveau 0</h3>
                                            <?php if(is_user_logged_in()): ?>
                                                <p class="card-text eh2">
                                                    Maintenant que tu fais parti des champions, il te reste pour éclore et passer au niveau 1.
                                                </p>
                                            <?php else: ?>
                                                <p class="card-text eh2">
                                                    Il faut bien commencer quelque part. On t'invite à nous rejoindre pour briser la coquille 🤗
                                                </p>
                                                <a href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>" class="btn btn-primary mt-1">
                                                    Créer mon compte <span class="ico">🎉</span>
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
                                                <span class="ico-master">🐣</span>
                                            </div>
                                            <h3>Niveau 1</h3>
                                            <p class="card-text eh2">
                                                La maitrise du concept de VAINKEURZ se fait petit à petit et c'est beau à voir !
                                            </p>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                    <div class="need">
                                                        <span class="pricing-basic-value font-weight-bolder text-primary">50 <span class="ico">💎</span></span>
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
                                                <span class="ico-master">🐥</span>
                                            </div>
                                            <h3>Niveau 2</h3>
                                            <p class="card-text eh2">
                                                Ça fait plaisir de te voir grandir et t'approprier de plus en plus VAINKEURZ.
                                            </p>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                    <div class="need">
                                                        <span class="pricing-basic-value font-weight-bolder text-primary">500 <span class="ico">💎</span></span>
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
                                            <span class="ico-master">
                                                🐓
                                            </span>
                                            <h3>Niveau 3</h3>
                                            <p class="card-text">
                                                Clairement tu fais parti des Boss de VAINKEURZ maintenant et on est fier de toi <span class="ico">🤩</span>
                                            </p>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                    <div class="need">
                                                        <span class="pricing-basic-value font-weight-bolder text-primary">2 000 <span class="ico">💎</span></span>
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
                                            <span class="ico-master">
                                                🦃
                                            </span>
                                            <h3>Niveau 4</h3>
                                            <p class="card-text">
                                                Fini la rigolade, maintenant les <span class="ico">🐓</span> te doivent le respect
                                            </p>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                    <div class="need">
                                                        <span class="pricing-basic-value font-weight-bolder text-primary">5 000 <span class="ico">💎</span></span>
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
                                            <span class="ico-master">
                                                🦢
                                            </span>
                                            <h3>Niveau 5</h3>
                                            <p class="card-text">
                                                Atteindre ce niveau, est le signe que tu adhères totalement au concept
                                            </p>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                    <div class="need">
                                                        <span class="pricing-basic-value font-weight-bolder text-primary">15 000 <span class="ico">💎</span></span>
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
                                            <span class="ico-master">
                                                🦩
                                            </span>
                                            <h3>Niveau 6</h3>
                                            <p class="card-text">
                                                Uniquement l'élite atteindra ce niveau - le noyau dur. La crème de la crème <span class="ico">😍</span>
                                            </p>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                    <div class="need">
                                                        <span class="pricing-basic-value font-weight-bolder text-primary">30 000 <span class="ico">💎</span></span>
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
                                            <span class="ico-master">
                                                🦚
                                            </span>
                                            <h3>Niveau 7</h3>
                                            <p class="card-text">
                                                Majestueux - Admirable - Précieux - Tu as poncé le concept et tu mérites tout notre respect !
                                            </p>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                    <div class="need">
                                                        <span class="pricing-basic-value font-weight-bolder text-primary">70 000 <span class="ico">💎</span></span>
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
                                            <span class="ico-master">
                                                🐉
                                            </span>
                                            <h3>Niveau final</h3>
                                            <p class="card-text">
                                                Est-il seulement possible qu'un humain atteigne ce niveau ?
                                            </p>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                    <div class="need">
                                                        <span class="pricing-basic-value font-weight-bolder text-primary">100 000<span class="ico">💎</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 offset-sm-3 mt-3">
                                <div class="dodo">
                                    <div class="card dodocard basic-pricing text-center">
                                        <div class="card-body">
                                            <div class="pricing-trial-content d-flex justify-content-between align-items-center">
                                                <div class="text-center text-md-left mt-2">
                                                    <h3 class="text-primary">Qui est le BOSS de VAINKEURZ ?</h3>
                                                    <h5 class="mt-2">
                                                        C'est le champion avec le plus de 💎
                                                        <br> <br>
                                                        Il est le Dodo - le seul et l'unique - le champion tout en haut
                                                    </h5>
                                                    <button class="btn btn-primary mt-2">
                                                        A découvrir prochainement
                                                    </button>
                                                    <div class="mt-2">
                                                        <small>
                                                            Si tu es chaud en dev et souhaite contribuer, <a href="https://discord.gg/VKt2GsG43N" target="_blank">n'hésite pas à nous rejoindre ici !</a>
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="dodo-img">
                                                    <span class="ico-masterclass">
                                                        🦤
                                                    </span>
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