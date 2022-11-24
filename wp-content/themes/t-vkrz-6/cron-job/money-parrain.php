<?php
include __DIR__ . '/../../../../wp-load.php';
/**
* CRON JOB : Update money generated par les enfants
*
* When : Everyday @ 02:30
*/

$vainkeurs_with_child = new WP_Query(array(
    'ignore_sticky_posts'	=> true,
    'update_post_meta_cache' => false,
    'no_found_rows'		  => true,
    'post_type'			  => 'vainkeur',
    'orderby'				=> 'date',
    'order'				  => 'DESC',
    'posts_per_page'		 => -1,
    'meta_query' => array(
        array(
            'key'     => 'referral_from_me',
            'compare' => 'EXISTS',
        ),
    ),
));
while ($vainkeurs_with_child->have_posts()) : $vainkeurs_with_child->the_post(); 

    $money_parrainage = 0;

    $enfants = json_decode(get_field('referral_from_me', $id_vainkeur));
        foreach ($enfants as $referral) :
            $referral_uuid          = get_field('uuid_user_vkrz', $referral);
            $infos_referral         = get_user_infos($referral_uuid, 'complete');
            $xp                     = $infos_referral["money_vkrz"];
            $get_enfant_money       = round($xp * 0.1);
            $money_parrainage_vkrz  = $money_parrainage_vkrz + $get_enfant_money + 200;

            for ($e = 1; $e < 100; $e++) :
                $enfants = json_decode(get_field('referral_from_me', $referral));
                if ($enfants) :
                    foreach ($enfants as $referral) :
                        $referral_uuid          = get_field('uuid_user_vkrz', $referral);
                        $infos_referral         = get_user_infos($referral_uuid, 'complete');
                        $xp                     = $infos_referral["money_vkrz"];
                        switch ($e) {
                            case 1:
                                $price_inscription = 100;
                                $price_percent     = 0.07;
                                break;
                            case 2:
                                $price_inscription = 50;
                                $price_percent     = 0.05;
                                break;
                            case 3:
                                $price_inscription = 10;
                                $price_percent     = 0.03;
                                break;
                            default:
                                $price_inscription = 5;
                                $price_percent     = 0.01;
                        }
                        $get_enfant_money       = round($xp * $price_percent);
                        $money_parrainage_vkrz  = $money_parrainage_vkrz + $get_enfant_money + $price_inscription;
                    endforeach;
                endif;
            endfor;
    endforeach;

    update_field('money_parrainage_vkrz', $money_parrainage_vkrz, $id_vainkeur);
    
endwhile;
wp_reset_query();