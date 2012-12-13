<?php
/*
 *  Setup top and main navigation menu
 */
add_action( 'init', 'register_my_menu' );
function register_my_menu() {
	register_nav_menu( 'top-menu', __( 'Top Menu' ) );
	register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
}
?>