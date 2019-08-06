<?php

/*
Site config
*/

//Variables globales
$GLOBALS['SITENAME'] = 'GROWLINK TEAM';
$GLOBALS['DOMAIN'] = 'growl.ink';
$GLOBALS['ADMINEMAIL'] = get_option('admin_email');


define('_INSTAGRAM_CLIENT_ID',growlink_getoption('ig_client_id',''));
define('_INSTAGRAM_CLIENT_SECRET',growlink_getoption('ig_client_secret',''));

define('_INSTAGRAM_REDIRECT_URL',get_bloginfo('url') . '/dashboard/my-account/');

add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
    wp_deregister_script('heartbeat');
}

add_filter( 'locale', 'set_my_locale' );
function set_my_locale( $lang ) {
    if (isset($_GET['lang'])) {
        switch ($_GET['lang']) {
            case 'es':
                return 'es_ES';
                break;
            case 'fr':
                return 'fr_FR';
                break;
            case 'pt':
                return 'pt_BR';
                break;
            default:
                break;
        }
    } else {
    // return original language
    return $lang;
  }
}

if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
    error_reporting(E_ALL); ini_set('display_errors', 1);
    ini_set( 'error_log', get_template_directory_uri() . '/log.txt' );
}

$GLOBALS['FONTS'] = "Barlow,Fira Sans,Source Sans Pro,Muli,Merriweather,Poppins,Playfair Display,Lora,Rubik,Noto Serif,Work Sans,Josefin Sans,Abel";


/*
    Define Logged User Data
*/
global $theuser;
$theuser = wp_get_current_user();

function add_scripts(){
    //Add CSS
    wp_enqueue_style('fontawesome', get_template_directory_uri() . "/src/vendor/font-awesome/css/fontawesome-all.min.css");
    wp_enqueue_style('bootstrap', get_template_directory_uri() . "/src/vendor/bootstrap/css/bootstrap.min.css");
    wp_enqueue_style('bootstrap-select', get_template_directory_uri() . "/src/vendor/bootstrap-select/dist/css/bootstrap-select.min.css");
    wp_enqueue_style('animate', get_template_directory_uri() . "/src/vendor/animate/animate.min.css");
    wp_enqueue_style('boxicons', get_template_directory_uri() . "/src/vendor/boxicons/css/boxicons.min.css");
    wp_enqueue_style('chartist', "https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.1/chartist.min.css");

    //Add jQuery
    if (!is_admin()){
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri() . '/src/vendor/jquery/jquery.min.js');
        wp_enqueue_script('jquery');
    }

    wp_enqueue_script('validator-js', get_template_directory_uri() . "/src/vendor/validator/validator.js");
    wp_enqueue_script('popper-js', get_template_directory_uri() . "/src/vendor/popper/popper.min.js");
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . "/src/vendor/bootstrap/js/bootstrap.min.js");
    wp_enqueue_script('bootstrap-select-js', get_template_directory_uri() . "/src/vendor/bootstrap-select/dist/js/bootstrap-select.min.js");

    wp_enqueue_script('mainplugins-js', get_template_directory_uri() . "/src/js/mainplugins.js");
    wp_enqueue_script('chartist-js', "https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.1/chartist.min.js");


    //Conditional Style front and Dashboard
    $pagetemplate = get_page_template_slug();

    $userid = '';
    if(is_user_logged_in()){
        global $theuser;
        $userid = $theuser->ID;
    }

    wp_register_script('main-js', get_template_directory_uri() . "/src/js/main.js");

    wp_enqueue_script('main-js');
     $paramsLogin = array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    );
    wp_localize_script('main-js','jsvar',$paramsLogin);


    if(is_string($pagetemplate) && strpos($pagetemplate,'statistics')){
        wp_enqueue_script('gchart-js', "https://www.gstatic.com/charts/loader.js");
        wp_enqueue_style('flag', get_template_directory_uri() . "/src/vendor/flags/css/flag-icon.min.css");
    }

    if(is_string($pagetemplate) && strpos($pagetemplate,'dashboard') !== false){
        wp_enqueue_script('filestack-js', 'http://static.filestackapi.com/filestack-js/1.x.x/filestack.min.js');

        wp_register_script('app-js', get_template_directory_uri() . "/src/js/app.js");


        wp_enqueue_script('app-js');
        $params = array(
            'ajaxurl' => admin_url('admin-ajax.php?language=es'),
            'filestackapikey' => 'AF24wlSpnTbeSAVFqVXATz',
            'userid' => $userid,
            'gfontapikey' => 'AIzaSyBk9_R4ckTs4zMwylGoux3KY3apsnmKkbY',
        );
        wp_localize_script('app-js','jsvar',$params);
    } else {
        wp_enqueue_style('front', get_template_directory_uri() . "/src/css/front.css?" . rand(0,100));
        wp_enqueue_script('slick-js', get_template_directory_uri() . "/src/vendor/slick/slick.js");
        wp_enqueue_script('front-js', get_template_directory_uri() . "/src/js/front.js");

    }

    wp_enqueue_style('app', get_template_directory_uri() . "/src/css/app.css?" . rand(0,100));
}

add_action( 'wp_enqueue_scripts', 'add_scripts' );

add_action('init', 'my_init');
function my_init() {
    do_action('sublanguage_prepare_ajax');
}

add_action( 'after_setup_theme', 'my_theme_setup' );
function my_theme_setup(){
    load_theme_textdomain( 'growlink', get_template_directory() . '/languages' );
}

