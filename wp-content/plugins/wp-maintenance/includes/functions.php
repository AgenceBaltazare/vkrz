<?php

defined( 'ABSPATH' )
	or die( 'No direct load ! ' );


function wpm_get_header( $message = 0) {
       
    $getHeader = '<h2 style="font-size: 23px;font-weight: 400;padding: 9px 15px 4px 0px;line-height: 29px;">'.__('WP Maintenance - Settings', 'wp-maintenance').' <sup>v.'.WPM_VERSION.'</sup>
</h2>';
    if( $message == 1 ) {
        $getHeader .= '<div id="message" class="updated fade"><p><strong>'.__('Options saved.', 'wp-maintenance').'</strong></p></div>';
    }
    return $getHeader;
}

function wpm_get_nav() {
    
    global $current_user;
    global $_wp_admin_css_colors;
    
    $admin_color = get_user_option( 'admin_color', get_current_user_id() );
    $colors      = $_wp_admin_css_colors[$admin_color]->colors;
    
    $tabOptions = array(
        
        'wp-maintenance' => array(
            'dashicons' => 'dashicons-admin-settings',
            'link' => 'wp-maintenance',
            'text' => __('Dashboard', 'wp-maintenance'),
            'desc' => __('Here, the beginning...', 'wp-maintenance')
            ),
        'wp-maintenance-colors' => array(
            'dashicons' => 'dashicons-art',
            'link' => 'wp-maintenance-colors',
            'text' => __('Colors and Fonts', 'wp-maintenance'),
            'desc' => __('Have a creative mind', 'wp-maintenance')
            ),
        'wp-maintenance-picture' => array(
            'dashicons' => 'dashicons-format-gallery',
            'link' => 'wp-maintenance-picture',
            'text' => __('Pictures', 'wp-maintenance'),
            'desc' => __('Are we playing with the images?', 'wp-maintenance')
            ),
        'wp-maintenance-countdown' => array(
            'dashicons' => 'dashicons-clock',
            'link' => 'wp-maintenance-countdown',
            'text' => __('Countdown', 'wp-maintenance'),
            'desc' => __('Stop the time... or not!', 'wp-maintenance')
            ),
        'wp-maintenance-css' => array(
            'dashicons' => 'dashicons-media-code',
            'link' => 'wp-maintenance-css',
            'text' => __('CSS', 'wp-maintenance'),
            'desc' => __('Customize the style sheet', 'wp-maintenance')
            ),
        'wp-maintenance-seo' => array(
            'dashicons' => 'dashicons-admin-site-alt',
            'link' => 'wp-maintenance-seo',
            'text' => __('SEO', 'wp-maintenance'),
            'desc' => __('Keep your site optimized', 'wp-maintenance')
            ),
        'wp-maintenance-socialnetworks' => array(
            'dashicons' => 'dashicons-format-status',
            'link' => 'wp-maintenance-socialnetworks',
            'text' => __('Social Networks', 'wp-maintenance'),
            'desc' => __('Adding social networks icons', 'wp-maintenance')
            ),
        'wp-maintenance-footer' => array(
            'dashicons' => 'dashicons-table-row-before',
            'link' => 'wp-maintenance-footer',
            'text' => __('Footer', 'wp-maintenance'),
            'desc' => __('Here, we are talking about the footer', 'wp-maintenance')
            ),
        'wp-maintenance-settings' => array(
            'dashicons' => 'dashicons-admin-generic',
            'link' => 'wp-maintenance-settings',
            'text' => __('Settings', 'wp-maintenance'),
            'desc' => __('A few additional options', 'wp-maintenance')
            )
    );
    
    $getDashicons = '<div class="wp-maintenance-modules-sidebar">';
    $getDashicons .= '<a href="https://madeby.restezconnectes.fr/project/wp-maintenance/" alt="'.__('Visit the WP Maintenance page project.', 'wp-maintenance').'" title="'.__('Visit the WP Maintenance page project.', 'wp-maintenance').'"><div class="wp-maintenance-sidebar-header"><img src="'.plugins_url('wp-maintenance/images/logo-sidebar.png').'" width="238" height="120" valign="bottom"  /></div></a>';
    
    $getDashicons .= '<a href="'.site_url().'/?wpmpreview=true" target="_blank" alt="'.__('Preview page', 'wp-maintenance').'" title="'.__('Preview page', 'wp-maintenance').'" class="wpmadashicons" onFocus="this.blur()" style="color:#23282d;text-decoration:none;"><div style="background:#D6D5AA;color:#23282d;padding:1em 1em;margin: 1em 1em;text-align:center;"><span class="dashicons dashicons-external" style="font-size:20px;" ></span> '.__('Preview page', 'wp-maintenance').'</div></a>';

    $getDashicons .= '<ul id="wp-maintenance-modules-navigation" class="wp-maintenance-modules-list-links">';
        
    foreach( $tabOptions as $page=>$values) {
        

        if (isset($_GET['page']) && $_GET['page']!=$page ) { $active = ''; } else { $active = 'active'; }
        
        $getDashicons .= '<li>';
        $getDashicons .= '<a href="'.admin_url().'admin.php?page='.$page.'" alt="'.$tabOptions[$page]['text'].'" title="'.$tabOptions[$page]['text'].'" class="'.$active.' module-'.$page.'" onFocus="this.blur()">';
        $getDashicons .= '<span class="wp-maintenance-tab-name">'.$tabOptions[$page]['text'].'</span> <span class="wp-maintenance-tab-summary">'.$tabOptions[$page]['desc'].'</span>';
        $getDashicons .= '<span class="dashicons wpmdashicons '.$tabOptions[$page]['dashicons'].'"></span></a>';
        $getDashicons .= '</li>';

        
    }
    $getDashicons .= '</ul>';
    $getDashicons .= '<div class="clear">&nbsp;</div>';
    $getDashicons .= '<div style="padding:1em 1em;margin: 1em 1em;color:#D6D5AA;">'.__('This plugin has been developed for you for free by <a href="https://restezconnectes.fr" target="_blank" style="color:#D6D5AA;">Florent Maillefaud</a>. It is royalty free, you can take it, modify it, distribute it as you see fit.', 'wp-maintenance').'<br />';
        /* FAIRE UN DON SUR PAYPAL */
    $getDashicons .= '<br />'.__('Support this extension and my other developments (French Paypal):', 'wp-maintenance').'<br /><br />
        <div style="">
            <a href="https://paypal.me/RestezConnectes/20" target="_blank" style="color:#D6D5AA;text-decoration:none;border: 2px solid #D6D5AA;padding: 0.56em;">'.__('Donate now!', 'wp-maintenance').'</a>
        </div>
    </div>';
/* FIN FAIRE UN DON */
    $getDashicons .= '</div>';
    
    return $getDashicons;
}

