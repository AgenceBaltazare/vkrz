<?php global $vainkeur_data_selected; global $id_vainkeur; ?>
<?php if ($vainkeur_data_selected['id_user']) : ?>
  <div id="jugement" class="card widget toplist_comments" data-id_vainkeur_actual="<?= $id_vainkeur; ?>" data-authorid="<?= $vainkeur_data_selected["id_user"] ?>" data-authorpseudo="<?= $vainkeur_data_selected["pseudo"] ?>" data-authoruuid="<?= $vainkeur_data_selected["uuid_vainkeur"] ?>" data-idranking="<?= $id_ranking; ?>" data-urlranking="<?= get_permalink($id_ranking); ?>">
    <div class="card-body">
      <h4 class="card-title">
        <span class="va va-hache va-lg"></span> Laisser un jugement
      </h4>
      <ul class="comments-container scrollable-container media-list info-jugement">

      </ul>
      <div class="card-footer border-0">
        <div class="d-flex align-items-center commentarea-container">
          <textarea name="comment" id="comment" placeholder="Juger…"></textarea>

          <button id="send_comment_btn">
            <span class="va va-icon-arrow-up va-z-40"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>