<?php
/*
*
*
* Custom avatar
*
*
*/
function get_avatarimg_url($get_avatar){
    preg_match('#src=["|\'](.+)["|\']#Uuis', $get_avatar, $matches);
    return $matches[1];
}

function custom_query_vars_filter($vars) {
  $vars[] .= '_emailvalidation';
  $vars[] .= 'user';
  $vars[] .= 'action';
  return $vars;
}
add_filter( 'query_vars', 'custom_query_vars_filter' );

add_filter('get_avatar_url', 'set_https', 10, 3);
function set_https($url, $id_or_email, $args){
    return set_url_scheme( $url, 'https' );;
}

function custom_avatars($avatar, $id_or_email, $size){
    $image_url = get_user_meta($id_or_email, 'user_avatar', true);
    if($image_url !== '' && is_int($id_or_email))
        $return = '<img src="'.$image_url.'" class="avatar-img" width="'.$size.'" height="'.$size.'"/>';
    elseif($avatar)
        $return = $avatar;
    return $return;
}
add_filter('get_avatar', 'custom_avatars', 10, 5);

function getparams($g){
    if(isset($_GET[$g])){
        return $_GET[$g];
    } else {
        return '';
    }
}

function htmlButton($l,$t){
    $button = '<div><!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="'.$l.'" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="15%" stroke="f" fillcolor="#4137CF"><w:anchorlock/><center><![endif]--><a href="'.$l.'" style="background-color:#4137CF;border-radius:6px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;">'.$t.'</a><!--[if mso]></center></v:roundrect><![endif]--></div>';
    return $button;
}

/**
 * Add a general nonce to requests
 */
function add_general_nonce(){
    $nonce = wp_create_nonce( 'noncefield' );
    echo "<meta name='csrf-token' content='$nonce'>";
}
// To add to front-end pages
add_action( 'wp_head', 'add_general_nonce' );


/**
 * Verify the submitted nonce
 */
function verify_general_nonce(){
    $nonce = isset($_SERVER['HTTP_X_CSRF_TOKEN']) ? $_SERVER['HTTP_X_CSRF_TOKEN']: '';
    if (!wp_verify_nonce( $nonce, 'noncefield')) {
        die();
    }
}


function validateuserEmail(){
    if(isset($_GET['_emailvalidation']) && isset($_GET['user']) && $_GET['user'] != ''){
        $user = get_userdata($_GET['user']);
        if($user){
            $keydb = get_user_meta($_GET['user'], '_data_user_key', true );
            if($keydb == $_GET['_emailvalidation']){
                update_user_meta($_GET['user'],'_data_user_key','');
                wp_redirect(home_url('/login'));
            }
        }
    }
}
add_action('init','validateuserEmail');

function checklogin($where = ''){
	if (!is_user_logged_in()) {
  		wp_redirect(home_url() . $where);
	}
}

function getBio($id,$what = 'guid'){
	// get his posts 'ASC'
	$pageurl = get_posts(array('author'=>$id));
    if($what == 'guid'){
        if(isset($pageurl[0]->guid))
            return $pageurl[0]->guid;
        else
            return null;
    } elseif($what == 'id'){
        if(isset($pageurl[0]->ID))
            return $pageurl[0]->ID;
        else
            return null;
    }
}

function cookieCreator($user,$bio){

    if(!isset($_COOKIE['_growlink_creator']))
        setcookie('_growlink_creator', $user, time() + 3600 * 24 * 30, COOKIEPATH, COOKIE_DOMAIN, false);
    if(!isset($_COOKIE['_growlink_creator_bio']))
        setcookie('_growlink_creator_bio', $bio, time() + 3600 * 24 * 30, COOKIEPATH, COOKIE_DOMAIN, false);
}

function cleanOnlyElements($a){
    unset($a['_edit_lock']);
    unset($a['_wp_old_slug']);
    unset($a['design_data']);
    unset($a['option_data']);
    return $a;
}

function createOption($v,$s = ''){
    if(is_array($v)){
        foreach ($v as $k => $value) {
            $selected = ($s == $k) ? ' Selected' : '';
            echo "<option value='$k' $selected>" . $value."</option>";
        }
    }
}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (is_array($array) && count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }
        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }
        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }
    return $new_array;
}

function reorderLinksPosition($data){
    $newarray = array();
    foreach ($data as $a => $b) {
        $z = maybe_unserialize($b[0]);
        $z['element'] = $a;
        $newarray[] = $z;
    }
    return array_sort($newarray, 'position', SORT_ASC);
}


function actionBtn($type,$star = ''){
    $starred = ($star == 'on') ? 'starred' : '';
    echo "<div class='text-right'><a href='' class='icon-link' data-action='deleteElement'><i class='bx bx-trash'></i></a>";
    if($type !== 'section'){
        //echo "<a href='' class='icon-link $starred' data-action='stickyElement' data-starred='$starred'><i class='bx bx-star'></i></a>";
        echo "<a href='' class='viewStatLink icon-link'><i class='bx bx-stats'></i></a>";
    }
    echo "</div>";
}