function wpm_update_settings($tabPost) {
    
    // Récupère les paramètres sauvegardés Temporairement
    if(get_option('wp_maintenance_settings')) { extract(get_option('wp_maintenance_settings')); }
    $paramTemp = get_option('wp_maintenance_settings');
    
    // Je recupère le tableau temporaire des données
    if( isset($paramTemp) && !empty($paramTemp) ) {
        foreach($paramTemp as $variable=>$value) {
            //var_dump($variable.' =====> '.$value.'<br />');
            
            // pour chaque clé du tableau de regarde si elle existe déjà
            if ( array_key_exists($variable, $paramTemp) ) {
                // Si la clé est la même que venant du post je la change
                if( isset($tabPost[$variable]) ) { 
                    array_fill_keys($paramTemp, $tabPost[$variable]);
                }
            }
        }
    }
   
    if( isset($paramTemp) && is_array($paramTemp) ) {
         // Si le tableau temporaire existe je le fusionne avec les données $_POST["wp_maintenance_settings"]
        $paramData = array_merge($paramTemp, $tabPost);
    } else {
        // Sinon je garde le $_POST["wp_maintenance_settings"] en cours
        $paramData = $tabPost;
    }
    if(update_option('wp_maintenance_settings', $paramData)) {
        return true;
    }
}

