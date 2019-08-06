<?php


if(isset($_GET['_emailvalidation']) && $_GET['_emailvalidation']!= '' && isset($_GET['user']) && $_GET['user'] != ''){
    $d = get_user_meta(intval($_GET['user']),'_data_user_key',true);
	if($d === $_GET['_emailvalidation']){
        $ver = update_user_meta(intval($_GET['user']),'_data_user_key','');
        $confirmedemail = true;
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'resetpass' && isset($_GET['key']) && isset($_GET['useremail'])){
    $u = get_user_by('email',$_GET['useremail']);
    if($u){
        global $wpdb;
        $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_email = %s", $_GET['key'], $_GET['useremail']));
        if (!empty($user)){
            $userreset = $user;
        }
    }
}

/*
*Instagram connect
*/

if(isset($_POST['instagram_login']) && $_POST['instagram_login'] === 'logininstagram'){
    //If login form button in login clicked init instagram api connect
    $obj_insta = new instaClass();
    $obj_insta->authInstagram();
}

if(isset($_GET['code']) && $_GET['code'] != ''){
    $obj_insta = new instaClass();

    // Set access token
    $obj_insta->setAccess_token($_GET['code']);

    // Get user details
    $result = $obj_insta->getUserDetails();

    if(!isset($result->error_type)){
        $_SESSION['insta_account'] = $result;
        global $theuser;
        update_user_meta($theuser->ID,'ig_connect',array('id' => $result->user->id,'username' => $result->user->username,'profile_picture' => $result->user->profile_picture,'full_name' => $result->user->full_name));
        $image_url = get_user_meta($theuser->ID, 'user_avatar', true);
        if($image_url == ''){
            update_user_meta($theuser->ID, 'user_avatar', $result->user->profile_picture);
        };
    }
}



?>