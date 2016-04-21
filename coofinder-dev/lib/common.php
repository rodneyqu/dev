<?php


function getUid(){

    $default_sid = md5(rand(1, 1000000).'_'.strtotime('now'));  // default sid

    $default_params = array(
        "typetag=".DEFAULT_TYPE_TAGE,
        "b_st=".SOURCE_TAG_WWW,
        "b_tt=".DEFAULT_TYPE_TAGE,
        'sid='.$default_sid
    );

    $uid = decrypt(implode('|', $default_params), 'ENCODE', KEY, EXPIRY);

    return $uid;
}

function geoip_open($filename, $flags) {
    $gi = new GeoIP;
    $gi->flags = $flags;
    if ($gi->flags & GEOIP_SHARED_MEMORY) {
        $gi->shmid = @shmop_open (GEOIP_SHM_KEY, "a", 0, 0);
    } else {
        $gi->filehandle = fopen($filename,"rb") or die( "Can not open $filename\n" );
        if ($gi->flags & GEOIP_MEMORY_CACHE) {
            $s_array = fstat($gi->filehandle);
            $gi->memory_buffer = fread($gi->filehandle, $s_array['size']);
        }
    }

    $gi = _setup_segments($gi);
    return $gi;
}

function getOneOfIPArr($ipArr){
    $IpExArr = explode( ',', $ipArr);
    if (is_array($IpExArr)) {
        $IpExArr = array_reverse($IpExArr);
        $IPLength = count($IpExArr);
        foreach ($IpExArr as $ip) {
            if (empty($ip)) continue;
            $iplist = explode('.', $ip);
            if ($iplist [0] == '10' && $IPLength > 1) continue;
            $lastIp = $ip;
            break;
        }
        if(empty($lastIp))
            $lastIp = $IpExArr[0];
    } else {
        $lastIp = $ipArr;
    }
    return trim($lastIp);
}

function get_user_ip()
{
    if ( isset($_SERVER["HTTP_CLIENT_IP"]) && $_SERVER["HTTP_CLIENT_IP"]) {
        $IpIn = $_SERVER["HTTP_CLIENT_IP"];
    } elseif ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && $_SERVER["HTTP_X_FORWARDED_FOR"]) {
        $IpIn = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif ($_SERVER["REMOTE_ADDR"]) {
        $IpIn = $_SERVER["REMOTE_ADDR"];
    } elseif (getenv("HTTP_CLIENT_IP")) {
        $IpIn = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $IpIn = getenv("HTTP_X_FORWARDED_FOR");
    } elseif (getenv("REMOTE_ADDR")) {
        $IpIn = getenv("REMOTE_ADDR");
    } else {
        $IpIn = "67.202.25.211";
    }

    if( isset($_GET['debug_ip']) && $_GET['debug_ip'] ){
        $IpIn = $_GET['debug_ip'];
    }

    return $IpIn;
}

function getQS($n, $url){
    $qs = parse_url($url, PHP_URL_QUERY);
    parse_str($qs, $qp);
    return $qp[$n];
}

function getPV($n, $s){
    $p = explode('|', $s);
    $x = array();
    array_walk($p, function($v,$k) use(&$x){
        //list($k, $z) = explode('=', $v);
        $tmp = explode('=', $v);
        $x[$tmp[0]] = isset($tmp[1]) ? $tmp[1] : '';
    });
    if( ! isset($x[$n]) ){
        return null;
    }
    return $x[$n];
}

function getUrl() {
    $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
    $url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
    $url .= $_SERVER["REQUEST_URI"];
    return $url;
}

function print_rr($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die;
}

function callHostedGraphite($msg) {
    try {
        include_once dirname(dirname ( __FILE__ )) . '/lib/hostStatsd.php';
        $stats = new StatsD ( 'statsd.hostedgraphite.com', 8125 );
        $stats->counting ( $msg, 1 );
    }
    catch ( Exception $e ) {

    }
}


function callBPOHostedGraphite($msg) {
    $fp = fsockopen ( 'udp://statsd.tfxiq.com', 8125, $errno, $errstr );
    // Will show warning if not opened, and return false
    if($fp) {
        fwrite ( $fp, $msg.':1|c|@1' );
        fclose ( $fp );
    }
}