function wpm_sidebar() {
    
    $wpmSidebar = '<div id="wpm-column2">';
    
    /* ABOUT */
    $wpmSidebar .= '<div style="border: 1px solid #ddd;background-color:#fff;padding:10px;text-align:center;margin-bottom:5px;">'.__('ABOUT', 'wp-maintenance').'</div>';
    
     $wpmSidebar .= '<div style="text-align:justify;background-color:#fff;padding:10px;margin-bottom: 10px;">'.__('This plugin has been developed for you for free by <a href="https://restezconnectes.fr" target="_blank">Florent Maillefaud</a>. It is royalty free, you can take it, modify it, distribute it as you see fit.', 'wp-maintenance').'<br /><br />';
    $wpmSidebar .= ''.__('Visit', 'wp-maintenance').' <a href="https://madeby.restezconnectes.fr" target="_blank">WP Maintenance</a>, '.__('try the demo of the plugin, talk about this plugin to your surroundings!', 'wp-maintenance').'<br /><br />';
    /* FAIRE UN DON SUR PAYPAL */
    $wpmSidebar .= ''.__('Support this extension and my other developments (French Paypal):', 'wp-maintenance').'<br /><br />
        <div style="width:220px;margin-left:auto;margin-right:auto;padding:5px;">
            <a href="https://paypal.me/RestezConnectes/20" target="_blank" class="wpmclassname">
                <img src="'.WPM_PLUGIN_URL.'images/donate.png" valign="bottom" width="64" /> Donate now!
            </a>
        </div>
    </div>';
    /* FIN FAIRE UN DON */
    
    /* END ABOUT */
    
    /* DISCOVER*/
    $wpmSidebar .= '<div style="border: 1px solid #ddd;background-color:#fff;padding:10px;text-align:center;margin-bottom:5px;">'.__('DISCOVER', 'wp-maintenance').'</div>';
    
    $imagePub = array(
        'extension-send-pdf-for-cf7.png' => 'https://wordpress.org/plugins/send-pdf-for-contact-form-7/'
    );
    
    foreach( $imagePub as $img=>$link ) {
        $wpmSidebar .= '<a href="'.$link.'" target="_blank"><img src="'.WPM_PLUGIN_URL.'images/'.$img.'" /></a>';
    }
    /* END DISCOVER */
    
    $wpmSidebar .= '</div>'; // Div general
    $wpmSidebar .= '<div class="clear"></div>';
    
    return $wpmSidebar;
}

function wpm_footer() {
    
    $wpmFooter = '
    <div style="margin-top:40px;">
        <a href="https://madeby.restezconnectes.fr" target="_blank">'.__('WP Maintenance','wp-maintenance').' (v.'.WPM_VERSION.')</a> '.__('is brought to you by','wp-maintenance').' <a href="https://restezconnectes.fr/" target="_blank">Restez Connectés</a> - '.__('If you found this plugin useful','wp-maintenance').' <a href="https://wordpress.org/support/view/plugin-reviews/wp-maintenance" target="_blank">'.__('give it 5 &#9733; on WordPress.org','wp-maintenance').'</a>
    </div>
    ';
    
    return $wpmFooter;
    
}

/* Liste les différents Rôles */
function wpm_get_roles() {

    $wp_roles = new WP_Roles();
    $roles = $wp_roles->get_names();
    $roles = array_map( 'translate_user_role', $roles );

    return $roles;
}

