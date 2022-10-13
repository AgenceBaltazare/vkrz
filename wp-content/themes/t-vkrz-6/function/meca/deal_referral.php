<?php 

function deal_referral($referral, $id_vainkeur, $keurz) {
  $referral     = intval($referral);
  $id_vainkeur  = intval($id_vainkeur);

  // PROCESS FOR ME… 
  $referral_to_them = array();
  if (get_field('referral_to_them', $id_vainkeur)) {
    $referral_to_them = json_decode(get_field('referral_to_them', $id_vainkeur));
  }
  if (!in_array($referral, $referral_to_them)) {
    array_push($referral_to_them, $referral);
    update_field('referral_to_them', json_encode($referral_to_them), $id_vainkeur);

    // MONEY…
    $user_money_for_me        = get_field('money_vkrz', $id_vainkeur);
    update_field('money_vkrz', $user_money_for_me + ($keurz / 2), $id_vainkeur);
    $user_money_for_me_dispo  = get_field('money_disponible_vkrz', $id_vainkeur);
    update_field('money_disponible_vkrz', $user_money_for_me_dispo + ($keurz / 2), $id_vainkeur);
  }

  // PROCESS FOR WHO I'M REFERRAL TO HIM… 
  $referral_from_me = array();
  if (get_field('referral_from_me', $referral)) {
    $referral_from_me = json_decode(get_field('referral_from_me', $referral));
  }
  // if (!in_array($id_vainkeur, $referral_from_me)) {
    array_push($referral_from_me, $id_vainkeur);
    update_field('referral_from_me', json_encode($referral_from_me), $referral);

    // NOTIFICATION PROCESS…
    // $my_uuid                = get_field('uuid_user_vkrz', $id_vainkeur);
    // $my_infos               = get_user_infos($my_uuid, 'complete');

    // $referral_to_uuid       = get_field('uuid_user_vkrz', $referral);
    // $referral_to_infos      = get_user_infos($referral_to_uuid, 'complete');

    // MONEY…
    $user_money_for_him        = get_field('money_vkrz', $referral);
    update_field('money_vkrz', $user_money_for_him + 40, $referral);
    $user_money_for_him_dispo  = get_field('money_disponible_vkrz', $referral);
    update_field('money_disponible_vkrz', $user_money_for_him_dispo + $keurz, $referral);

    $template_data       = wp_get_theme();
    $template_version    = $template_data['Version'];
    wp_enqueue_script('deal_parrainage', get_template_directory_uri() . '/function/firebase/deal_parrainage.js', array(), $template_version, true);

    ob_start();
    ?>
    <script>
        jQuery(document).ready(function ($){
          callMe('Adil');
        });
    </script>
    <?php
    echo ob_get_clean();
  // }
}