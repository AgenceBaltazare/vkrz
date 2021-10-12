<?php
get_header();
global $uuiduser;
global $user_id;
global $id_top;
global $id_ranking;
global $top_infos;
global $utm;
global $user_infos;
global $id_vainkeur;
global $banner;

if (is_user_logged_in() && env() != "local") {
    if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
        $user_tops = get_user_tops();
        set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
    } else {
        $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
    }
} else {
    $user_tops  = get_user_tops();
}
$user_ranking = get_user_ranking($id_ranking);
$url_ranking  = get_the_permalink($id_ranking);
$top_datas    = get_top_data($id_top);
?>
<div class="app-content-marqueblanche-result content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="intro-marqueblanche">
                <div class="logo_marqueblanche">
                    <?php echo wp_get_attachment_image(get_field('logo_marque_blanche_t', $id_top), 'full', '', array('class' => 'img-fluid')); ?>
                </div>
                <h4 class="text-center r-resultat-marqueblanche">
                    <?php the_field('titre_resultat_marque_blanche_t', $id_top); ?> <br>
                </h4>    
            </div>
            <?php if ((!is_user_logged_in()) && (!get_field('marqueblanche_t', $id_top))) : ?>
                <section class="please-rejoin app-user-view">
                    <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-account" data-v-aa799a9e="">
                        <div class="alert-body d-flex align-items-center justify-content-between">
                            <span><span class="ico">💾</span> Pour sauvegarder et retrouver sur tous tes supports ta progression l'idéal serait de te créer un compte.</span>
                            <div class="btns-alert text-right">
                                <a class="btn btn-primary waves-effect btn-rose" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                                    Excellente idée - je créé mon compte <span class="ico">🎉</span>
                                </a>
                                <a class="btn btn-outline-white waves-effect t-white ml-1" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                                    J'ai déjà un compte
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <div class="classement">
                <div class="d-flex justify-content-center">
                    <div class="col-md-10">
                        <div class="list-classement mt-2">
                            <div class="row align-items-end justify-content-center">
                                <?php
                                $i = 1;
                                foreach ($user_ranking as $c => $p) : ?>
                                    <?php if ($i == 1) : ?>
                                        <div class="col-12 col-md-5 crown">
                                        <?php elseif ($i == 2) : ?>
                                            <div class="col-7 col-md-4">
                                            <?php elseif ($i == 3) : ?>
                                                <div class="col-5 col-md-3">
                                                <?php else : ?>
                                                    <div class="col-md-2 col-4">
                                                    <?php endif; ?>
                                                    <?php
                                                    if ($i >= 4) {
                                                        $d = 3;
                                                    } else {
                                                        $d = $i - 1;
                                                    }
                                                    ?>
                                                    <div class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min <?php echo ($top_infos['top_d_rounded']) ? 'rounded' : ''; ?> mb-3">
                                                        <div class="illu">
                                                            <?php if ($top_infos['top_d_cover']) : ?>
                                                                <?php $illu = get_the_post_thumbnail_url($c, 'large'); ?>
                                                                <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                                            <?php else : ?>
                                                                <?php echo get_the_post_thumbnail($c, 'large', array('class' => 'img-fluid')); ?>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="name eh2">
                                                            <div class="top-marque-blanche">
                                                                <?php if ($i == 1) : ?>
                                                                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/marqueblanche/gdp/top1.svg" alt="" class="top1">
                                                                <?php elseif ($i == 2) : ?>
                                                                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/marqueblanche/gdp/top2.svg" alt="" class="top2">
                                                                <?php elseif ($i == 3) : ?>
                                                                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/marqueblanche/gdp/top3.svg" alt="" class="top3">
                                                                <?php else : ?>
                                                                    <span><?php echo $i; ?><br></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                <?php $i++;
                                                endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-resultat">
                    <div class="cover-coupon">
                        <div class="coupon-content">
                            <h3>
                                Felicitation !
                            </h3>
                            <p>
                                Vous avez gagné un coupon de -10% !
                            </p>
                            <form action="" method="post" name="form2" id="form-coupon" onsubmit="Validate();">
                                <input type="email" placeholder="Mon adresse mail" name="input" id="mail-coupon">
                                <button class="btn" id="btn-coupon">Recevoir mon coupon</button>
                            </form>
                        </div>
                    </div>
                    <div class="social-media-marqueblanche-resultat">
                        <?php if(have_rows('reseaux_sociaux_marque_blanche_t', $id_top)):
                            while ( have_rows('reseaux_sociaux_marque_blanche_t', $id_top) ) : the_row(); ?>
                                <a href=<?php the_sub_field('lien_reseaux_sociaux_marque_blanche_t', $id_top); ?> target="_blank">
                                    <?php if(get_sub_field('image_reseaux_sociaux_marque_blanche_t', $id_top)) : ?>
                                        <?php echo wp_get_attachment_image(get_sub_field('image_reseaux_sociaux_marque_blanche_t', $id_top), 'full', '', array('class' => 'img-fluid')); ?>
                                    <?php endif; ?>
                                </a>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <?php $bouton_marqueblanche = get_field('bouton_voir_plus_marque_blanche_t', $id_top) ?>
                    <?php if(get_field('bouton_voir_plus_marque_blanche_t', $id_top)): ?>
                        <a href=<?php echo $bouton_marqueblanche['lien_grp_marque_blanche_t']; ?> class="btn" target="_blank">
                            <h3 class="more-marqueblanche">
                                <?php echo $bouton_marqueblanche['intitule_grp_marque_blanche_t']; ?>
                            </h3>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-popup" id="form-coupon-2">
                <form action="" name="form3" class="form-container">
                    <h1>Recevoir mon coupon</h1>

                    <label for="email"><b>Nom</b></label>
                    <input type="text" placeholder="Entrez votre nom" name="nom" required>

                    <label for="email"><b>Prénom</b></label>
                    <input type="text" placeholder="Entrez votre prénom" name="prenom" required>

                    <label for="email"><b>Email</b></label>
                    <input type="text" placeholder="Entrez votre Email" name="" id="mail-coupon-2" required>
                    
                    <input type="checkbox" name="check" id="chek">
                    <label for="check">Valider les conditions</label>

                    <button type="submit" class="btn">Valider</button>
                    <button type="button" class="btn cancel" id="btn-close-coupon">Fermer</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>

$('#form-coupon').submit(function(event) {
    event.preventDefault();

    var valid = Validate();
    if ( !valid ) {
        document.getElementById("form-coupon-2").style.display = "none";
    } else {
        document.getElementById("form-coupon-2").style.display = "block";
    }
});

// $('#btn-coupon').click(function() {
//     var valid = Validate();
//     if ( !valid ) {
//         document.getElementById("form-coupon-2").style.display = "none";
//     } else {
//         document.getElementById("form-coupon-2").style.display = "block";
//     }
// });

// function validateEmail(email) {
//     var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
//     return testEmail.test( email );
// }


$('#btn-coupon').click(function() {
    document.getElementById("form-coupon-2").style.display = "block";
});

$('#btn-close-coupon').click(function() {
    document.getElementById("form-coupon-2").style.display = "none";
});

$(document).ready(function(){
    $("#btn-coupon").click(function(){
        var mail = $("#mail-coupon").val();
        document.getElementById("mail-coupon-2").value=mail;
    });
});
</script>

<?php get_footer(); ?>