/* Retourne la vraie adresse IP */
function wpm_get_ip() {

	// IP si internet partagé
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	// IP derrière un proxy
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	// Sinon : IP normale
	else {
		return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	}

}

function wpm_change_active($value = 0) {

    update_option('wp_maintenance_active', $value);
    $statusActive = get_option('wp_maintenance_active');
    if( isset($statusActive)  ) {
        return $statusActive;
    }
}

function wpm_array_value_count ($array) {
    $count = 0;
   
    foreach ($array as $key => $value)
    {
            if($value) { $count++; }
    }
   
    return $count;
} 

function wpm_getFontsTab() {
    return array("Abel", "Abril Fatface", "Aclonica", "Acme", "Actor", "Adamina", "Advent Pro",
			"Aguafina Script", "Aladin", "Aldrich", "Alegreya", "Alegreya SC", "Alex Brush", "Alfa Slab One", "Alice",
			"Alike", "Alike Angular", "Allan", "Allerta", "Allerta Stencil", "Allura", "Almendra", "Almendra SC", "Amaranth",
			"Amatic SC", "Amethysta", "Andada", "Andika", "Angkor", "Annie Use Your Telescope", "Anonymous Pro", "Antic",
			"Antic Didone", "Antic Slab", "Anton", "Arapey", "Arbutus", "Architects Daughter", "Arimo", "Arizonia", "Armata",
			"Artifika", "Arvo", "Asap", "Asset", "Astloch", "Asul", "Atomic Age", "Aubrey", "Audiowide", "Average",
			"Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", "Averia Serif Libre", "Bad Script", "Balthazar",
			"Bangers", "Basic", "Battambang", "Baumans", "Bayon", "Belgrano", "Belleza", "Bentham", "Berkshire Swash",
			"Bevan", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Bitter", "Black Ops One", "Bokor", "Bonbon", "Boogaloo",
			"Bowlby One", "Bowlby One SC", "Brawler", "Bree Serif", "Bubblegum Sans", "Buda", "Buenard", "Butcherman",
			"Butterfly Kids", "Cabin", "Cabin Condensed", "Cabin Sketch", "Caesar Dressing", "Cagliostro", "Calligraffitti",
			"Cambo", "Candal", "Cantarell", "Cantata One", "Cardo", "Carme", "Carter One", "Caudex", "Cedarville Cursive",
			"Ceviche One", "Changa One", "Chango", "Chau Philomene One", "Chelsea Market", "Chenla", "Cherry Cream Soda",
			"Chewy", "Chicle", "Chivo", "Coda", "Coda Caption", "Codystar", "Comfortaa", "Coming Soon", "Concert One",
			"Condiment", "Content", "Contrail One", "Convergence", "Cookie", "Copse", "Corben", "Cousine", "Coustard",
			"Covered By Your Grace", "Crafty Girls", "Creepster", "Crete Round", "Crimson Text", "Crushed", "Cuprum", "Cutive",
			"Damion", "Dancing Script", "Dangrek", "Dawning of a New Day", "Days One", "Delius", "Delius Swash Caps", 
			"Delius Unicase", "Della Respira", "Devonshire", "Didact Gothic", "Diplomata", "Diplomata SC", "Doppio One", 
			"Dorsa", "Dosis", "Dr Sugiyama", "Droid Sans", "Droid Sans Mono", "Droid Serif", "Duru Sans", "Dynalight",
			"EB Garamond", "Eater", "Economica", "Electrolize", "Emblema One", "Emilys Candy", "Engagement", "Enriqueta",
			"Erica One", "Esteban", "Euphoria Script", "Ewert", "Exo", "Expletus Sans", "Fanwood Text", "Fascinate", "Fascinate Inline",
			"Federant", "Federo", "Felipa", "Fjord One", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", "Forum",
			"Francois One", "Fredericka the Great", "Fredoka One", "Freehand", "Fresca", "Frijole", "Fugaz One", "GFS Didot",
			"GFS Neohellenic", "Galdeano", "Gentium Basic", "Gentium Book Basic", "Geo", "Geostar", "Geostar Fill", "Germania One",
			"Give You Glory", "Glass Antiqua", "Glegoo", "Gloria Hallelujah", "Goblin One", "Gochi Hand", "Gorditas",
			"Goudy Bookletter 1911", "Graduate", "Gravitas One", "Great Vibes", "Gruppo", "Gudea", "Habibi", "Hammersmith One",
			"Handlee", "Hanuman", "Happy Monkey", "Henny Penny", "Herr Von Muellerhoff", "Holtwood One SC", "Homemade Apple",
			"Homenaje", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica SC",
			"IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer",
			"IM Fell Great Primer SC", "Iceberg", "Iceland", "Imprima", "Inconsolata", "Inder", "Indie Flower", "Inika",
			"Irish Grover", "Istok Web", "Italiana", "Italianno", "Jim Nightshade", "Jockey One", "Jolly Lodger", "Josefin Sans",
			"Josefin Slab", "Judson", "Julee", "Junge", "Jura", "Just Another Hand", "Just Me Again Down Here", "Kameron",
			"Karla", "Kaushan Script", "Kelly Slab", "Kenia", "Khmer", "Knewave", "Kotta One", "Koulen", "Kranky", "Kreon",
			"Kristi", "Krona One", "La Belle Aurore", "Lancelot", "Lato", "League Script", "Leckerli One", "Ledger", "Lekton",
			"Lemon", "Lilita One", "Limelight", "Linden Hill", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow",
			"Londrina Sketch", "Londrina Solid", "Lora", "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel",
			"Luckiest Guy", "Lusitana", "Lustria", "Macondo", "Macondo Swash Caps", "Magra", "Maiden Orange", "Mako", "Marck Script",
			"Marko One", "Marmelad", "Marvel", "Mate", "Mate SC", "Maven Pro", "Meddon", "MedievalSharp", "Medula One", "Merriweather",
			"Metal", "Metamorphous", "Michroma", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua",
			"Molengo", "Monofett", "Monoton", "Monsieur La Doulaise", "Montaga", "Montez", "Montserrat", "Moul", "Moulpali",
			"Mountains of Christmas", "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards",
			"Muli", "Mystery Quest", "Neucha", "Neuton", "News Cycle", "Niconne", "Nixie One", "Nobile", "Nokora", "Norican",
			"Nosifer", "Nothing You Could Do", "Noticia Text", "Nova Cut", "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round",
			"Nova Script", "Nova Slim", "Nova Square", "Numans", "Nunito", "Odor Mean Chey", "Old Standard TT", "Oldenburg",
			"Oleo Script", "Open Sans", "Open Sans Condensed", "Orbitron", "Original Surfer", "Oswald", "Over the Rainbow",
			"Overlock", "Overlock SC", "Ovo", "Oxygen", "PT Mono", "PT Sans", "PT Sans Caption", "PT Sans Narrow", "PT Serif",
			"PT Serif Caption", "Pacifico", "Parisienne", "Passero One", "Passion One", "Patrick Hand", "Patua One", "Paytone One",
			"Permanent Marker", "Petrona", "Philosopher", "Piedra", "Pinyon Script", "Plaster", "Play", "Playball", "Playfair Display",
			"Podkova", "Poiret One", "Poller One", "Poly", "Pompiere", "Pontano Sans", "Port Lligat Sans", "Port Lligat Slab",
			"Prata", "Preahvihear", "Press Start 2P", "Princess Sofia", "Prociono", "Prosto One", "Puritan", "Quantico",
			"Quattrocento", "Quattrocento Sans", "Questrial", "Quicksand", "Qwigley", "Radley", "Raleway", "Rammetto One",
			"Rancho", "Rationale", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Rochester",
			"Rock Salt", "Rokkitt", "Ropa Sans", "Rosario", "Rosarivo", "Rouge Script", "Ruda", "Ruge Boogie", "Ruluko",
			"Ruslan Display", "Russo One", "Ruthie", "Sail", "Salsa", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Schoolbell",
			"Seaweed Script", "Sevillana", "Shadows Into Light", "Shadows Into Light Two", "Shanti", "Share", "Shojumaru",
			"Short Stack", "Siemreap", "Sigmar One", "Signika", "Signika Negative", "Simonetta", "Sirin Stencil", "Six Caps",
			"Slackey", "Smokum", "Smythe", "Sniglet", "Snippet", "Sofia", "Sonsie One", "Sorts Mill Goudy", "Special Elite",
			"Spicy Rice", "Spinnaker", "Spirax", "Squada One", "Stardos Stencil", "Stint Ultra Condensed", "Stint Ultra Expanded",
			"Stoke", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Suwannaphum", "Swanky and Moo Moo", "Syncopate",
			"Tangerine", "Taprom", "Telex", "Tenor Sans", "The Girl Next Door", "Tienne", "Tinos", "Titan One", "Trade Winds",
			"Trocchi", "Trochut", "Trykker", "Tulpen One", "Ubuntu", "Ubuntu Condensed", "Ubuntu Mono", "Ultra", "Uncial Antiqua",
			"UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "Unna", "VT323", "Varela", "Varela Round", "Vast Shadow",
			"Vibur", "Vidaloka", "Viga", "Voces", "Volkhov", "Vollkorn", "Voltaire", "Waiting for the Sunrise", "Wallpoet",
			"Walter Turncoat", "Wellfleet", "Wire One", "Yanone Kaffeesatz", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada"
		);
}

