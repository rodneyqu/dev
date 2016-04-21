<?php
require_once dirname(dirname(__FILE__)).'/lib/common.php';

$kwd = '';
$uid = isset($_REQUEST['ssp']) ? $_REQUEST['ssp'] : '';
$ip = getOneOfIPArr(get_user_ip());
$referer_url = '';
$eui = $_REQUEST['eui'];
$decryptedUID = decrypt($uid, 'DECODE', 'sstweb_string', 0);

$ts = getPV("ts",$decryptedUID);
$click_id = getPV("click_id",$decryptedUID);

$res = '';
if( $ts == 'a1' && $click_id  ){
    $call_url = "http://www.adcash.com/script/register_event.php?key=549d8637d0639dcfd890d5a8e27513f9&idform=1483571&campagne=19295480&cid=".$click_id."&variable=".$eui;
    $res = curl_require($call_url);
}


// call Graphite
$graphiteMsg = "bposite.raazsite.welcome";
callBPOHostedGraphite($graphiteMsg);

// appache log
$note = "https://safesearch.raaz.io/welcome.php[:**]".$kwd."[:**]".$uid."[:**]".$decryptedUID."[:**]".$ip."[:**]".$referer_url."[:**]welcome[:**]".date('Y-m-d H:i:s')."[:**]".$eui."[:**][:**]".$_SERVER['HTTP_USER_AGENT'];
if( function_exists("apache_note") ){
    apache_note('safesearchlog', $note);
}