function getInstance($class,$parameter){
    static $instances = array();
    $key = md5($class.'_'.$parameter);

    if(!array_key_exists($key,$instances)){
        $instances[$key] = new $class($parameter);
    }
    $instance = $instances[$key];
    return $instance;
}

function objectToArray($e){
    $e=(array)$e;
    foreach($e as $k=>$v){
        if( gettype($v)=='resource' ) return;
        if( gettype($v)=='object' || gettype($v)=='array' )
            $e[$k]=(array)objectToArray($v);
    }
    return $e;
}

// get websearch results from  ddc
function getResultsFromDDC($keywords,$num,$index){
    global $apiurl_arr,$api_data, $safe;
    /*include_once (dirname(dirname(__FILE__))."/lib/cache.class.php");
    if( !isset($redisCenter) || !is_object($redisCenter)){
        error_reporting(0);
        $redisCenter   = getInstance('CacheRedis',REDIS_READ_SERVERS);
    }
    $key=md5($keywords);
    $sql_hash="ddcws_".$key;

    if($redisCenter->status!='noconnect'){
        try{
            $memcResults=unserialize(gzuncompress($redisCenter->get($sql_hash)));
        }catch(Exception $e){
            $memcResults=false;
        }

    }*/
    $memcResults = false;
    if($memcResults){
        /* try{
             $redisCenter->set($sql_hash,gzcompress(serialize($memcResults),9),172800);
         }catch(Exception $e){
         }*/
        return  array('total'=>'20', 'results'=>$memcResults['results']);
    } else {
        $IpIn = trim(getOneOfIPArr(trim(get_user_ip())));
        $IpIn = "8.8.8.8";
        $ua=urlencode($_SERVER['HTTP_USER_AGENT']);
        $surl=urlencode('http://www.rockettab.com');
        $filter = '';
        if( $safe == 'on' ){
            $filter =  "&sf=1";
        }
        $url="http://yssads.ddc.com/x1.php?c=18481&ip=".$IpIn."&n=0&format=xml&algo=".$num."&kw=".urlencode($keywords)."&ua=".$ua."&surl=".$surl.$filter;
        $call_start_time = microtime(true);
        $string=file_get_contents($url);
        $call_end_time = microtime(true);

        $string = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $string);
        //$results = json_decode ( $string, true );
        $xml=(array)simplexml_load_string($string,'SimpleXMLElement',LIBXML_NOCDATA);
        $results=objectToArray($xml);

        if(!empty($_GET['debug_apiurl']))
        {
            $apiurl_arr[] = array(
                'url' => $url,
                'name' => 'ddc_api',
                'microtime' => $call_end_time - $call_start_time
            );
            $api_data[] = $xml;
        }

        $total = count($results['web']['web']);
        $list = array ();
        if (! empty ($results['web']['web'])) {
            $i = 0;
            foreach ($results['web']['web'] as $value ) {
                $list ['results'][$i] ['url'] = $value ['url'];
                $list ['results'][$i] ['title'] = $value ['title'];
                $list ['results'][$i] ['desc'] = $value ['description'];
                $list ['results'][$i] ['type']='external nofollow';
                $i ++;
            }
        }
        $list['total']=$total;
        /*if($redisCenter->status!='noconnect'){
            try{
                $redisCenter->set($sql_hash,gzcompress(serialize($list),9),172800);
            }catch(Exception $e){
            }
        }*/
        return $list;
    }
}


function getImagesFromBingApi($kwd,$num,$pageIndex){

$url='https://api.datamarket.azure.com/Data.ashx/Bing/Search/Image?$top='.$num.'&$format=Json&Query=%27'.urlencode(trim($kwd)).'%27&$skip='.$pageIndex;

 $username='coofiner';
 $password='1G9Yx9OhuW5TvmhiO9BlFEczYuP2rjgave0OWkiL6NE';
    $ch = curl_init ();
    
    
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
    $rsp = curl_exec ( $ch );
    $string = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $rsp);
  
    $arr=json_decode($string,true);
    return $arr['d']['results'];
}