/**
 * Returns a select list of Google fonts
 * Feel free to edit this, update the fallbacks, etc.
 */
function wpm_options_typography_get_google_fonts() {
	// Google Font Defaults
	$google_faces = array(
		'Arvo, serif' => 'Arvo',
		'Copse, sans-serif' => 'Copse',
		'Droid Sans, sans-serif' => 'Droid Sans',
		'Droid Serif, serif' => 'Droid Serif',
		'Lobster, cursive' => 'Lobster',
		'Nobile, sans-serif' => 'Nobile',
		'Open Sans, sans-serif' => 'Open Sans',
		'Oswald, sans-serif' => 'Oswald',
		'Pacifico, cursive' => 'Pacifico',
		'Rokkitt, serif' => 'Rokkit',
		'PT Sans, sans-serif' => 'PT Sans',
		'Quattrocento, serif' => 'Quattrocento',
		'Raleway, cursive' => 'Raleway',
		'Ubuntu, sans-serif' => 'Ubuntu',
		'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz'
	);
	return $google_faces;
}


function wpm_getFontsList($name = "", $value = "") {
        
    $fonts = wpm_getFontsTab();
    if($value == '') { $value = 'Acme'; }
    $tab_fonts = "<select name='".$name."'>";
    foreach($fonts as &$namefont) {
        $addOption = '';
        if($value == $namefont) { $addOption = 'selected'; }
        $tab_fonts .= '<option value="'.$namefont.'" '.$addOption.' style="font-family: '.$namefont.'">'.$namefont.'</option>';
    }
    $tab_fonts .= "</select>";

    return $tab_fonts;
}
/* Formatte la police sélectionnée */
function wpm_format_font($font) {
    return str_replace('+', ' ', $font);
}

