<?php

include_once(get_stylesheet_directory() . '/inc/core.php');

//Instagram class api connect
include_once(get_stylesheet_directory() . '/inc/libs/insta_class.php');

/*  Get the bootstrap! */
if ( file_exists(  __DIR__ . '/inc/cmb2/init.php' ) ) {
	require_once  __DIR__ . '/inc/cmb2/init.php';
}
include_once(get_stylesheet_directory() . '/inc/custom.php');

include_once(get_stylesheet_directory() . '/inc/navwalker.php');
include_once(get_stylesheet_directory() . '/inc/app.php');
include_once(get_stylesheet_directory() . '/inc/stats.php');
include_once(get_stylesheet_directory() . '/inc/extras.php');


include_once(get_stylesheet_directory() . '/inc/requests.php');
include_once(get_stylesheet_directory() . '/inc/ajax.php');

?>