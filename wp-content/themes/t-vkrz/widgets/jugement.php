<?php
global $vainkeur_data_selected;
global $id_vainkeur;
global $id_ranking;
if ($vainkeur_data_selected['id_user']) : ?>
  <div class="offcanvas offcanvas-end toplist_comments bg-deg" data-id_vainkeur_actual="<?= $id_vainkeur; ?>" data-authorid="<?= $vainkeur_data_selected["id_user"] ?>" data-authorpseudo="<?= $vainkeur_data_selected["pseudo"] ?>" data-authoruuid="<?= $vainkeur_data_selected["uuid_vainkeur"] ?>" data-idranking="<?= $id_ranking; ?>" data-urlranking="<?= get_permalink($id_ranking); ?>" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="jugement" aria-labelledby="offcanvasScrollLabel">
    <div class="offcanvas-header">
      <h5 id="offcanvasScrollLabel" class="offcanvas-title">
        <span class="va va-hache va-lg"></span> Laisser un jugement
      </h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body my-auto mx-0 flex-grow-0">
      <ul class="comments-container scrollable-container media-list info-jugement overflow-hidden">

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