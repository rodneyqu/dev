<?php
$r_sart = microtime(true);
require_once dirname(dirname(__FILE__)).'/lib/common.php';

$msg = $_GET ['m'] == 2 ? '01c9b46f-af99-4c70-90ed-3fe6593e8795.FRT.rt.clk' : '01c9b46f-af99-4c70-90ed-3fe6593e8795.FRT.fb.clk';



$ip = getOneOfIPArr(get_user_ip());

$pageID = isset($_GET['page']) && $_GET['page'] ? $_GET['page'] : 1;
$kwd = $_GET['kwd'];
$go_url = urldecode( $_GET ['url']);
$uid = isset($_GET['ssp']) ? $_GET['ssp'] : '';
$decryptedUID = decrypt($uid, 'DECODE', 'sstweb_string', 0);
$TypeTag = getPV("typetag",$decryptedUID);
$SID = getPV("sid",$decryptedUID );
$referer_url = isset($_SERVER ['HTTP_REFERER']) && $_SERVER ['HTTP_REFERER'] ? $_SERVER ['HTTP_REFERER'] : '';
$eui = isset($_GET['eui']) ? $_GET['eui'] : '';
$redirect_url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

$start_time = microtime_float();
// call Graphite
$graphiteMsg = "bposite.raazsite.safesearchclick";
//callBPOHostedGraphite($graphiteMsg);
$end_start_time = microtime_float();
$graphite_time = $end_start_time - $start_time;
$sec = '';
$search = '';
$sst_url = "http://sstracker.smartclicksystem.com/fpd_out_tracking.php?ptr=RZ&tt=".$TypeTag."&sk=".urlencode($kwd)."&ka=".urlencode($kwd)."&sid=".$SID."&search=".$search."&sec=".$sec."&ip=".$ip."&page=".$pageID;
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $sst_url,
    CURLOPT_USERAGENT => 'SST Tracker'
));
// Send the request
//curl_exec($curl);
// Close request to clear up some resources
//curl_close($curl);


$l_start_time = microtime_float();
// appache log
$full_url = "";
$note = $full_url."[:**]".urlencode($_GET ['kwd'])."[:**][:**][:**]".$ip."[:**]".$referer_url."[:**]safesearchclick[:**]".date('Y-m-d H:i:s')."[:**]".$eui."[:**]".$redirect_url."[:**]";
if( function_exists("apache_note") ){
    //apache_note('safesearchlog', $note);
}
$l_end_time = microtime_float();
$log_time = $l_end_time - $l_start_time;


$r_end_time = microtime(true);

if( isset($_GET['debug_apiurl']) && $_GET['debug_apiurl'] == 1 ){
    echo "sst_url: ".$sst_url."<br>";
    die;
}

redirect ( $_GET ['url'], false );


function redirect($url, $permanent = false) {
    header ( 'Location: ' . $url, true, $permanent ? 301 : 302 );
    
    exit ();
}

?>