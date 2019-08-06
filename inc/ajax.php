<?php


function sendPublicform(){
	//SIGNUP
	if($_POST['typeform'] == 'form_signup'){
		verify_general_nonce();

		$email = sanitize_email($_POST['email']);
		$username = sanitize_user($_POST['username']);
		$pass = $_POST['pass'];
		$hash = wp_hash_password($pass);
		if(is_email($email))
			new WP_Error( 'error', __('Invalid email','growlink'));
		$user_id = wp_create_user($username, $hash, $email);

		if (!is_wp_error( $user_id )) {
			$user = new WP_User($user_id);
			$user->set_role('author');
			wp_update_user( array ('ID' => $user->ID,'display_name' => $username,'user_nicename' => sanitize_text_field($username)));
			wp_set_password($pass,$user->ID);
			wp_clear_auth_cookie();

			//Create referral if was reffered by an affiliate
			$referral_id   = 0;
			$referral_args = array();

			if( affiliate_wp()->tracking->was_referred() ) {
				$affiliate_id = affiliate_wp()->tracking->get_affiliate_id();
				$referral_args = array(
					'description'  => $username,
					'amount'       => affiliate_wp()->settings->get('opt_in_referral_amount', 0.00 ),
					'affiliate_id' => $affiliate_id,
					'type'         => 'opt-in',
					'visit_id'     => affiliate_wp()->tracking->get_visit_id(),
					'reference'    => $email,
					'status'       => affiliate_wp()->settings->get( 'opt_in_referral_status', 'pending' ),
					'customer'     => array(
						'first_name'   => $username,
						'last_name'    => '',
						'email'        => $email,
						'ip'           => affiliate_wp()->tracking->get_ip(),
						'affiliate_id' => $affiliate_id
					),
				);

				$referral_id = affiliate_wp()->referrals->add( $referral_args );

				if( 'unpaid' == $referral_args['status'] || 'paid' == $referral_args['status'] ) {
					affiliate_wp()->visits->update( affiliate_wp()->tracking->get_visit_id(), array( 'referral_id' => $referral_id ), '', 'visit' );
				}
			}

			//generate key for validation
			$link = md5(uniqid());
			update_user_meta($user->ID,'_data_user_key',$link);

			//Send notification email
			$subject = __( 'Please confirm your account', 'growlink' );
			$link = get_bloginfo('url') ."/login?_emailvalidation=" . $link . "&user=" . $user->ID;
			$button = htmlButton($link,__('Confirm email','growlink'));
			$content = "<h2>" . __( 'Hi!', 'growlink' ) . " " . $username ."!</h2><p>" . __( 'Welcome to our platform. To validate your account click on the following link', 'growlink' ) . "</p><p style='margin-top:25px;margin-bottom:25px'>$button<br>";

			$sent = sendNotification($subject,$content,$email,true);
			wp_mail($GLOBALS['ADMINEMAIL'], __('New user registration','growlink'), $subject. ": " . $username . ' (' . $email . ')');

			$createbio = array(
				'post_title'    => $username,
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_author'   => $user->ID,
				'post_type' => 'post'
   			);
   			$idpost = wp_insert_post($createbio);

   			$datapost = array('site-title' => $username,'site-intro' => '','site-hero' => 'empty','site-herodata' =>'','site-font' => 'Barlow','site-color-text' => '#333333','site-border' => '16','site-bgcolor' => '#f8f8f8','site-color-link' => '#3C28AD','site-roundedcorners' => 'rounded','site-viewdesign' => 'list');
			update_post_meta($idpost, 'design_data', $datapost);

			$optiondata = array('option-fbpixel' => '','option-ga' => '','option-mailchimp' => '','option-mailchimp-list' => '','option-titletag' => '','option-dsc' => '','option-ographimg' => '','option-favicon' => '');
			update_post_meta($idpost, 'option_data', $optiondata);

			//Echo the result in json
			if($idpost){
		    	wp_send_json(array('action'=> 'signup','type' => 'success','message'=>  __( 'We just sent you an email to verify your user. Please check your inbox.', 'growlink' ),'url' => '','resetform' => true));
		    }
		} else {
			$error_string = $user_id->get_error_message();
			wp_send_json(array('type'=> 'danger','action' => 'error','message'=>  $error_string,'error' => $error_string,'resetform' => false));
		}
	}

	//LOGIN
	if($_POST['typeform'] == 'form_login'){
		wp_clear_auth_cookie();
		verify_general_nonce();

		$creds = array();
		$creds['user_email'] = sanitize_email($_POST['email']);
		$creds['user_password'] = esc_attr($_POST['pass']);
		$creds['remember'] = true;

		//Detect if validated the email
		//User exist?
		$u = get_user_by('email',$creds['user_email']);
		$check = (is_object($u)) ? wp_authenticate_username_password( NULL, $u->user_login,$creds['user_password']) : new WP_Error('error');
		$creds['user_login'] = $u->user_login;

		if(!is_wp_error($check)){
			//If user exist, detect if key exist
			$validatekey = get_user_meta($check->ID, '_data_user_key',true);
			//If the key is empty signon the user if not thrown an error
			$validated = ($validatekey == '') ? true : false;

			if($validated){
				//If the user has validate is email
				$user = wp_signon($creds, false);
				wp_set_auth_cookie($user->ID,true);
				wp_set_current_user($user->ID);
				$tourl = add_query_arg('language', 'es', home_url('dashboard'));
				wp_send_json(array('success'=> true,'url' => $tourl));
			} else {
				$urllink = get_bloginfo('url') . "/login?action=resendvalidation";
				$messagebox = __( 'You must validate your email.', 'growlink') . "<br><a href='" . $urllink . "'>" . __( 'Resend validation', 'growlink') . "</a>";
				wp_send_json(array('action' => 'novalidate','type' => 'warning','message'=> $messagebox,'resetform' => true));
			}

		} else {
			//Error on the credentials
			wp_send_json(array('action' => 'nouser','type' => 'warning', 'message'=> __( 'Wrong credentials', 'growlink'),'resetform' => true));
		}
	}

	if($_POST['typeform'] == 'form_recover'){

		$email = sanitize_email($_POST['email']);

		$u = get_user_by('email',$email);

		if ($u){
			$user_login = $u->user_login;
        	$user_email = $u->user_email;
        	$key = substr( md5( uniqid( microtime() ) ), 0, 8);
        	global $wpdb;
        	$wpdb->query("UPDATE $wpdb->users SET user_activation_key = '$key' WHERE user_login = '$user_login'");

        	$subject = __( 'Reset your password', 'growlink' );
			$link = get_bloginfo('url') ."/login?action=resetpass&key=" . $key . "&useremail=" . $email;
			$button = htmlButton($link,__('Reset password','growlink'));
			$content = "<p>" . __( 'Someone has asked to reset the password of your profile in Growlink. To reset your password visit the following address:', 'growlink' ) . "</p><p style='margin-top:25px;margin-bottom:25px'>".$button."<br>";

			$sent = sendNotification($subject,$content,$email,true);

			wp_send_json(array('action' => 'resetok','type' => 'success','message'=> __('The instructions have been sent to your email','growlink'),'resetform' => true));

		} else {
			wp_send_json(array('action' => 'nouser','type' => 'danger','message'=> __('Username does not exist','growlink'),'resetform' => true));
		}
	}

	if($_POST['typeform'] == 'form_resetpass'){
		$u = get_user_by('email',$_POST['useremail']);
		$pass = $_POST['pass'];
	    if($u){
	    	wp_set_password($pass,$u->ID);
	    	wp_send_json(array('success' => true,'action' => 'resetok','type' => 'success','message'=> "",'resetform' => true,'url' => get_bloginfo('url') . "/login?action=resetpasssuccess"));
	    } else {
	    	wp_send_json(array('action' => 'nouser','type' => 'danger','message'=> __('Username does not exist','growlink'),'resetform' => true));
	    }
	}

	if($_POST['typeform'] == 'form_resendvalidation'){
		$u = get_user_by('email',$_POST['email']);
	    if($u){
	    	$validatekey = get_user_meta($u->ID, '_data_user_key',true);
	    	if($validatekey != ''){
	    		$link = md5(uniqid());
				update_user_meta($u->ID,'_data_user_key',$link);

				//Send notification email
				$subject = __( 'Validate your email', 'growlink' );
				$link = get_bloginfo('url') ."/login?_emailvalidation=" . $link . "&user=" . $u->ID;
				$content = "<p>" . __( 'You have resend the link to validate your acount. Please click the next link.', 'growlink' ) . "</p><p style='margin-top:25px;margin-bottom:25px'><a href='".$link."' style='background: #4137CF;color:#ffffff;padding:14px 30px;text-decoration:none;font-size:17px;text-align-center;border-radius:6px' target='_blank' title=''>Confirm email</a><br>";

				$sent = sendNotification($subject,$content,$u->user_email,true);
	    	}
	    	wp_send_json(array('action' => 'resendcode','type' => 'success','message'=> __('We have just send the link to yor inbox.','growlink'),'resetform' => true));
	    } else {

	    }
	}

	if($_POST['typeform'] == 'form_contact'){
		$email = sanitize_email($_POST['email']);
		$name = sanitize_text_field($_POST['name']);
		$message = sanitize_text_field($_POST['message']);

		if(is_email($email)){
			$subject = __( 'Contact from Growlink', 'growlink' );
			$content = "<p>".__('Name','growlink').": $name<br>".__('Email','growlink').": $email<br>".__('Nessage','growlink').":<br>$message</p>";
			$sent = sendNotification($subject,$content,$GLOBALS['ADMINEMAIL'],true);
			if($sent)
				wp_send_json(array('action' => 'resetok','type' => 'success','message'=> __('Thanks for writing to us. We will respond you as soon as possible.','growlink'),'resetform' => true));

		} else {
			wp_send_json(array('action' => 'nouser','type' => 'danger','message'=> __('An error ocurred.','growlink'),'resetform' => true));
		}
	}

	if($_POST['typeform'] == 'clicked_card'){

		$date = date("Y-m-d H:i:s");

		//detect if the creator is clicking
		if(!isset($_COOKIE['_growlink_creator']) && !isset($_COOKIE['_growlink_creator_bio'])){

			$http_referer = isset( $_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/" ;
			$http_user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "" ;

			if (function_exists('geoip_detect2_get_client_ip')) {
				$ip = geoip_detect2_get_client_ip();
			} else {
				$ip = getUserIP();
			}

			global $wpdb;
			$table_name = $wpdb->prefix . 'linkstats';
			$wpdb->insert($table_name, array(
				'ip' => $ip,
				'bio' => $_POST['id'],
				'element' => $_POST['element'],
				'url' => $_POST['url'],
				'referer' => $http_referer,
				'agent' => $http_user_agent,
				'date' => $date
			));
			$lastId = $wpdb->insert_id;
			if($lastId){
				wp_send_json(array('success' => true,'message' => $lastId));
			}
		}
	}

	if($_POST['typeform'] == 'subscribeNewsletter'){
		$error = array();
		$idbio = (isset($_POST['idbio'])) ? $_POST['idbio'] : $error[] = __('ID missing','growlink');
		$firstname = (isset($_POST['firstname'])) ? $_POST['firstname'] : $error[] = __('Firstname missing','growlink');
		$lastname = (isset($_POST['lastname'])) ? $_POST['lastname'] : $error[] = __('Lastname missing','growlink');
		$email = (isset($_POST['email'])) ? $_POST['email'] : $error[] = __('Email missing','growlink');

		if(is_email($email) && empty($error)){
			$optionsdata = maybe_unserialize(get_post_meta(intval($idbio), 'option_data',true));
			$apikey = $optionsdata['option-mailchimp'];
			$idlist = $optionsdata['option-mailchimp-list'];


			if($apikey != '' && $idlist != ''){

				$result = mailchimp_subscribe_unsubscribe($apikey,$idlist,$email,'subscribed',array('FNAME'=>$firstname, 'LNAME'=>$lastname));

				if($result){
					wp_send_json(array('success' => true,'message' => __('Thanks for subscribing, please check your inbox to validate the email.','growlink'),'url' => '','resetform' => true));
				} else {
					wp_send_json(array('success' => false,'message' => __('Ops! Something happened.','growlink'),'url' => '','resetform' => true));
				}
			}
		} else {
			wp_send_json(array('success' => false,'message' => __('Ups something if wrong.','growlink')));
		}
	}
}

add_action('wp_ajax_sendPublicform', 'sendPublicform');
add_action('wp_ajax_nopriv_sendPublicform', 'sendPublicform');

function sendform(){
	if($_POST['typeform'] == 'add_element'){
		//check_ajax_referer( 'dashboard', 'security' );
		$type = $_POST['type'];
		$e = $_POST['element'];
		if($type == 'link'){
			include(get_template_directory() . "/partials/components/backend/_linkelement.php");
		} elseif($type == 'section'){
			include(get_template_directory() . "/partials/components/backend/_sectionelement.php");
		} elseif($type == 'email'){
			include(get_template_directory() . "/partials/components/backend/_emailelement.php");
		} elseif($type == 'social'){
			include(get_template_directory() . "/partials/components/backend/_linksocial.php");
		}
	}

	if($_POST['typeform'] == 'delete_element'){
		//check_ajax_referer( 'dashboard', 'security' );
		$r = delete_post_meta($_POST['id'],'element-' . $_POST['element']);
		wp_send_json(array('success' => true));
	}

	if($_POST['typeform'] == 'sticky_element'){
		//check_ajax_referer( 'dashboard', 'security' );
		$g = maybe_unserialize(get_post_meta($_POST['id'], 'element-' . $_POST['element'], true));
		$m = update_post_meta( $_POST['id'], 'element-' . $_POST['element'], $g);
		if($m)
			wp_send_json(array('success' => true,'message' => $m));
		else
			wp_send_json(array('success' => false,'message' => $m));
	}

	if($_POST['typeform'] == 'saveState'){
		$error = array();
		$types = array('link','section','email','social');

		$idbio = (isset($_POST['idbio'])) ? $_POST['idbio'] : $error[] = __('ID Missing','growlink');

		$elements = (isset($_POST['element'])) ? $_POST['element'] : false;

		if($elements){
			//Reorder the elements
			$n = 0;
			foreach ($elements as $key => $value) {
				$n++;
				$value['position'] = $n;
				if(isset($value['url'])){
					if (!preg_match("~^(?:f|ht)tps?://~i", $value['url'])) {
       					$value['url'] = "http://" . $value['url'];
    				}
				}
				$el[$key] = $value;

			}

			//Save the elements
			foreach ($el as $x => $y) {
				update_post_meta($idbio,'element-' . $x,$y);
			}
			wp_send_json(array('success' => true,'message' => __('Saved','growlink'),'datajson' => $el));
		} else {
			wp_send_json(array('success' => false,'message'=> __('Nothing to save','growlink')));
		}
	}

	if($_POST['typeform'] == 'renderPreview'){
		//$error = array();
		$design = $_POST['design'];
		$integrations = $_POST['integrations'];
		$data = (isset($_POST['data']) && $_POST['data'] != '') ? $_POST['data'] : "";
		$neworder = array_sort($data, 'position', SORT_ASC);

		$avatar = $_POST['avatar'];
		$showedit = ($avatar != '' && !strpos('2.gravatar.com', $avatar)) ? '<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#888888"><path d="M8.707 19.707L18 10.414 13.586 6l-9.293 9.293c-.128.128-.219.289-.263.464L3 21l5.242-1.03C8.418 19.926 8.579 19.835 8.707 19.707zM21 7.414c.781-.781.781-2.047 0-2.828L19.414 3c-.781-.781-2.047-.781-2.828 0L15 4.586 19.414 9 21 7.414z"/></svg> ' . __('Change picture','growlink') . "</span>": "";
		$html = '<style>@import url(https://fonts.googleapis.com/css?family='.urlencode($design['site-font']).':300,400,700&display=swap);';
		$html .= "#profile-page-user{background-color: {$design['site-bgcolor']};font-family: '{$design['site-font']}',Helvetica Neue,Helvetica,sans-serif;color: {$design['site-color-text']} !important;}#profile-page-user .name,#profile-user-page .smallbio.lead,#profile-page-user .card-text{color: {$design['site-color-text']} !important;}.name{color: {$design['site-color-text']} !important;}.site-border{border-radius:{$design['site-roundedcorners']}px} #profile-page-user .card-title{color: {$design['site-color-link']} !important;}#profile-page-user .card-text{color: {$design['site-color-text']} !important;}</style>";

		if($design['site-hero'] === 'color'){
			$style = "style='background-color: ".$design['site-herodata']." !important'";
		} elseif($design['site-hero'] === 'imagen'){
			$style = "style='background-image: url('".$design['site-herodata']."');background-size: cover;'";
		} else {
			$style = '';
		}

		$html .= "<main id='profile-page-user' class='previewViewClass py-4 {$design['site-hero']} {$design['site-herodata']}'><div class='cover' $style></div><div class='container'><div class='row'><div class='col-12 text-center mb-3'><div class='avatar mb-3'><a href='". get_bloginfo('url') . "/design/'><img src='$avatar' class='site-border' width='100' height='100' alt=''>$showedit</a></div><div class='name'>{$design['site-title']}</div><div class='smallbio lead'>{$design['site-intro']}</div></div></div></div><section class='links-card {$design['site-viewdesign']} {$design['site-roundedcorners']}'><div class='container'><div class='row'><div class='col-12 mx-auto'><div class='maingridparent'>";

		$contents = '';
		if(!empty($neworder)){
			ob_start();
			foreach ($neworder as $list) {

				if($list['type'] == 'section' && isset($list['active']) && $list['active'] == 'yes'){
					include(get_stylesheet_directory() . '/partials/components/preview/preview_section_card.php');
				} elseif($list['type'] == 'link' && isset($list['active']) && $list['active'] == 'yes'){
					include(get_stylesheet_directory() . '/partials/components/preview/preview_link_card.php');
				} elseif($list['type'] == 'email' && isset($list['active']) && $list['active'] == 'yes'){
					include(get_stylesheet_directory() . '/partials/components/preview/preview_email_card.php');
				} elseif($list['type'] == 'social' && isset($list['active']) && $list['active'] == 'yes'){
					include(get_stylesheet_directory() . '/partials/components/preview/preview_social_card.php');
				} elseif($list['type'] == 'text' && isset($list['active']) && $list['active'] == 'yes'){
					include(get_stylesheet_directory() . '/partials/components/preview/preview_text_card.php');
				}
			}
			$contents = ob_get_contents();
			ob_end_clean();
		};
		$html .= $contents;
		$html .= "</div></div></div></div></section></main>";
		echo $html;
	}

	if($_POST['typeform'] == 'form_design'){
		$error = array();

		$idbio = (isset($_POST['idbio'])) ? $_POST['idbio'] : $error[] = __('ID Missing','growlink');
		$idbiodb = getBio($_POST['_userid'],'id');

		//Design options

		$herodata = 'empty';
		if($_POST['hero'] == 'pattern')
			$herodata = (isset($_POST['site-color-theme']) && $_POST['site-color-theme'] != '') ? $_POST['site-color-theme'] : "empty";
		elseif($_POST['hero'] == 'image')
			$herodata = (isset($_POST['custombackground']) && $_POST['custombackground'] != '') ? $_POST['custombackground'] : "empty";
		elseif($_POST['hero'] == 'color')
			$herodata = (isset($_POST['herocolor']) && $_POST['herocolor'] != '') ? $_POST['herocolor'] : "empty";


		$avatar = (isset($_POST['avatar'])) ? $_POST['avatar'] : '';
		$title = (isset($_POST['site-title'])) ? $_POST['site-title'] : '';
		$intro = (isset($_POST['site-intro'])) ? $_POST['site-intro'] : '';
		$hero = (isset($_POST['hero'])) ? $_POST['hero'] : 'empty';
		$sitefont = (isset($_POST['site-font'])) ? $_POST['site-font'] : 'Barlow';
		$roundedcorners = (isset($_POST['roundedcorners'])) ? $_POST['roundedcorners'] : '0';


		$colortext = (isset($_POST['site-color-text'])) ? $_POST['site-color-text'] : '#333333';
		$bgcolor = (isset($_POST['site-bgcolor'])) ? $_POST['site-bgcolor'] : '#f8f8f8';
		$linkcolor = (isset($_POST['site-color-link'])) ? $_POST['site-color-link'] : '#3C28AD';
		$border = (isset($_POST['site-border'])) ? $_POST['site-border'] : '16';
		$viewdesign = (isset($_POST['site-viewdesign'])) ? $_POST['site-viewdesign'] : 'list';

		if($idbio == $idbiodb && empty($error)){
			$data = array(
				'site-title' => sanitize_text_field($title),
				'site-intro' => sanitize_text_field($intro),
				'site-hero' => sanitize_text_field($_POST['hero']),
				'site-herodata' => sanitize_text_field($herodata),
				'site-font' => sanitize_text_field($sitefont),
				'site-color-text' => sanitize_hex_color($colortext),
				'site-bgcolor' => sanitize_hex_color($bgcolor),
				'site-roundedcorners' => sanitize_text_field($roundedcorners),
				'site-color-link' => sanitize_hex_color($linkcolor),
				'site-border' => sanitize_text_field($border),
				'site-viewdesign' => sanitize_text_field($viewdesign),
			);

			update_user_meta(intval($_POST['_userid']), 'user_avatar', $avatar);
			$update = update_post_meta($idbio,'design_data', $data);

			if(!is_wp_error($update)){
				wp_send_json(array('success' => true,'message' => __('Design Saved','growlink'),'url' => '','run' => 'preview','datadesign' => array('design' => $data,'avatar' => $avatar)));
			}else{
				$error_string = $update->get_error_message();
				wp_send_json(array('success'=> false, 'message'=>  __( 'An error occurred', 'growlink' ),'error' => $error_string));
			}
		} else {
			wp_send_json(array('success' => false,'message' => __('Nice try','growlink'),'url' => ''));
		}
	}

	if($_POST['typeform'] == 'form_options'){
		$error = array();

		$idbio = (isset($_POST['idbio'])) ? $_POST['idbio'] : $error[] = __('ID Missing','growlink');
		$idbiodb = getBio($_POST['_userid'],'id');

		//Design options
		$fbpixel = (isset($_POST['option-fbpixel'])) ? $_POST['option-fbpixel'] : '';
		$ga = (isset($_POST['option-ga'])) ? $_POST['option-ga'] : '';
		$mchimp = (isset($_POST['option-mailchimp'])) ? $_POST['option-mailchimp'] : '';
		$mchimplist = (isset($_POST['option-mailchimp-list'])) ? $_POST['option-mailchimp-list'] : '';
		$titletag = (isset($_POST['option-titletag'])) ? $_POST['option-titletag'] : '';
		$desc = (isset($_POST['option-dsc'])) ? $_POST['option-dsc'] : '';
		$ographimg = (isset($_POST['option-ographimg'])) ? $_POST['option-ographimg'] : '';
		$favicon = (isset($_POST['option-favicon'])) ? $_POST['option-favicon'] : '';

		if($idbio == $idbiodb && empty($error)){
			$data = array(
				'option-fbpixel' => sanitize_text_field($fbpixel),
				'option-ga' => sanitize_text_field($ga),
				'option-mailchimp' => sanitize_text_field($mchimp),
				'option-mailchimp-list' => sanitize_text_field($mchimplist),
				'option-titletag' => sanitize_text_field($titletag),
				'option-dsc' => sanitize_text_field($desc),
				'option-ographimg' => sanitize_text_field($ographimg),
				'option-favicon' => sanitize_text_field($favicon),
			);
			$update = update_post_meta($idbio, 'option_data', $data);
			if(!is_wp_error($update)){
				wp_send_json(array('success' => true,'message' => __('Options Saved','growlink'),'url' => ''));
			}
			else{
				$error_string = $update->get_error_message();
				wp_send_json(array('success'=> false, 'message'=>  __( 'An error occurred', 'growlink' ),'error' => $error_string));
			}
		} else {
			wp_send_json(array('success' => false,'message' => __('Nice try','growlink'),'url' => ''));
		}
	}

	if($_POST['typeform'] == 'form_account'){

		//verify_general_nonce();

		$error = array();
		global $theuser;

		if (isset($_POST['account-email']) && $_POST['account-email'] != ""){
			if (is_email($_POST['account-email'])){
				if (email_exists($_POST['account-email']) && $_POST['account-email'] != $theuser->user_email){
					$error[] = __('Email error, please use another one.','growlink');
				}else{
					$email = sanitize_email($_POST['account-email']);
				}
			} else {
				$error[] = __('Email is invalid','growlink');
			}
		} else{
			$error[] = __('Email can´t be empty','growlink');
		}


		if(empty($error)){
			$pass = (isset($_POST['account-pass']) && $_POST['account-pass'] != '') ? $_POST['account-pass'] : "";

			$updatedata = array();

			$updatedata['ID'] = $theuser->ID;
			$updatedata['user_email'] = $email;

			if($pass != '')
				$updatedata['user_pass'] = $theuser->ID;

			$r = wp_update_user($updatedata);


			if(!is_wp_error($r)){
				wp_send_json(array('success' => true,'message' => __('Data Saved','growlink'),'url' => get_the_permalink()));
			}
			else{
				$error_string = $r->get_error_message();
				wp_send_json(array('success'=> false, 'message'=>  __( 'An error occurred', 'growlink' ),'error' => $error_string));
			}
		} else {
			wp_send_json(array('success' => false,'message' => __('Nice try','growlink'),'url' => ''));
		}
	}

	if($_POST['typeform'] == 'viewlinkstat'){
		//verify_general_nonce();
		$statsArray = viewstatlink($_POST['element']);
		$datesStats = array();
		$clicksStats = array();
		if(!empty($statsArray)){
			foreach ($statsArray as $k => $l) {
				$datesStats[] = $k;
				$clicksStats[] = $l;
			}
			wp_send_json(array('success' => true,'label' => __('Clicks stats last 7 days','growlink'),'datestats' => $datesStats,'clickstats' => $clicksStats));
		} else {
			wp_send_json(array('success' => false,'message' => __('This link has been clicked 0 times.','growlink')));
		}
	}

	wp_die();
}
add_action('wp_ajax_sendform', 'sendform');
?>