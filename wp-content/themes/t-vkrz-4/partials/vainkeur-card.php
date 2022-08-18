<?php global $vainkeur_data_selected; ?>
<div class="vainkeur-card">
    <a href="<?php echo esc_url(get_author_posts_url($vainkeur_data_selected['id_user'])); ?>" class="btn btn-flat-primary waves-effect">
        <span class="avatar">
            <span class="avatar-picture" style="background-image: url(<?php echo $vainkeur_data_selected['avatar']; ?>);"></span>
        </span>
        <span class="championname">
            <h4><?php echo $vainkeur_data_selected['pseudo']; ?></h4>
            <span class="medailles">
                <?php echo $vainkeur_data_selected['level']; ?>
                <?php if ($vainkeur_data_selected['user_role'] == "administrator") : ?>
                    <span class="va va-vkrzteam va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ"></span>
                <?php endif; ?>
                <?php if ($vainkeur_data_selected['user_role'] == "administrator" || $vainkeur_data_selected['user_role'] == "author") : ?>
                    <span class="va va-man-singer va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops"></span>
                <?php endif; ?>
            </span>
        </span>
    </a>
</div>