function loadStyleUser(){

    if(is_single()){
        global $post;
        $databio = maybe_unserialize(get_post_meta($post->ID, 'design_data',true));
        $style = '';
        if($databio['site-hero'] == 'color'){
            $style = 'background-color: '.$databio['site-herodata'] . '!important;';
        } elseif($databio['site-hero'] == 'image'){
            $style = 'background-image: url("'.$databio['site-herodata'] . '")';
        }
        echo '<link href="https://fonts.googleapis.com/css?family='.urlencode($databio['site-font']).':300,400,700&display=swap" rel="stylesheet">';
        echo '
        <style>
            #profile-page-user{
                background-color: '.$databio['site-bgcolor'].';
                font-family: "'.$databio['site-font'].'",Helvetica Neue,Helvetica,sans-serif;
                color: '.$databio['site-color-text'].' !important;
            }
            #profile-page-user .cover{'.$style.'}
            #profile-page-user .card-title{
                color: '.$databio['site-color-link'].' !important;
            }
            #profile-page-user .name,#profile-user-page .smallbio.lead,#profile-page-user .card-text{
                color: '.$databio['site-color-text'].' !important;
            }
            .site-border{border-radius: '.$databio['site-roundedcorners'].'px !important}
        </style>';
    }
}

add_action('wp_head', 'loadStyleUser');


function getUserCookie() {
  if(isset($_COOKIE['linkvisited'])) {
    // cookie is already set
  } else {
    list($usec, $sec) = explode(" ", microtime()); // Micro time!
    $expire = time()+60*60*24*30; // expiration after 30 day
    setcookie("linkvisited", "".md5("".$sec.".".$usec."")."", $expire, "/", "", "0");
  }
  return (isset($_COOKIE['linkvisited'])) ? $_COOKIE['linkvisited'] : NULL;
}

function viewstatlink($idelement){
    $idelement = 'element-' . $idelement;
    global $wpdb;
    $today = date('Y-m-d h:i:s');
    $old = strtotime("-20 day", strtotime($today));
    $old = date('Y-m-d h:i:s',$old);
    $query = $wpdb->prepare("SELECT * FROM wp_linkstats WHERE element = %s AND date BETWEEN %s AND %s ORDER BY date",$idelement,$old,$today);
    $elementstats = $wpdb->get_results($query,'ARRAY_A');
    $dates = array();
    foreach ($elementstats as $a => $value) {
        $datef = date('d/m',strtotime($value['date']));
        $dates[$datef] = (isset($dates[$datef])) ? $dates[$datef]+1 : 1;
    }
    return $dates;
}


function _getCountryMap($i){
    if(!empty($i)){
        foreach ($i as $key => $item) {
            $arr[$item['country']][$key] = $item;
        }

        foreach ($arr as $key => $country) {
            $c[] = array($key,count($country));
        }

        usort($c, function($a, $b) {
            return $b[1] - $a[1];
        });

        return $c;
    } else {
        return "";
    }
}

function _getClicksStats($i){
    if(!empty($i)){
        foreach ($i as $key => $item) {
            $datef = date("Y-m-d", strtotime($item['date']));
            $arr[$datef][$key] = $item;
        }

        foreach ($arr as $key => $x) {
            $c[] = array($key,count($x));
        }

        usort($c, function($a, $b) {
            return $b[1] - $a[1];
        });

        return $c;
    } else {
        return "";
    }
}


function _getReferal($i){
    if(!empty($i)){
        foreach ($i as $key => $item) {
            $arr[$item['referer']][$key] = $item;
        }

        foreach ($arr as $key => $ref) {
            $c[] = array($key,count($ref));
        }

        usort($c, function($a, $b) {
            return $b[1] - $a[1];
        });

        return $c;
    } else {
        return "";
    }
}

function _getDestinations($i){
    if(!empty($i)){
        foreach ($i as $key => $item) {
            $arr[$item['url']][$key] = $item;
        }

        foreach ($arr as $key => $ref) {
            $c[] = array($key,count($ref));
        }

        usort($c, function($a, $b) {
            return $b[1] - $a[1];
        });

        return $c;
    } else {
        return "";
    }
}

function getStatsBio($idbio,$t = 'today'){
    global $wpdb;
    $to = date('Y-m-d h:i:s');
    switch ($t) {
        case 'today':
            $date = '-1';
            break;
        case 'week':
            $date = '-7';
            break;
        case 'month':
            $date = '-30';
            break;
        case 'sixmonth':
            $date = '-182';
            break;
        case 'year':
            $date = '-365';
            break;
        default:
            $date = '-1';
            break;
    }
    $f = strtotime($date . " day", strtotime($to));
    $from = date('Y-m-d h:i:s',$f);
    $query = $wpdb->prepare("SELECT * FROM wp_landingstats WHERE landing = %s AND date BETWEEN %s AND %s ORDER BY date",$idbio,$from,$to);
    $elementstats = $wpdb->get_results($query,'ARRAY_A');
    return $elementstats;
}