function getVideosFromBingApi($kwd,$num, $pageIndex){
$url='https://api.datamarket.azure.com/Data.ashx/Bing/Search/Video?$top='.$num.'&$format=Json&Query=%27'.urlencode(trim($kwd)).'%27&$skip='.$pageIndex;

 $username='coofiner';
 $password='1G9Yx9OhuW5TvmhiO9BlFEczYuP2rjgave0OWkiL6NE';
    $ch = curl_init ();
    
    
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
    $rsp = curl_exec ( $ch );
    $string = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $rsp);
  
    $arr=json_decode($string,true);
   
    return $arr['d']['results'];

}

function getNewsFromBingApi($kwd,$num, $pageIndex){
$url='https://api.datamarket.azure.com/Data.ashx/Bing/Search/News?$top='.$num.'&$format=Json&Query=%27'.urlencode(trim($kwd)).'%27&$skip='.$pageIndex;

 $username='coofiner';
 $password='1G9Yx9OhuW5TvmhiO9BlFEczYuP2rjgave0OWkiL6NE';
    $ch = curl_init ();
    
    
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
    $rsp = curl_exec ( $ch );
    $string = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $rsp);
  
    $arr=json_decode($string,true);
    
    return $arr['d']['results'];



}

// web
function getResultFromYahooBossAPI($keywords, $num = 10, $index=0){
    global $safe, $apiurl_arr, $api_data;

    $index = $index <= 0 ? 1: $index;

    $cc_key = "dj0yJmk9cW03b0JqbmRUdHF1JmQ9WVdrOWMwUk5VMWhrTkdVbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1hNw--";
    $cc_secret = "6e55a625104d10f29979efee874bcd95cf36dc98";

    $url = "http://yboss.yahooapis.com/ysearch/web";

    $args = array ();
    $args ["q"] = $keywords;
    $args ["format"] = "xml";
    $args ["count"] = $num;
    $args ["start"] = ($index-1)*$num;
    if( $safe == 'on' ){
        $args ["filter"] =  "-porn";
    }
    $rtb_start_time = microtime(true);
    $consumer = new OAuthConsumer ( $cc_key, $cc_secret );
    $request = OAuthRequest::from_consumer_and_token ( $consumer, NULL, "GET", $url, $args );
    $request->sign_request ( new OAuthSignatureMethod_HMAC_SHA1 (), $consumer, NULL );
    $url = sprintf ( "%s?%s", $url, OAuthUtil::build_http_query ( $args ) );
    $ch = curl_init ();
    $headers = array ($request->to_header () );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
    $rsp = curl_exec ( $ch );
    $rtb_end_time = microtime(true);

    $string = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $rsp);

    $xml=(array)simplexml_load_string($string,'SimpleXMLElement',LIBXML_NOCDATA);

    $results=objectToArray($xml);

    if(!empty($_GET['debug_apiurl']))
    {
        $apiurl_arr[] = array(
            'url' => $url,
            'name' => 'web_api',
            'microtime' => $rtb_end_time - $rtb_start_time
        );

        $api_data[] = $xml;
    }
    $total = isset($results['web']['@attributes']['totalresults']) ? $results['web']['@attributes']['totalresults'] : 0;
    $list = array ();
    if (! empty ($results['web']['results']['result'])) {
        $i = 0;
        foreach ($results['web']['results']['result'] as $value ) {
            $list ['results'][$i] ['url'] = $value ['url'];
            $list ['results'][$i] ['clickurl'] = $value ['clickurl'];
            $list ['results'][$i] ['dispurl'] = $value ['dispurl'];
            $list ['results'][$i] ['title'] = $value ['title'];
            $list ['results'][$i] ['desc'] = $value ['abstract'];
            $list ['results'][$i] ['type']='external nofollow';
            $i ++;
        }
    }
    $list['total']=$total;

    return $list;
}


