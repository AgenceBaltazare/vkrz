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
                        Top 20 des champions
                    </h3>
                </div>
            </div>
            <?php
            $users_list = get_vkrz_users(20);
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
                                                        <span class="t-rose">TOP 20</span> des champions
                                                    </h4>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>🏁</th>
                                                            <th>🤴</th>
                                                            <th class="text-right">💎</th>
                                                            <th class="text-right">🏆</th>
                                                            <th>👀</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $r=1; foreach($users_list as $user): ?>
                                                            <tr>
                                                                <td>
                                                                    <?php if($r == 1): ?>
                                                                        <span class="ico">🥇</span>
                                                                    <?php elseif($r == 2): ?>
                                                                        <span class="ico">🥈</span>
                                                                    <?php elseif($r == 3): ?>
                                                                        <span class="ico">🥉</span>
                                                                    <?php else: ?>
                                                                        #<?php echo $r; ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <?php
                                                                        $champion_id    = $user['user_id'];
                                                                        $champion_data  = get_user_by('ID', $champion_id);
                                                                        ?>
                                                                        <div class="avatar">
                                                                            <span class="avatar-picture" style="background-image: url(<?php echo $user['user_avatar']; ?>);"></span>
                                                                            <?php if($user['user_level']): ?>
                                                                                <span class="user-niveau">
                                                                                <?php echo $user['user_level']; ?>
                                                                            </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="font-weight-bold championname">
                                                                        <span>
                                                                            <?php echo $user['user_name']; ?>
                                                                        </span>
                                                                            <?php if($user['user_role'] == "administrator"): ?>
                                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                🦙
                                                                            </span>
                                                                            <?php endif; ?>
                                                                            <?php if($user['user_role'] == "administrator" || $user['user_role'] == "author"): ?>
                                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                                🎨
                                                                            </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td class="text-right">
                                                                    <?php echo $user['user_votes']; ?> <span class="ico">💎</span>
                                                                </td>

                                                                <td class="text-right">
                                                                    <?php echo $user['user_tops']; ?> <span class="ico">🏆</span>
                                                                </td>

                                                                <td>
                                                                    <a href="<?php echo esc_url(get_author_posts_url($champion_id)); ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                                                        Guetter ses Tops
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php $r++; endforeach; ?>
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