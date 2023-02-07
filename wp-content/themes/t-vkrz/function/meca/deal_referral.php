<?php

function deal_referred_to_tree($id_vainkeur, $money)
{
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
    while (!$no_more_referredTo) {
      if (isset($referral_to_them[0])) {
        $referral_to_them = json_decode(get_field('referral_to_them', $referral_to_them[0]));

        if (isset($referral_to_them[0])) {
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

function deal_referral($referral, $id_vainkeur, $keurz)
{
  $referral     = intval(check_codeparrain($referral));
  $id_vainkeur  = intval($id_vainkeur);

  // PROCESS FOR ME… 
  $referred_to = get_field('referred_to', $id_vainkeur);
  if (!$referred_to && $referred_to != (string) $referral) {
    update_field('referred_to', $referral, $id_vainkeur);

    // MONEY…
    $my_keurz        = $keurz / 2;
    $my_money        = get_field('money_vkrz', $id_vainkeur);
    update_field('money_vkrz', $my_money + $my_keurz, $id_vainkeur);
    $my_money_dispo  = get_field('money_disponible_vkrz', $id_vainkeur);
    update_field('money_disponible_vkrz', $my_money_dispo + $my_keurz, $id_vainkeur);

    // PROCESS FOR WHO I'M REFERRED TO… 
    // MONEY for Parrain
    $my_keurz        = $keurz;
    $my_money        = get_field('money_vkrz', $referral);
    update_field('money_vkrz', $my_money + $my_keurz, $referral);
    $my_money_dispo  = get_field('money_disponible_vkrz', $referral);
    update_field('money_disponible_vkrz', $my_money_dispo + $my_keurz, $referral);

    $referral_from_me = array();
    if (get_field('referral_from_me', $referral)) {
      $referral_from_me = json_decode(get_field('referral_from_me', $referral));
    }
    if (!in_array($id_vainkeur, $referral_from_me)) {
      array_push($referral_from_me, $id_vainkeur);
      update_field('referral_from_me', json_encode($referral_from_me), $referral);
    }
  }
}
