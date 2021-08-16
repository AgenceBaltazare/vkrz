<?php
global $uuiduser;
global $user_id;
global $vainkeur_info;
global $user_infos;
$vainkeur_info = isset($vainkeur_info) ? $vainkeur_info : $user_infos;
?>
<div class="card profile-header mb-2">

    <div class="card-img-top cover-profil"></div>

    <div class="position-relative">

        <div class="profile-img-container d-flex align-items-center">
            <div class="profile-img" style="background: url(<?php echo $vainkeur_info['avatar']; ?>) no-repeat center center;">
                
            </div>
            <div class="profile-title ml-3">
                <h2 class="text-white text-uppercase">
                    <?php echo is_user_logged_in() ? $vainkeur_info['pseudo'] : "Futur Vainkeur"; ?>
                </h2>
                <p class="text-white">
                    <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                        <?php echo $vainkeur_info['level']; ?>
                    </span>
                    <?php if($vainkeur_info['user_role']  == "administrator"): ?>
                        <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                            🦙
                        </span>
                    <?php endif; ?>
                    <?php if($vainkeur_info['user_role']  == "administrator" || $vainkeur_info['user_role'] == "author"): ?>
                        <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                            🎨
                        </span>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>

    <div class="profile-header-nav">
        <nav class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">
            <button class="btn btn-icon navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i data-feather="align-justify" class="font-medium-5"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="profile-tabs d-flex justify-content-between flex-wrap mt-1 mt-md-0">
                    <ul class="nav nav-pills mb-0">
                        <?php if(!is_author()): ?>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold <?php if(is_page(get_page_by_path('mon-compte'))){echo 'btn btn-primary';} ?>" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>?uuid=<?php echo $uuiduser; ?>">
                                    Récap
                                </a>
                            </li>
                            <?php if($vainkeur_info['user_role'] == "administrator" || $vainkeur_info['user_role'] == "author"): ?>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold <?php if(is_page(172849)){echo 'btn btn-primary';} ?>" href="<?php the_permalink(get_page_by_path('mon-compte/createur')); ?>">
                                        Créateur
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(is_user_logged_in()): ?>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold <?php if(is_page(get_page_by_path('parametres'))){echo 'btn btn-primary';} ?>" href="<?php the_permalink(get_page_by_path('parametres')); ?>">
                                        Editer mon profil
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                    <?php if(!is_author() && is_user_logged_in()): ?>
                        <div class="">
                            <a href="<?php echo get_author_posts_url($user_id); ?>" class="btn btn-outline-primary waves-effect">
                                Profil public
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</div>