<?php

/*
    fix for browsers
*/
function wpfme_IEhtml5_shim () {
    global $is_IE;
    if ($is_IE)
        echo '<!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->';
        echo '<!--[if (gte IE 6)&(lte IE 8)]><script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script><![endif]-->';
}
add_action('wp_head', 'wpfme_IEhtml5_shim');

/* Add custom style.css to login page */
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/src/css/login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

/*
    Hide WordPress Update Nag to All But Admins
*/
function hide_update_notice_to_all_but_admin() {
    if ( !current_user_can( 'update_core' ) ) {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}
add_action( 'admin_head', 'hide_update_notice_to_all_but_admin', 1 );


/*
    Cleaner Dashboard
*/
function disable_default_dashboard_widgets() {
	remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	//remove_meta_box('dashboard_right_now', 'dashboard', 'core');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');


/*
    Remove wp tag in header *
*/
remove_action('wp_head', 'wp_generator');


function remove_menus() {
	//remove_menu_page( 'upload.php' );
	//remove_menu_page( 'themes.php' );
	remove_menu_page( 'links.php' );
	//remove_menu_page( 'tools.php' );
	//remove_menu_page( 'plugins.php' );
}
add_action( 'admin_menu', 'remove_menus' );


/*
    Custom Excerpt
*/
class Excerpt {
    public static $length = 55;// Default length (by WordPress)
    public static $types = array(// So you can call: my_excerpt('short');
        'short' => 25,
        'regular' => 55,
        'long' => 100
    );
    public static function length($new_length = 55) {
        Excerpt::$length = $new_length;
        add_filter('excerpt_length', 'Excerpt::new_length');
        Excerpt::output();
    }
    public static function new_length() {
        if( isset(Excerpt::$types[Excerpt::$length]))
            return Excerpt::$types[Excerpt::$length];
        else
            return Excerpt::$length;
    }
    public static function output(){
        the_excerpt();
    }
}

function my_excerpt($length = 55) {
    Excerpt::length($length);
}


// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['_views'] = 'Vistas';
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
  if($column_name === 'views'){
    echo getPostViews(get_the_ID());
  }
}


/*
    Pagination Boostrap
*/

function wp_bootstrap_pagination( $args = array() ) {
    $defaults = array(
        'range'           => 4,
        'custom_query'    => FALSE,
        'previous_string' => 'Anterior',
        'next_string'     => 'Siguiente',
        'before_output'   => '<nav aria-label="Paginacion"><ul class="pagination">',
        'after_output'    => '</ul></nav>'
    );

    $args = wp_parse_args(
        $args,
        apply_filters( 'wp_bootstrap_pagination_defaults', $defaults)
    );

    $args['range'] = (int) $args['range'] - 1;
    if (!$args['custom_query'])
        $args['custom_query'] = @$GLOBALS['wp_query'];
    $count = (int) $args['custom_query']->max_num_pages;
    $page  = intval( get_query_var( 'paged' ) );
    $ceil  = ceil( $args['range']/2);

    if ( $count <= 1 )
        return FALSE;

    if ( !$page )
        $page = 1;

    if ( $count > $args['range'] ) {
        if ( $page <= $args['range'] ) {
            $min = 1;
            $max = $args['range'] + 1;
        } elseif ( $page >= ($count - $ceil) ) {
            $min = $count - $args['range'];
            $max = $count;
        } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
            $min = $page - $ceil;
            $max = $page + $ceil;
        }
    } else {
        $min = 1;
        $max = $count;
    }

    $echo = '';
    $previous = intval($page) - 1;
    $previous = esc_attr( get_pagenum_link($previous) );

    $firstpage = esc_attr( get_pagenum_link(1) );
    if ( $firstpage && (1 != $page) )
        $echo .= '<li class="page-item"><a class="page-link" href="' . $firstpage . '">' . __( 'Primera', 'text-domain' ) . '</a></li>';
    if ( $previous && (1 != $page) )
        $echo .= '<li class="page-item"><a class="page-link" href="' . $previous . '" title="' . __( 'Anterior', 'text-domain') . '"><span aria-hidden="true">&laquo;</span><span class="sr-only">Anterior</span></a></li>';

    if ( !empty($min) && !empty($max) ) {
        for( $i = $min; $i <= $max; $i++ ) {
            if ($page == $i) {
                $echo .= '<li class="page-item active"><a class="page-link" href="#">' . str_pad( (int)$i, 2, '0', STR_PAD_LEFT ) . '</a></li>';
            } else {
                $echo .= sprintf( '<li class="page-item"><a class="page-link" href="%s">%002d</a></li>', esc_attr( get_pagenum_link($i) ), $i );
            }
        }
    }

    $next = intval($page) + 1;
    $next = esc_attr( get_pagenum_link($next) );
    if ($next && ($count != $page) )
        $echo .= '<li class="page-item"><a class="page-link" href="' . $next . '" title="' . __( 'Siguiente', 'text-domain') . '"><span aria-hidden="true">&raquo;</span><span class="sr-only">Siguiente</span></a></li>';

    $lastpage = esc_attr( get_pagenum_link($count) );
    if ( $lastpage ) {
        $echo .= '<li class="page-item next"><a class="page-link" href="' . $lastpage . '">' . __( 'Última', 'text-domain' ) . '</a></li>';
    }
    if ( isset($echo) )
        echo $args['before_output'] . $echo . $args['after_output'];
}



