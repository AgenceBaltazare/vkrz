<?php
switch (get_post_type()) {
    case "tournoi":
        if (get_the_terms(get_the_ID(), 'categorie')[0]->term_id == get_term_by('slug', 'welcome', 'categorie')->term_id) {
            get_template_part("templates/single/t-welcome");
        } else {
            get_template_part("templates/single/t");
        }
        break;
    case "classement": get_template_part("templates/single/r");
        break;
    case "post": get_template_part("templates/single/post");
        break;
}
?>