// related
function getRelatedFromYahooBossAPI($keywords, $num = 10, $index=0){
    global $safe, $apiurl_arr, $api_data;

    $cc_key = "dj0yJmk9cW03b0JqbmRUdHF1JmQ9WVdrOWMwUk5VMWhrTkdVbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1hNw--";
    $cc_secret = "6e55a625104d10f29979efee874bcd95cf36dc98";

    $url = "http://yboss.yahooapis.com/ysearch/related";

    $args = array ();
    $args ["q"] = urldecode($keywords);
    $args ["format"] = "xml";
    $args ["count"] = $num;
    $args ["start"] = $index;
    $rtb_start_time = microtime(true);
    $consumer = new OAuthConsumer ( $cc_key, $cc_secret );
    $request = OAuthRequest::from_consumer_and_token ( $consumer, NULL, "GET", $url, $args );
    $request->sign_request ( new OAuthSignatureMethod_HMAC_SHA1 (), $consumer, NULL );
    $url = sprintf ( "%s?%s", $url, OAuthUtil::build_http_query ( $args ) );
    //echo $url;
    $ch = curl_init ();
    $headers = array ($request->to_header () );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
    $rsp = curl_exec ( $ch );
    $rtb_end_time = microtime(true);

    $string = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $rsp);

    $xml=(array)simplexml_load_string($string,'SimpleXMLElement',LIBXML_NOCDATA);

    $results=objectToArray($xml);

    if(!empty($_GET['debug_apiurl']))
    {
        $apiurl_arr[] = array(
            'url' => $url,
            'name' => 'related_api',
            'microtime' => $rtb_end_time - $rtb_start_time
        );

        $api_data[] = $xml;
    }
    $total = isset($results['related']['@attributes']['totalresults']) ? $results['web']['@attributes']['totalresults'] : 0;
    $list = array ();
    if (! empty ($results['related']['results']['result'])) {
        $i = 0;

        if( count($results['related']['results']['result']) > 1 ){
            foreach ($results['related']['results']['result'] as $value ) {
                $list [$i]['suggestion'] = $value ['suggestion'];
                $list [$i]['value']= ucwords($value ['suggestion']);
                $list [$i]['value'] = urldecode($list [$i]['value']);
                $list [$i]['type']="Boss";
                $i ++;
            }
        }else{
            $list [0]['suggestion'] = $results['related']['results']['result']['suggestion'];
            $list [0]['value']= ucwords($list [0] ['suggestion']);
            $list [0]['value'] = urldecode($list [0]['value']);
            $list [0]['type']="Boss";
        }

    }
    $list['total']=$total;

    if($_GET["debug_br"]){
        echo "<pre>";print_r( $results); echo "</pre>";
        echo "<pre>";
        print_r($rsp);
        echo "<hr />";
        print_r($list);
        die;
    }

    return $list;
}
//getRelatedFromYahooBossAPI("dvd");

function getNetSeerRelatedSearches($keywords){
    global $apiurl_arr, $api_data;

    $url = "http://tb.netseer.com/dsatserving2/servlet/BannerServer?";
    $args = array (
        "impt" 	=> "8",
        "imps" 	=> "3",
        "tlid" 	=> "25493",
        "ip"	=> trim(getOneOfIPArr(get_user_ip())),
        "url"	=> urlencode('http://'.$_SERVER['HTTP_HOST']),
        "ua"	=> urlencode($_SERVER['HTTP_USER_AGENT']),
        "ref"	=> urlencode($_SERVER['HTTP_REFERER']),
        "evid"	=> "seh3fd64a78e4f5d12345678",
        //"cimg"	=> "128",
        "q"	=> urlencode($keywords),

    );
    foreach ($args as $k => $v) {
        $url .= "&".$k."=".$v;
    }

    $call_start_time = microtime(true);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch,CURLOPT_HEADER,1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
    curl_setopt($ch, CURLOPT_REFERER,_REFERER_);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $rsp = curl_exec($ch);
    curl_close($ch);
    $call_end_time = microtime(true);
    $rsp = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $rsp);
    $xml=(array)simplexml_load_string($rsp,'SimpleXMLElement',LIBXML_NOCDATA);
    $results=objectToArray($xml);

    if(!empty($_GET['debug_apiurl']))
    {
        $apiurl_arr[] = array(
            'url' => $url,
            'name' => 'rs_api',
            'microtime' => $call_end_time - $call_start_time
        );

        $api_data[] = $xml;
    }

    $list = array ();
    if (! empty ( $results ['concepts']['concept'] )) {
        $i = 0;
        foreach ( $results ['concepts']['concept'] as $value ) {
            $list [$i] ['suggestion'] = $value ['visible'];
            $list [$i]['value']=ucwords($value ['visible']);
            $list [$i]['value'] = urldecode($list [$i]['value']);
            $list [$i]['type']="NETSEER";
            $i ++;
        }
    }
    if($_GET["debug_nsrs"]){
        echo "<pre>";
        echo $url;
        echo "<hr />";
        print_r($list);
        die;
    }

    return $list;
}