/*
    Remove pages from searc
*/
function remove_pages_from_search() {
    global $wp_post_types;
    $wp_post_types['page']->exclude_from_search = true;
}
add_action('init', 'remove_pages_from_search');


/*
    Force medium size image to crop
*/
if(false === get_option('medium_crop')) {
    add_option('medium_crop', '1');
} else {
    update_option('medium_crop', '1');
}


/*
    Funtion to call images in a post
*/
function my_image($postid=0, $size='thumbnail') { //it can be thumbnail or full
    if ($postid<1){
        $postid = get_the_ID();
    }
    if(has_post_thumbnail($postid)){
        $imgpost = get_the_post_thumbnail_url($postid, $size);
		return $imgpost;

    }
    elseif ($images = get_children(array(
        'post_parent' => $postid,
        'post_type' => 'attachment',
        'numberposts' => '1',
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'post_mime_type' => 'image',))){

    	foreach($images as $image) {
        	$thumbnail = wp_get_attachment_image_src($image->ID, $size);
        	return $thumbnail[0];
    	}
   	} else {
        global $post, $posts;
        $first_img = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

        if(!empty($matches[1][0]))
        	$first_img = $matches [1] [0];
        return $first_img;
    }
}


/*
    Add images in feed rss
*/
function rss_add_enclosure() {
    global $post;
    if( has_post_thumbnail() ) {
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
        $url = $thumb['0'];
        echo "\n";
    }
}
add_action('rss_item',  'rss_add_enclosure');
add_action('rss2_item', 'rss_add_enclosure');


/*
    Remove wordpress in mail subject
*/
function res_fromname($email){
    $wpfrom = get_option('blogname');
    return $wpfrom;
}
add_filter('wp_mail_from_name', 'res_fromname');

function use_noresponder(){
  return 'noreply@growl.ink';
}
add_filter( 'wp_mail_from', 'use_noresponder' );



/*
    remove wordpress logo and menu admin bar
*/
function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );


/*
    Redirect admins to the dashboard and other users elsewhere
*/
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
function my_login_redirect( $redirect_to, $request, $user ) {
    // Is there a user?
    if (isset($user->roles) && is_array( $user->roles ) ) {
        // Is it an administrator?
        if ( in_array( 'administrator', $user->roles ) )
            return home_url( '/wp-admin/' );
        else
            return home_url();
    }
}

// Disable use XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// Disable X-Pingback to header
add_filter( 'wp_headers', 'disable_x_pingback' );
function disable_x_pingback( $headers ) {
    unset( $headers['X-Pingback'] );
return $headers;
}

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'start_post_rel_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'adjacent_posts_rel_link' );


/**
 * Disable Emoji Mess
 */

function disable_wp_emojicons() {
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
    add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
    return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
}


/**
 * Disable JSON Rest API
 */

add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');

/**
 * PHP Logger
 */

function php_log( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);
    // print the result into the JavaScript console
    echo "<script>console.log( 'PHP LOG: " . $output . "' );</script>";
}

/*
    Get content via cUrl
*/

function url_get_contents ($Url) {
    if (!function_exists('curl_init')){
        die();
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

/*
    Verify reCaptcha
*/

function verifyCaptcha($secret,$response){
    //Habilitado para SSL
    $data = array(
        'secret' => $secret,
        'response' => $response
    );

    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);

    $captcha_success=json_decode($response);

    if ($captcha_success->success==true) {
        return true;
    } else {
        return false;
    }
}

//Agregar imagenes a los posteos
function insert_attachment($file_handler,$post_id,$setthumb='false') {
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	$attach_id = media_handle_upload( $file_handler, $post_id );

	if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
	return $attach_id;
}