function getClicksBio($idbio,$t = 'today'){
    global $wpdb;
    $to = date('Y-m-d h:i:s');
    switch ($t) {
        case 'today':
            $date = '-1';
            break;
        case 'week':
            $date = '-7';
            break;
        case 'month':
            $date = '-30';
            break;
        case 'sixmonth':
            $date = '-182';
            break;
        case 'year':
            $date = '-365';
            break;
        default:
            $date = '-1';
            break;
    }
    $from = strtotime($date." day", strtotime($to));
    $from = date('Y-m-d h:i:s',$from);
    $query = $wpdb->prepare("SELECT * FROM wp_linkstats WHERE bio = %s AND date BETWEEN %s AND %s ORDER BY date",$idbio,$from,$to);
    $elementstats = $wpdb->get_results($query,'ARRAY_A');
    return $elementstats;
}

function getPercent($number, $percent){
    return ($percent / 100) * $number;
}

function transformSocialUrl($type,$data){
    if($type == 'facebook')
        return 'https://facebook.com/' . $data;
    else if ($type == 'twitter')
        return 'https://twitter.com/' . $data;
    else if ($type == 'instagram')
        return 'https://instagram.com/' . $data;
    else if ($type == 'spotify')
        return 'https://open.spotify.com/user/' . $data;
    else if ($type == 'whatsapp')
        return 'https://wa.me/' . $data;
    else if ($type == 'twitch')
        return 'https://www.twitch.tv/' . $data;
    else if ($type == 'vk')
        return 'https://vk.com/' . $data;
    else if ($type == 'youtube')
        return 'https://www.youtube.com/channel/' . $data;
    else if ($type == 'snapchat')
        return 'https://www.snapchat.com/add/' . $data;
    else if ($type == 'telegram')
        return 'https://t.me/' . $data;
}


/*
* Mailchimp connect
*/
function mailchimp_curl_connect( $url, $request_type, $api_key, $data = array() ) {
	if( $request_type == 'GET' )
		$url .= '?' . http_build_query($data);

	$mch = curl_init();
	$headers = array(
		'Content-Type: application/json',
		'Authorization: Basic '.base64_encode( 'user:'. $api_key )
	);
	curl_setopt($mch, CURLOPT_URL, $url );
	curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
	//curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); // do not echo the result, write it into variable
	curl_setopt($mch, CURLOPT_CUSTOMREQUEST, $request_type); // according to MailChimp API: POST/GET/PATCH/PUT/DELETE
	curl_setopt($mch, CURLOPT_TIMEOUT, 10);
	curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); // certificate verification for TLS/SSL connection

	if( $request_type != 'GET' ) {
		curl_setopt($mch, CURLOPT_POST, true);
		curl_setopt($mch, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
	}

	return curl_exec($mch);
}

function mailchimp_subscribe_unsubscribe($apikey,$listid,$email, $status, $merge_fields = array( 'FNAME' => '', 'LNAME' => '' ) ){
	/* MailChimp API URL */
	$url = 'https://' . substr($apikey,strpos($apikey,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $listid . '/members/' . md5(strtolower($email));
	/* MailChimp POST data */
	$data = array(
		'apikey'        => $apikey,
    		'email_address' => $email,
		'status'        => $status, // in this post we will use only 'subscribed' and 'unsubscribed'
		'merge_fields'  => $merge_fields // in this post we will use only FNAME and LNAME
	);
	return json_decode(mailchimp_curl_connect( $url, 'PUT', $apikey, $data ) );
}

function connectIG($user){
    $u = get_user_meta($user, 'ig_connect', true);
    if(is_array($u) && $u['username']){
        return $u['username'];
    } else {
        return false;
    }
}


//Fuunction to print GA code in header bio page
function GaCode($code){?>
    <script>
        (function(e,t,n,i,s,a,c){e[n]=e[n]||function(){(e[n].q=e[n].q||[]).push(arguments)}
        ;a=t.createElement(i);c=t.getElementsByTagName(i)[0];a.async=true;a.src=s
        ;c.parentNode.insertBefore(a,c)
        })(window,document,"galite","script","https://cdn.jsdelivr.net/npm/ga-lite@2/dist/ga-lite.min.js");

        galite('create', '<?php echo $code;?>', 'auto');
        galite('send', 'pageview');
    </script>
<?php }

//Fuunction to print Facebook Code Pixel in header bio page
function FbCode($code){?>
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo $code;?>');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $code;?>&ev=PageView&noscript=1"/></noscript>
    <!-- End Facebook Pixel Code -->
<?php }

function faviconCode($code){?>
<link href="https://cdn.filestackcontent.com/<?php echo $code;?>" rel="icon" media="all"/>
<link rel="shortcut icon" sizes="196x196" href="https://cdn.filestackcontent.com/<?php echo $code;?>"/>
<link rel="apple-touch-icon" href="https://cdn.filestackcontent.com/<?php echo $code;?>"/>
<?php }


?>