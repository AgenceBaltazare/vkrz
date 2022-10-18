<?php 

  function deal_referred_to_tree($id_vainkeur, $money) {
    $money = intval($money);
    $referral_to_them = array();
    if (get_field('referral_to_them', $id_vainkeur)) {
      // GET THE FIRST ONE
      $referral_to_them = json_decode(get_field('referral_to_them', $id_vainkeur));
      
      // GIVE HIME MONEYY
      $first_referredTo_money        = get_field('money_vkrz', $referral_to_them[0]);
      update_field('money_vkrz', $first_referredTo_money + $money, $referral_to_them[0]);
      $first_referredTo_money_dispo  = get_field('money_disponible_vkrz', $referral_to_them[0]);
      update_field('money_disponible_vkrz', $first_referredTo_money_dispo + $money, $referral_to_them[0]);

      $no_more_referredTo = false;
      $tree = array();
      array_push($tree, $referral_to_them[0]);
      while(!$no_more_referredTo) {
        if(isset($referral_to_them[0])) {
          $referral_to_them = json_decode(get_field('referral_to_them', $referral_to_them[0]));
          
          if(isset($referral_to_them[0])) {
            // ADD TO THE TREE ARRAY
            array_push($tree, $referral_to_them[0]);

            // GIVE HIM SOME MONEY
            $tree_referredTo_money        = get_field('money_vkrz', $referral_to_them[0]);
            update_field('money_vkrz', $tree_referredTo_money + $money, $referral_to_them[0]);
            $tree_referredTo_money_dispo  = get_field('money_disponible_vkrz', $referral_to_them[0]);
            update_field('money_disponible_vkrz', $tree_referredTo_money_dispo + $money, $referral_to_them[0]);
          }
        } else {
          $no_more_referredTo = true;
        }
      }

      return $tree;
    }
  }

  function deal_referral($referral, $id_vainkeur, $keurz) {
    $referral     = intval($referral);
    $id_vainkeur  = intval($id_vainkeur);
    
    // PROCESS FOR ME… 
    $referral_to_them = array();
    if (get_field('referral_to_them', $id_vainkeur)) {
      $referral_to_them = json_decode(get_field('referral_to_them', $id_vainkeur));
    }
    if (!in_array($referral, $referral_to_them)) {
      $referral_uuid  = get_field('uuid_user_vkrz', $referral);
      $referral_infos = get_user_infos($referral_uuid);

      if($referral_infos['id_user']) {
        array_push($referral_to_them, $referral);
        update_field('referral_to_them', json_encode($referral_to_them), $id_vainkeur);

        // MONEY…
        $keurz_for_me = $keurz / 2;
        $user_money_for_me        = get_field('money_vkrz', $id_vainkeur);
        update_field('money_vkrz', $user_money_for_me + $keurz_for_me, $id_vainkeur);
        $user_money_for_me_dispo  = get_field('money_disponible_vkrz', $id_vainkeur);
        update_field('money_disponible_vkrz', $user_money_for_me_dispo + $keurz_for_me, $id_vainkeur);
      }
    }

    // PROCESS FOR WHO I'M REFERRED TO… 
    $referral_from_me = array();
    if (get_field('referral_from_me', $referral)) {
      $referral_from_me = json_decode(get_field('referral_from_me', $referral));
    }
    if (!in_array($id_vainkeur, $referral_from_me)) {
      array_push($referral_from_me, $id_vainkeur);
      update_field('referral_from_me', json_encode($referral_from_me), $referral);

      // NOTIFICATION PROCESS…
      $my_uuid                = get_field('uuid_user_vkrz', $id_vainkeur);
      $referredTo             = get_field('uuid_user_vkrz', $referral);

      $arr_cookie_options = array(
        'expires' => time() + 60 * 60 * 24 * 365,
        'path' => '/',
      );
      $arr_cookies_data = array(
        "referral" => $my_uuid,
        "referredTo" => $referredTo,
      );
      setcookie("wordpress_parrainage_cookies", json_encode($arr_cookies_data), $arr_cookie_options);

      // MONEY…
      $user_money_for_him        = get_field('money_vkrz', $referral);
      update_field('money_vkrz', $user_money_for_him + $keurz, $referral);
      $user_money_for_him_dispo  = get_field('money_disponible_vkrz', $referral);
      update_field('money_disponible_vkrz', $user_money_for_him_dispo + $keurz, $referral);
    }
  }

?>