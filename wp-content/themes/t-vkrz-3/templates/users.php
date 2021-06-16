<?php
/*
    Template Name: Users List
*/
global $uuiduser;
get_header();
?>
<div class="app-content content cover">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Tous les membres de VAINKEURZ
                    </h3>
                </div>
            </div>

            <?php
            $users_list = get_vkrz_users();
            ?>
            <div class="classement">
                <div class="container-fluid">
                    <section id="profile-info">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if($users_list) : ?>
                                    <div class="row" id="table-bordered">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title pt-1 pb-1">
                                                        Voici les <?php echo count($users_list); ?> membres de VAINKEURZ
                                                    </h4>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>
                                                                Champions
                                                            </th>
                                                            <th>Votes</th>
                                                            <th>Tops</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach($users_list as $user): ?>
                                                            <tr>

                                                                <td>
                                                                    <?php
                                                                    $champion_id    = $user['user_id'];
                                                                    $champion_data  = get_user_by('ID', $champion_id);
                                                                    ?>
                                                                    <span class="avatar">
                                                                        <span class="avatar-picture" style="background-image: url(<?php echo $user['user_avatar']; ?>);"></span>
                                                                        <?php if($user['user_level']): ?>
                                                                            <span class="user-niveau">
                                                                                <?php echo $user['user_level']; ?>
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </span>
                                                                    <span class="font-weight-bold championname">
                                                                        <?php echo $user['user_name']; ?>
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    <?php echo $user['user_votes']; ?> <span class="ico">💎</span>
                                                                </td>

                                                                <td>
                                                                    <?php echo $user['user_tops']; ?> <span class="ico">🏆</span>
                                                                </td>

                                                                <td>
                                                                    <a href="<?php echo esc_url(get_author_posts_url($champion_id)); ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                                                        <span class="ico ico-reverse">👀</span> Guetter tous ses Tops !
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>
</div>
<?php get_footer(); ?>