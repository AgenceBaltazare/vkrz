<?php
function get_dodo(){
    $dodo       = get_best_vainkeur("money", "7", "1");
    $dodo_uuid  = $dodo[0]['uuid'];
    $dodo_infos = get_user_infos($dodo_uuid);

    if ($dodo_uuid) {
        if (!get_vainkeur_badge($dodo_infos['id_vainkeur'], "Dodo")) {
            update_vainkeur_badge($dodo_infos['id_vainkeur'], "Dodo");
            if (env() != "local") {
                $url    = "https://hook.integromat.com/t4m1rces3mtdluer1f9g91lemug5497y";
                $args   = array(
                    'body' => $dodo_infos
                );
                
                wp_remote_post($url, $args);
            }
        }
    }

    $result = array_merge($dodo, $dodo_infos);
    return $result;
}