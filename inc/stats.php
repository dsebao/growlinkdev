<?php

function getUserIP(){
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    } elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    } else{
        $ip = $remote;
    }
    return $ip;
}

function is_bot() {
	return (
    	isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
  	);
}

function addvisitor($bio){
    $date = date("Y-m-d H:i:s");

    //Detect if the creator is viewing the landing
    if(!isset($_COOKIE['_growlink_creator']) && !isset($_COOKIE['_growlink_creator_bio'])){

        $http_referer = isset( $_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/" ;


        $http_user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "" ;

        if (function_exists('geoip_detect2_get_client_ip')) {
            $ip = geoip_detect2_get_client_ip();
        } else {
            $ip = getUserIP();
        }

        if (function_exists('geoip_detect2_get_info_from_current_ip')) {
            $userInfo = geoip_detect2_get_info_from_current_ip();
            $country = $userInfo->country->isoCode;
        } else {
            $country = '';
        }

        global $wpdb;
        $wpdb->show_errors();
        $table_name = $wpdb->prefix . 'landingstats';
        $wpdb->insert($table_name, array(
            'ip' => $ip,
            'landing' => $bio,
            'referer' => $http_referer,
            'agent' => $http_user_agent,
            'country' => $country,
            'date' => $date
        ));
    }
}