// images
function getImagesFromYahooBossAPI($keywords, $num = 35, $index=0, $related = false){
    global $safe, $apiurl_arr, $api_data;

    $cc_key = "dj0yJmk9cW03b0JqbmRUdHF1JmQ9WVdrOWMwUk5VMWhrTkdVbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1hNw--";
    $cc_secret = "6e55a625104d10f29979efee874bcd95cf36dc98";

    $url = "http://yboss.yahooapis.com/ysearch/images";

    $index = $index <= 0 ? 1: $index;

    $args = array ();
    $args ["q"] = $keywords;
    $args ["format"] = "xml";
    $args ["count"] = $num;
    $args ["start"] = ($index-1)*$num;
    if( $safe == 'on' ){
        $args ["filter"] =  "-porn";
    }
    $rtb_start_time = microtime(true);
    $consumer = new OAuthConsumer ( $cc_key, $cc_secret );
    $request = OAuthRequest::from_consumer_and_token ( $consumer, NULL, "GET", $url, $args );
    $request->sign_request ( new OAuthSignatureMethod_HMAC_SHA1 (), $consumer, NULL );
    $url = sprintf ( "%s?%s", $url, OAuthUtil::build_http_query ( $args ) );
    $ch = curl_init ();
    $headers = array ($request->to_header () );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
    $rsp = curl_exec ( $ch );
    $rtb_end_time = microtime(true);

    $string = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $rsp);

    $xml=(array)simplexml_load_string($string,'SimpleXMLElement',LIBXML_NOCDATA);

    $results=objectToArray($xml);

    if(!empty($_GET['debug_apiurl']))
    {
        $apiurl_arr[] = array(
            'url' => $url,
            'name' => 'images_api',
            'microtime' => $rtb_end_time - $rtb_start_time
        );

        $api_data[] = $xml;
    }

    return $results;

}

function getVideosFromYahooBossAPI($keywords, $num = 3, $index, $related = false){
    global $safe, $apiurl_arr, $api_data;

    $cc_key = "dj0yJmk9cW03b0JqbmRUdHF1JmQ9WVdrOWMwUk5VMWhrTkdVbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1hNw--";
    $cc_secret = "6e55a625104d10f29979efee874bcd95cf36dc98";

    $url = "http://yboss.yahooapis.com/ysearch/video";

    $index = $index <= 0 ? 1: $index;

    $args = array ();
    $args ["q"] = $keywords;
    $args ["format"] = "xml";
    $args ["Partner"] = "BOSS_PARTNER";
    $args ["count"] = $num;
    $args ["start"] = ($index-1) * 10;
    if( $safe == 'on' ){
        $args ["filter"] =  "-porn";
    }
    $rtb_start_time = microtime(true);
    $consumer = new OAuthConsumer ( $cc_key, $cc_secret );
    $request = OAuthRequest::from_consumer_and_token ( $consumer, NULL, "GET", $url, $args );
    $request->sign_request ( new OAuthSignatureMethod_HMAC_SHA1 (), $consumer, NULL );
    $url = sprintf ( "%s?%s", $url, OAuthUtil::build_http_query ( $args ) );
    $ch = curl_init ();
    $headers = array ($request->to_header () );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
    $rsp = curl_exec ( $ch );
    $rtb_end_time = microtime(true);

    $string = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $rsp);

    $xml=(array)simplexml_load_string($string,'SimpleXMLElement',LIBXML_NOCDATA);

    $results=objectToArray($xml);

    if(!empty($_GET['debug_apiurl']))
    {
        $apiurl_arr[] = array(
            'url' => $url,
            'name' => 'video_api',
            'microtime' => $rtb_end_time - $rtb_start_time
        );

        $api_data[] = $xml;
    }
    return $results;
}


