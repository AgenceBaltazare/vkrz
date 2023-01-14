<?php
global $banner;
global $url_ranking;
global $id_top_global;
global $first_id_contender;
global $second_id_contender;
global $third_id_contender;
global $top_infos;
?>
<div class="offcanvas offcanvas-bottom bg-deg" tabindex="-1" id="sharetoplist">
  <div class="offcanvas-header">
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <h5 class="offcanvas-title">
      <span class="va va-backhand-index-pointing-right va-lg"></span>
      Partage ta TopList
      <span class="va va-backhand-index-pointing-right va-lg va-reverse"></span>
      <br>
      <small>Pas besoin de screen ! Une image de ton Top 3 sera ajoutée automatiquement à ton post avec le lien</small>
    </h5>
    <div class="share-classement-content-box">
      <div class="left">
        <img src="<?php echo $banner ?>" alt="Top3 ">
      </div>
      <div class="right">
        <a href="<?php echo $banner; ?>" download target="_blank">
          <i class="social-media fas fa-download"></i> Télécharge l'image de ta TopList
        </a>

        <a href="#" class="sharelinkbtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien de ta TopList">
          <input type="text" value="<?php echo $url_ranking; ?>" class="input_to_share">
          <i class="social-media fas fa-paperclip"></i> Copie le lien de la TopList
        </a>

        <?php if (get_field('tweet_personnalise_t', $id_top_global)) : ?>
          <a href="https://twitter.com/intent/tweet?text=<?php the_field('tweet_personnalise_t', $id_top_global); ?>&via=<?php the_field('a_personnalise_t', $id_top_global); ?>&hashtags=<?php the_field('#top_twitter', $id_top_global); ?>&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
            <i class="social-media fab fa-twitter"></i> Twitter
          </a>
        <?php else : ?>
          <?php if (get_field('@_twitter', $id_top_global)) : ?>
            <?php
            $arobaseFirstContender = get_field('info_supplementaire_contender', $first_id_contender);
            $arobaseSecondContender = get_field('info_supplementaire_contender', $second_id_contender);
            $arobaseThirdContender = get_field('info_supplementaire_contender', $third_id_contender);
            ?>
            <a href="https://twitter.com/intent/tweet?text=Voici ma TopList <?php echo $top_infos['top_title']; ?>%0a🥇<?= $arobaseFirstContender ?> 🥈<?= $arobaseSecondContender ?> 🥉<?= $arobaseThirdContender ?>%0a&via=vainkeurz&hashtags=VKRZ&hashtags=<?php echo get_field('#top_twitter', $id_top_global) ?>&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
              <i class="social-media fab fa-twitter"></i> Twitter
            </a>
          <?php else :  ?>
            <a href="https://twitter.com/intent/tweet?text=Voici ma TopList <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
              <i class="social-media fab fa-twitter"></i> Twitter
            </a>
          <?php endif; ?>
        <?php endif; ?>

        <a href="whatsapp://send?text=<?php echo $url_ranking; ?>" data-action="share/whatsapp/share">
          <i class="social-media fab fa-whatsapp"></i> WhatsApp
        </a>

        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_ranking; ?>" title="Partager sur Facebook" target="_blank">
          <i class="social-media fab fa-facebook-f"></i> Facebook
        </a>
      </div>
    </div>
  </div>
</div>