/*
    Add post thumbnail
*/
add_theme_support('post-thumbnails', array('post','page'));

/*
    Custom nav menu
*/
function register_my_menus() {
    register_nav_menus(
        array(
            'menu' => 'Main menu',
        )
    );
}
add_theme_support( 'menus' );
add_action( 'init', 'register_my_menus' );


/*
	Disable Admin Bar
*/
function disable_admin_bar() {
    // if ( ! current_user_can('delete_users') ) {
    //     add_filter('show_admin_bar', '__return_false');
    // }
    add_filter('show_admin_bar', '__return_false');
}
add_action( 'after_setup_theme', 'disable_admin_bar' );

/**
 * Redirect back to homepage and not allow access to
 * WP admin for Subscribers.
 */
function redirect_admin(){
    if ( ! defined('DOING_AJAX') && ! current_user_can('delete_users') ) {
        wp_redirect( site_url() );
        exit;
    }
}
add_action( 'admin_init', 'redirect_admin' );


/*
	Function to facility emails notifications in WP
*/
function sendNotification($subject,$content,$email){
	$thebody = '<!doctype html><html><head><meta name="viewport" content="width=device-width"> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <title>{{subject}}</title> <style media="all" type="text/css"> @media all{.btn-primary table td:hover{background-color: #34495e !important;}.btn-primary a:hover{background-color: #34495e !important; border-color: #34495e !important;}}@media all{.btn-secondary a:hover{border-color: #34495e !important; color: #34495e !important;}}@media only screen and (max-width: 620px){table[class=body] h1{font-size: 28px !important; margin-bottom: 10px !important;}table[class=body] h2{font-size: 22px !important; margin-bottom: 10px !important;}table[class=body] h3{font-size: 16px !important; margin-bottom: 10px !important;}table[class=body] p, table[class=body] ul, table[class=body] ol, table[class=body] td, table[class=body] span, table[class=body] a{font-size: 16px !important;}table[class=body] .wrapper, table[class=body] .article{padding: 10px !important;}table[class=body] .content{padding: 0 !important;}table[class=body] .container{padding: 0 !important; width: 100% !important;}table[class=body] .header{margin-bottom: 10px !important;}table[class=body] .main{border-left-width: 0 !important; border-radius: 0 !important; border-right-width: 0 !important;}table[class=body] .btn table{width: 100% !important;}table[class=body] .btn a{width: 100% !important;}table[class=body] .img-responsive{height: auto !important; max-width: 100% !important; width: auto !important;}table[class=body] .alert td{border-radius: 0 !important; padding: 10px !important;}table[class=body] .span-2, table[class=body] .span-3{max-width: none !important; width: 100% !important;}table[class=body] .receipt{width: 100% !important;}}@media all{.ExternalClass{width: 100%;}.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height: 100%;}.apple-link a{color: inherit !important; font-family: inherit !important; font-size: inherit !important; font-weight: inherit !important; line-height: inherit !important; text-decoration: none !important;}}</style> </head> <body class="" style="font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f6f6f6; margin: 0; padding: 0;"> <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;" width="100%" bgcolor="#f6f6f6"> <tr> <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td><td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto !important; max-width: 580px; padding: 10px; width: 580px;" width="580" valign="top"> <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;"> <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;"></span> <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #fff; border-radius: 3px;" width="100%"> <tr> <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top"> <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%"> <tr> <td style="font-family: sans-serif; font-size: 15px; vertical-align: top;" valign="top"> <span style="letter-spacing:4px;font-weight:700;color:#999999"><img width="150px" src="'.get_bloginfo('template_url').'/src/images/growlink-logo.png" alt="GROWLINK"></span> </td></tr><tr> <td height="30"></td></tr><tr> <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">{{content}}<br></td></tr></table> </td></tr></table> <div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;"> <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%"> </table> </div></div></td><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td></tr></table> </body></html>';

    $tpl = str_replace('{{content}}', $content, $thebody);
    $tpl = str_replace('{{subject}}', $subject, $tpl);
    $tpl = str_replace('{{site}}', $GLOBALS['SITENAME'], $tpl);

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: '.$GLOBALS['SITENAME'].' <noreply@'.$GLOBALS['DOMAIN'].'>' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $sent = wp_mail($email, $subject, $tpl, $headers);
    if($sent){
    	return $sent;
    } else {
    	return false;
    }
}

function after_body() {
    global $message;
    if(isset($message)){?>
        <div class="alert alertbox rounded alert-<?php echo $message[0];?> alert-dismissable fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $message[1];?>
        </div>

        <?php if(isset($message[2]) && $message[2] != ''){?>
            <script type="text/javascript">
               $(document).ready(function() {
                  setTimeout("window.location.href = '<?php echo $message[2];?>'",3000);
               });
            </script>
        <?php }
    }

    echo '<div class="globalcover"><div class="globalcover-pad"></div><svg version="1.1" id="loader" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="60px" height="60px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"> <path opacity="1" fill="#5320FF" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/> <path fill="#fff" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"> <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"/></path> </svg> </div>';
}
add_action('after_body_open_tag', 'after_body');

if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
    ini_set( 'error_log', WP_CONTENT_DIR . '/themes/sociallink/log.txt' );
}

/*
Footer js
*/
add_action('wp_footer', 'ga');
function ga() { ?>
<?php }
?>