function getNewsFromYahooBossAPI($keywords, $num = 3, $index, $related = false){
    global $safe, $apiurl_arr, $api_data;

    $cc_key = "dj0yJmk9cW03b0JqbmRUdHF1JmQ9WVdrOWMwUk5VMWhrTkdVbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1hNw--";
    $cc_secret = "6e55a625104d10f29979efee874bcd95cf36dc98";

    $url = "http://yboss.yahooapis.com/ysearch/news";

    $index = $index <= 0 ? 1: $index;

    $args = array ();
    $args ["q"] = $keywords;
    $args ["format"] = "xml";
    $args ["Partner"] = "BOSS_PARTNER";
    $args ["count"] = $num;
    $args ["start"] = ($index-1) * $num;
    if( $safe == 'on' ){
        $args ["filter"] =  "-porn";
    }
    $rtb_start_time = microtime(true);
    $consumer = new OAuthConsumer ( $cc_key, $cc_secret );
    $request = OAuthRequest::from_consumer_and_token ( $consumer, NULL, "GET", $url, $args );
    $request->sign_request ( new OAuthSignatureMethod_HMAC_SHA1 (), $consumer, NULL );
    $url = sprintf ( "%s?%s", $url, OAuthUtil::build_http_query ( $args ) );
    $ch = curl_init ();
    $headers = array ($request->to_header () );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
    $rsp = curl_exec ( $ch );
    $rtb_end_time = microtime(true);

    $string = preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f]/', '', $rsp);

    $xml=(array)simplexml_load_string($string,'SimpleXMLElement',LIBXML_NOCDATA);

    $results=objectToArray($xml);

    $tmp_result = array();
    if( ! isset($results['news']['results']['result'][0]) ){
        $tmp_result = $results['news']['results']['result'];
        unset($results['news']['results']['result']);
        $results['news']['results']['result'][0] = $tmp_result;
    }

    if(!empty($_GET['debug_apiurl']))
    {
        $apiurl_arr[] = array(
            'url' => $url,
            'name' => 'news_api',
            'microtime' => $rtb_end_time - $rtb_start_time
        );

        $api_data[] = $xml;
    }
    return $results;
}

function getWebPagination($searchList, $pageIndex, $pageNumber, $kwd, $http_url_path, $uid= ''){
    $pagination = array ();
    $uid_params = $uid ? "&uid=".$uid : '';
    if($_GET['if']==1){
        $if='&if=1';
    }
    if (!empty ( $searchList )) {
        $pagination ['matchedItemCount'] = $searchList ['total'];
        $pagination ['pageNumber'] = $pageIndex;
        $pagination ['pageCount'] = round ( $pagination ['matchedItemCount'] / $pageNumber );
        $pagination ['pageCount'] = $pagination ['matchedItemCount'] / $pageNumber > $pagination ['pageCount'] ? $pagination ['pageCount'] + 1 : $pagination ['pageCount'];
    }
    $pagination ['html'] = '';
    if ($pagination ['pageNumber'] != 1) {
        $pagination ['html'] .= "<a class=scx472 href='".$http_url_path."?kwd=".urlencode($kwd).$uid_params."&pg=".($pagination ['pageNumber'] - 1).$if."'>Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    $tmp = array ();
    if ($pagination ['pageNumber'] - 5 <= 0) {
        for($i = 1; $i <= 10; $i ++) {
            $tmp [$i] = 1;
        }
    } else {
        for($i = $pagination ['pageNumber'] - 4; $i <= $pagination ['pageNumber'] + 5; $i ++) {
            $tmp [$i] = 1;
        }
    }
    foreach ( $tmp as $k => $v ) {
        if ($k > $pagination ['pageCount']) {
            break;
        }
        if ($k != 0) {
            if( $k == $pagination ['pageNumber'] ){
                $pagination ['html'] .= "<b>".$k."</b>&nbsp;&nbsp;&nbsp;&nbsp;";
            }else{
                $pagination ['html'] .= "<a class=scx472 href='".$http_url_path."?kwd=".urlencode($kwd).$uid_params."&pg=".$k.$if."'>".$k."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            }
        }
    }

    if ($pagination ['pageNumber'] != $pagination ['pageCount']) {
        $pagination ['html'] .= "<a class=scx472 href='".$http_url_path."?kwd=".urlencode($kwd).$uid_params."&pg=".($pagination ['pageNumber'] + 1).$if."'>Next</a>&nbsp;&nbsp;&nbsp;&nbsp;";
    }

    return $pagination;
}


function curl_require( $url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $rsp = curl_exec($ch);
    curl_close($ch);

    return $rsp;
}


//encode
function encrypt($str) {

    global $dictionary;
    $str_ = '';
    if(! empty ( $str )) {
        $len = strlen ( $str );
        for($i = 0; $i < $len; $i ++) {
            $str_ .= isset ( $dictionary [$str [$i]] ) ? $dictionary [$str [$i]] : $str [$i];
        }
    }
    return $str_;
}

/* Decryption Function : Do Not Change */
function decrypt($string, $operation, $key, $expiry) {
    $ckey_length = 4;
    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();

    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}


function highLightKwd($kwd, $string){

    $kwdPieces = array_filter(explode(" ", trim($kwd)));

    foreach ( $kwdPieces as $kp ){
        $string = preg_replace("/\b([a-z]*{$kp}[a-z]*)\b/i","<b>$1</b>",$string);
    }

    return $string;
}


/**
 * @return bool
 */
function isMobile(){
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
        return true;
    }
    if (isset ($_SERVER['HTTP_VIA'])){
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if (isset ($_SERVER['HTTP_USER_AGENT'])){
        $clientkeywords = array (
            'nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
            return true;
        }
    }
    if (isset ($_SERVER['HTTP_ACCEPT'])){
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))){
            return true;
        }
    }
    return false;
}


