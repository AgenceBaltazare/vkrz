<?php global $top_datas;
global $id_top_global; ?>
<div class="widget-blank">
  <div class="widget-blank-body">
    <div class="mb-2">
      <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_top_global; ?>" class="w-100 btn btn-violet waves-effect waves-light btn-block">
        <div class="wording-btn">
          <div class="main-wording">
            Découvre la TopList mondiale générée par les <?php echo $top_datas['nb_votes']; ?> votes <span class="va va-high-voltage va-md me-1"></span>
          </div>
          <div class="second-wording">
            <span class="ressemblancemondialewording">Cette TopList y ressemble à </span>
            <span id="ressemblance-mondiale">
              <span class="">
                <div class="loader loader--style1" title="0">
                  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                    <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
                    <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                    C22.32,8.481,24.301,9.057,26.013,10.047z">
                      <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
                    </path>
                  </svg>
                </div>
              </span>
            </span>
          </div>
        </div>
      </a>
    </div>
    <div class="mb-2">
      <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_top_global; ?>" class="w-100 btn btn-violet waves-effect waves-light btn-block">
        <div class="wording-btn">
          <div class="main-wording">
            Guette les <?php echo $top_datas['nb_tops']; ?> TopList <span class="va va-trophy va-md me-1"></span>
          </div>
          <div class="second-wording">
            et découvre qui te ressemble le +
          </div>
        </div>
      </a>
    </div>
  </div>
</div>