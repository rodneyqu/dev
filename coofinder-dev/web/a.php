<?php

//$ddcUrl = "http://yssads.ddc.com/x1.php?c=18481&ip=".$IpIn."&n=0&format=xml&algo=".($ws*5)."&kw=".urlencode($kwd)."&ua=".$ua."&surl=".urlencode('http://www.rockettab.com');

$ddcUrl = base64_decode($_GET['u']);

getResultsFromDDC($ddcUrl);

// get websearch results from  ddc
function getResultsFromDDC($url){

        //$string = file_get_contents($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $rsp = curl_exec($ch);
        curl_close($ch);

        $string = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $rsp);

        echo $string;
}