function _save($arr) {
    $file = '/mnt/tmp/rt_'.date('Ymd').'.log';


    $iipp=$_SERVER["REMOTE_ADDR"];

    file_put_contents($file,$iipp.' >>>> ',FILE_APPEND);
    foreach ($arr as $value) {
        file_put_contents($file, $value.' | ',FILE_APPEND);
    }
    file_put_contents($file,"\n",FILE_APPEND);
}

function _log($a=null,$msg='') {
    global $now;

    $s = microtime(true) - $now;

    global $log_arr;

    array_push($log_arr,$msg.'('.$s.')');

}


function startCSP(){
    header("Content-Security-Policy: default-src 'self' 'unsafe-inline' 'unsafe-eval' http://*.bing.net http://google.com https://*.cloudfront.net http://*.google.com http://*.rtbcdn.com http://pshared.5min.com http://www.googletagmanager.com http://www.google-analytics.com http://*.priceline.com http://syn.5min.com http://uts-api.at.atwola.com http://*.inspectlet.com http://*.infospace.com http://*.googleapis.com http://*.lduhtrp.net http://*.ftjcfx.com http://tacoda.at.atwola.com http://*.5min.com http://*.gstatic.com http://code.jquery.com https://*.rtdock.com http://*.ddc.com https://*.ddc.com http://*.viglink.com https://*.viglink.com http://*.raaz.io https://*.raaz.io;img-src *;");
}


// limit text to certain amount of keywords useful for titles, we use it in the title of the related searches
function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '&hellip';
    }
    return $text;
}

function fillterURL($url){
    $arr_url =parse_url(trim($url));
    return $arr_url['host'];
}


function checkVideoDate($date){
    $unixTime = strtotime($date);
    if (!$unixTime) {
       return '&nbsp;';
    }else{
        return $date;
    }
}


