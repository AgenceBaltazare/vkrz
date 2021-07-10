<?php
global $uuiduser;
global $current_user;
global $user_id;
global $nb_user_votes;
global $user_full_data;
global $info_user_level;
global $list_t_done;
global $user_role;
global $champion_id;
global $champion;
global $champion_role;
if($champion_id){
    $user_id      = $champion_id;
    $current_user = $champion;
    $user_role    = $champion_role;
}
?>
<div class="card profile-header mb-2">

    <div class="card-img-top cover-profil"></div>

    <div class="position-relative">

        <div class="profile-img-container d-flex align-items-center">
            <?php
            if(is_user_logged_in() && get_avatar_url($user_id, ['size' => '80'])){
                $avatar_url = get_avatar_url($user_id, ['size' => '80']);
            }
            else{
                $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
            }
            ?>
            <div class="profile-img">
                <img src="<?php echo $avatar_url; ?>" class="avatar img-fluid" alt="Avatar"/>
            </div>
            <div class="profile-title ml-3">
                <h2 class="text-white text-uppercase">
                    <?php if(is_user_logged_in()): ?>
                        <?php echo $current_user->nickname; ?>
                    <?php else: ?>
                        Anonyme
                    <?php endif; ?>
                </h2>
                <p class="text-white">
                    <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                        <?php echo $info_user_level['level_ico']; ?>
                    </span>
                    <?php if($user_role == "administrator" || $user_role == "author"): ?>
                        <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Membre de la TeamVKRZ">
                            🦙
                        </span>
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
                            <?php if($user_role == "administrator" || $user_role == "author"): ?>
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
                    <?php if(!is_author()): ?>
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