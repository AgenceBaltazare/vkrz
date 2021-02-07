<?php
/**
 *
 * functions.php
 * Fichier de modification du comportement du WordPress
 *
 * Appel des fonctions selon l'utilisation : ajax, admin, front ou all
 * Inclure les fonctions à utiliser sur le projet dans le fichier correspondant function/
 * Inclure la fonction dans un fichier à son nom function/front/ ou function/admin/ ou function/ajax/
 *
 * Les fonctions récurentes sur les projets sont déjà dans les répertoires associés,
 * il faut décommenter leur appel dans le fichier associé dans function/
 *
 */
$templatepath = get_template_directory();

if ( defined( 'DOING_AJAX' ) && DOING_AJAX && is_admin() ) {

	include( $templatepath . '/function/ajax.php' );

} elseif ( is_admin() ) {

	include( $templatepath . '/function/admin.php' );

} elseif ( ! defined( 'XMLRPC_REQUEST' ) && ! defined( 'DOING_CRON' ) ) {

	include( $templatepath . '/function/front.php' );

}
include( $templatepath . '/function/all.php' );
include( $templatepath . '/function/meca.php' );

?>
