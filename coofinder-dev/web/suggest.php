<?php
/* Pre-requisite: Download the required PHP OAuth class from http://oauth.googlecode.com/svn/code/php/OAuth.php. This is used below */
    require("lib/oauth.php");
    $cc_key  = "dj0yJmk9cW03b0JqbmRUdHF1JmQ9WVdrOWMwUk5VMWhrTkdVbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1hNw--";
    $cc_secret = "6e55a625104d10f29979efee874bcd95cf36dc98";
    $url = "https://yboss.yahooapis.com/ysearch/related";
    $args = array();
    $args["q"] = $_GET['q'];
    $args["format"] = "json";
	$args["count"] = 10;
 
    $consumer = new OAuthConsumer($cc_key, $cc_secret);
    $request = OAuthRequest::from_consumer_and_token($consumer, NULL,"GET", $url, $args);
    $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
    $url = sprintf("%s?%s", $url, OAuthUtil::build_http_query($args));
    $ch = curl_init();
    $headers = array($request->to_header());
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $rsp = curl_exec($ch);
    $results = json_decode($rsp);

	$suggestions = $results->bossresponse->related->results;
	
	echo "[\"".$args["q"]. "\",[";
	$i = count($suggestions);
	$l = 1;
	foreach($suggestions as $suggestion){
		
		if ($l < $i)
			echo "\"".$suggestion->suggestion."\",";
		else 
			echo "\"".$suggestion->suggestion."\"";
		$l++;
 
   //do something with it
	}
	echo "]]";
	

?>