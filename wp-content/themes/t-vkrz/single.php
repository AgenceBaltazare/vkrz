<?php
if(get_post_type() == "tournoi"){
    get_template_part("templates/single/t");
}
elseif(get_post_type() == "classement"){
    get_template_part("templates/single/r");
}
?>