<?php
include __DIR__ . '/../../../../../wp-load.php';

//
// Change ELO
//
$t          = $_GET['t'];
$url_t      = get_the_permalink($t);
$v          = $_GET['v'];
$l          = $_GET['l'];
$k          = 16;
$u          = 0;

$elo_v      = get_field('ELO_c', $v);
$elo_l      = get_field('ELO_c', $l);

$rank_v = 1 / ( 1 + ( pow( 10 , ( $elo_l - $elo_v ) / 400 ) ) );
$rank_l = 1 / ( 1 + ( pow( 10 , ( $elo_v - $elo_l ) / 400 ) ) );

$new_score_v = floor($elo_v + $k*(1 - $rank_v));
$new_score_l = floor($elo_l + $k*(0 - $rank_l));


/*echo "V : ".$elo_v."<br>";
echo "L : ".$elo_l."<br>";

echo "V : ".$rank_v."<br>";
echo "L : ".$rank_l."<br>";

echo "V : ".$new_score_v."<br>";
echo "L : ".$new_score_l."<br>";*/


update_field('ELO_c', $new_score_v, $v);
update_field('ELO_c', $new_score_l, $l);

//
// Add vote
//
if (is_user_logged_in()) {
    $current_user   = wp_get_current_user();
    $u              = $current_user->ID;
}

$new_vote = array(
    'post_type'     => 'vote',
    'post_title'    => 'U:'.$u.' T:'.$t.' V:'.$v.'('.$elo_v.')'.' L:'.$l.'('.$elo_l.')',
    'post_status'   => 'publish',
);
$id_vote = wp_insert_post($new_vote);

update_field('id_user_v', $u, $id_vote);
update_field('id_v_v', $v, $id_vote);
update_field('elo_v_v', $elo_v, $id_vote);
update_field('id_l_v', $l, $id_vote);
update_field('elo_l_v', $elo_l, $id_vote);
update_field('id_t_v', $t, $id_vote);

//
// Finish
//
wp_redirect($url_t);