function getShoppingFromBecome($keywords,$num,$start){
    $IpIn = trim(getOneOfIPArr(trim(get_user_ip())));
    $gi = geoip_open(dirname(__FILE__)."/GeoIP.dat",GEOIP_STANDARD);
    $country_name =strtolower(geoip_country_code_by_addr($gi, $IpIn));

    if($country_name=='us'){
        $username = 'browselounge';
        $password = '!Zhdu24SD';
       //$ServiceRootURL="http://us.channel.become.com/livexml/3.1/browselounge-us.portal/query;category-results;product-results/".trim(urlencode($keywords))."?pgn=".$start."&pge=".$num."&img=E&rtype=XML";
    $ServiceRootURL="http://us.channel.become.com/livexml/3.1/browselounge-us.portal/query/".trim(urlencode($keywords))."?pgn=".$start."&pge=".$num."&img=E&rtype=XML";
    
    }elseif($country_name=='uk'||$country_name=='gb'){
        $username ='browselounge';
        $password ='!Zhdu24SD';
        $ServiceRootURL="http://uk.channel.become.eu/livexml/3.1/browselounge-uk.portal/query/".trim(urlencode($keywords))."?pgn=".$start."&pge=".$num."&img=E&rtype=XML";
    
    }else{
        return false;
    }

    $ch = curl_init($ServiceRootURL);
    //echo $ServiceRootURL;
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($ch);

    curl_close($ch);
    $xml_array = (array) simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xml_array = objectToArray($xml_array);
        $products = $xml_array['product-results-module']['product-results']['product'];
        //echo '<pre>';
        //print_r($xml_array['product-results-module']['product-results']['@attributes']['total']);die();
        if (!is_array($products)) {
            return false;
        }
    
        $reults = array();
        $all_product_array = array();
        
        if (isset($products["label"])) {
            $all_product_array[] = $products;
        } else {
            $all_product_array = $products;
        }
    
        $products = $all_product_array;
    
        foreach ($products as $key => $value) {
            $clickurl = $value['offer']['url'];
    
                
            
            if (!isset($value['image']['@attributes'])) {
                $url = $value['image'][1]['@attributes']['source'];
            } else {
                $url = $value['image']['@attributes']['source'];         
            }
    
            $results['list'][$key]['img'] = $url;
            $t_label_array = explode(' ', $value['label']);
            $t_label = substr(join(' ', array_slice($t_label_array, 0, 5)), 0, 35);
            $ads_more = substr($value['offer']['merchant']['label'], 0, 12);
            $results['list'][$key]['title'] = $t_label;
            if($country_name=='us'){
                $currency='$';
            }elseif($country_name=='gb'||$country_name=='uk'){
                $currency='￡';
            }
            $results['list'][$key]['price'] = $currency.$value['offer']['price'];
            $results['list'][$key]['memcache'] = $ads_more;
            $results['list'][$key]['clickurl']=$clickurl;
            
    
            
        }
        //echo $xml_array['product-results-module']['product-results']['@attributes']['total'];
        $results['total']=$xml_array['product-results-module']['product-results']['@attributes']['total'];
        return $results;
        

}


function microtime_float(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function getPageKeyByPageID($pageID){

    $pageID2PageAry = array(
        "index",
        "web",
        "img",
        "vid",
        "news",
        "shopping"
    );
    $key = array_search($pageID, $pageID2PageAry);
    if( $key === false ){
        $key = 1;
    }

    return $key;
}


function getShopping($kwd){
require_once('DisplayUtils.php');  // functions to aid with display of information

error_reporting(E_ALL);  // turn on all errors, warnings and notices for easier debugging

$results = '';

  $endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
  $responseEncoding = 'XML';   // Format of the response

  $safeQuery = urlencode (utf8_encode($kwd));
//  $site  = $_POST['GlobalID'];
	$site='EBAY-US';
  $itemsPerRange = 12;
  $debug = (boolean) $_POST['Debug'];

  $rangeArr = array('High-Range');

  $priceRange = ($priceRangeMax - $priceRangeMin) / 3;  // find price ranges for three tables
  $priceRangeMin =  sprintf("%01.2f", 0.00);
  $priceRangeMax = $priceRangeMin;  // needed for initial setup

    $priceRangeMax = sprintf("%01.2f", ($priceRangeMin + $priceRange));
    $results .=  "<h2>$range : $priceRangeMin ~ $priceRangeMax</h2>\n";
    // Construct the FindItems call
    $apicall = "$endpoint?OPERATION-NAME=findItemsAdvanced"
         . "&SERVICE-VERSION=1.0.0"
         . "&GLOBAL-ID=$site"
         . "&SECURITY-APPNAME=weiminqu-coolfind-PRD-ee805b329-e51801aa" //replace with your app id
         . "&keywords=$safeQuery"
         . "&paginationInput.entriesPerPage=$itemsPerRange"
         . "&sortOrder=BestMatch"
         . "&affiliate.networkId=9"  // fill in your information in next 3 lines
         . "&affiliate.trackingId=1234567890"
         . "&affiliate.customId=456"
         . "&RESPONSE-DATA-FORMAT=$responseEncoding";

    if ($debug) {
      print "GET call = $apicall <br>";  // see GET request generated
    }
    // Load the call and capture the document returned by the Finding API
    $resp = objectToArray(simplexml_load_file($apicall));
	foreach($resp['searchResult']['item'] as $key=>$value ){
	$list[]=array('title'=>$value['title'],
			'image'=>$value['galleryURL'],
			'clickurl'=>$value['viewItemURL'],
			'price'=>$value['sellingStatus']['currentPrice']);
   }
	return $list;
}