function wpm_compress($buffer) {

    // Récupère les paramètres sauvegardés
	if(get_option('wp_maintenance_settings')) { extract(get_option('wp_maintenance_settings')); }
    $o = get_option('wp_maintenance_settings');
    
    $variables_css = array(
        "#_COLORTXT" => esc_html($o['color_field_text']),
		"#_COLORBG" => esc_html($o['color_field_background']),
		"#_COLORBORDER" => esc_html($o['color_field_border']),
		"#_COLORBUTTON" => esc_html($o['color_button']),
		"#_COLORTEXTBUTTON" => esc_html($o['color_text_button']),
		"#_COLOR_BTN_HOVER" => esc_html($o['color_button_hover']),
		"#_COLOR_BTN_CLICK" => esc_html($o['color_button_onclick'])
        );
    // On remplace les variables par leur valeur
    foreach($variables_css as $code_variable => $valeur) {
        $buffer = str_replace('{'.$code_variable.'}', $valeur, $buffer);
    
        // Suppression des commentaires
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    
        // Suppression des tabulations, espaces multiples, retours à la ligne, etc.
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '	 ', '	 '), '', $buffer);
    }
    // Suppression des derniers espaces inutiles
    $buffer = str_replace(array(' { ',' {','{ '), '{', $buffer);
    $buffer = str_replace(array(' } ',' }','} '), '}', $buffer);
    $buffer = str_replace(array(' : ',' :',': '), ':', $buffer);

    return $buffer;
}

/* Feuille de style par défault */
function wpm_print_style() {
    
    return '#logo {text-align: center;max-width: 100%;height: auto;text-align: center;}

a:link {color: #_COLORTXT;text-decoration: none;}
a:visited {color: #_COLORTXT;text-decoration: none;}
a:hover, a:focus, a:active {color: #_COLORTXT;text-decoration: none;}

.cptR-rec_countdown {
    position: relative;
    background: #_COLORCPTBG;
    display: inline-block;
    line-height: 100%;
    min-height: 60px;
    text-transform: uppercase;
    text-align:center;
    margin: 0.5em auto;
}
.wpm_ctp_sep {margin-top:1vw;}

header {background: #_COLORHEAD;}

#wpm-cpt-day, #wpm-cpt-hours, #wpm-cpt-minutes, #wpm-cpt-seconds {
    color: #_COLORCPT;
    display: block;
    font-size: #_DATESIZE;
    height: 40px;
    line-height: 18px;
    text-align: center;
    float:left;
    margin:0.3em;
    padding:0px;
}
#wpm-cpt-days-span, #wpm-cpt-hours-span, #wpm-cpt-minutes-span, #wpm-cpt-seconds-span {
    color: #_COLORCPT;
    font-size: 10px;
    padding: 25px 5px 0 2px;
}
.wpm_social ul, li { background:none!important; }
.wpm_horizontal li {display: inline-block;list-style: none;margin:5px;opacity:1;}
.wpm_horizontal li:hover {opacity:0.5;}

.wpm_social {padding: 0 45px;text-align: center;}
.wpm_newletter {text-align:center;}
#countdown {clear:both;margin-left:auto;margin-right:auto;text-align: center;}

    ';   
}

/* Feuille de style pour wysija */
function wpm_wysija_style() {
    
    return '
/* FORM */
.wpm_newletter {
    color: #_COLORTXT
}
.abs-req { display: none; }
.widget_wysija_cont .wysija-submit {
    margin-left: auto;
    margin-right: auto;
    background-color: #_COLORBUTTON;
    border: 1px solid #_COLORBUTTON;
    cursor:pointer;
    color:#_COLORTEXTBUTTON;
}
.widget_wysija input {
   border: 1px solid #_COLORBORDER;
   background: #_COLORBG;
   -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;
   color: #_COLORTXT;
   -webkit-box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(000,000,000,0.7) 0 0px 0px;
   -moz-box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(000,000,000,0.7) 0 0px 0px;
   box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(000,000,000,0.7) 0 0px 0px;
   padding:8px;
   margin-bottom:20px;
   width:280px;
}

.wysija-submit-field {
   border: 1px solid #_COLORBORDER;
   background: #_COLORBUTTON;
   -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;
   -webkit-box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(255,255,255,0.4) 0 1px 0;
   -moz-box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(255,255,255,0.4) 0 1px 0;
   box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(255,255,255,0.4) 0 1px 0;
   text-shadow: none;
   color: #_COLORTXT;
   font-family: helvetica, serif;
   padding: 8.5px 18px;
   font-size: 14px;
   text-decoration: none;
   vertical-align: baseline;
   cursor:pointer;
   margin-top:0 !important;
}
.wysija-submit-field:hover {
   text-shadow: #_COLORBORDER 0 1px 0;
   border: 1px solid #_COLORBORDER;
   background: #_COLOR_BTN_HOVER;
   /*color: #_COLORTXT;*/
   cursor:pointer;
}
.widget_wysija input:focus {
   text-shadow: none;
   border: 1px solid #_COLORBORDER;
   background: #_COLORBG;
   color: #_COLORTXT;
   cursor:pointer;
}
.wysija-submit-field:active {
   text-shadow: #_COLORBORDER 0 1px 0;
   border: 1px solid #_COLORBORDER;
   background: #_COLOR_BTN_CLICK;
   color: #_COLORTXT;
   cursor:pointer;
}
.widget_wysija .wysija-submit, .widget_wysija .wysija-paragraph { display: inline; }
.wysija-submit-field { margin-top:0 !important; }
   
    ';
}

/* Feuille de style pour MailChimp for WP */
function wpm_mc4wp_style() {
return '
/* FORM */
.mc4wp-form {  } /* the form element */
.mc4wp-form p {  display: inline;padding-left:0;padding-right:0; } /* form paragraphs */
.mc4wp-form label {  } /* labels */

/* input fields */
.mc4wp-form input { 
   border: 1px solid #_COLORBORDER;
   background: #_COLORBG;
   -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;
   -webkit-box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(255,255,255,0.4) 0 1px 0;
   -moz-box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(255,255,255,0.4) 0 1px 0;
   box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(255,255,255,0.4) 0 1px 0;
   text-shadow: none;
   color: #_COLORTXT;
   font-family: helvetica, serif;
   padding: 8.5px 18px;
   font-size: 14px;
   text-decoration: none;
   vertical-align: baseline;
   cursor:pointer;
   margin-top:0 !important;
} 
/* checkboxes */
.mc4wp-form input[type="checkbox"] {  

} 
/* submit button */
.mc4wp-form input[type="submit"] { 
    background-color: #_COLORBUTTON;
    border: 1px solid #_COLORBUTTON;
    cursor:pointer;
    color:#_COLORTEXTBUTTON;
} 
.mc4wp-form input[type="submit"]:hover { 
   text-shadow: #_COLORBORDER 0 1px 0;
   border: 1px solid #_COLORBORDER;
   background: #_COLOR_BTN_HOVER;
   /*color: #_COLORTXT;*/
   cursor:pointer;
} 
.mc4wp-form input[type="submit"]:active {
   text-shadow: #_COLORBORDER 0 1px 0;
   border: 1px solid #_COLORBORDER;
   background: #_COLOR_BTN_CLICK;
   color: #_COLORTXT;
   cursor:pointer;
}
.mc4wp-alert {  } /* success & error messages */
.mc4wp-success {  } /* success message */
.mc4wp-error {  background: #cc0000; } /* error messages */
';

}

function wpm_hex2rgb($color) {
    
    
	if(strlen($color) > 1)
		if($color[0] == '#')
			$color = substr($color, 1);
 
	if(strlen($color) == 6)
		list($r, $g, $b) = array(
					$color[0].$color[1],
					$color[2].$color[3],
					$color[4].$color[5]
					);
	elseif(strlen($color) == 3)
		list($r, $g, $b) = array(
					$color[0].$color[0],
					$color[1].$color[1],
					$color[2].$color[2]
					);
	else
		return false;
 
	return array(
		'rouge' => hexdec($r),
		'vert' => hexdec($g),
		'bleu' => hexdec($b)
		);
    
}

