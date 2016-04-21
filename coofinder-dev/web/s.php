<?php
require_once dirname(dirname(__FILE__)).'/lib/init.php';


if( $searchType == "web" ){

   /* $searchList=getResultsFromDDC($kwd,50,$pageIndex);
    $searchListArr= array_chunk($searchList['results'],10,true);
    $smarty->assign('searchList', $searchListArr[$pageIndex-1]);*/
    $smarty->display('web.tpl');
}elseif ( $searchType == "img" ){
    $imagesList= getImagesFromBingApi($kwd,35,$pageIndex-1);
    $smarty->assign('imagesList', $imagesList);
    $smarty->display('images.tpl');
}elseif ( $searchType == "vid" ){
    $videosList = getVideosFromBingApi($kwd,20, $pageIndex);
    
    $smarty->assign('videosList', $videosList);
    $smarty->display('video.tpl');
}elseif ( $searchType == "news" ){
    $newsList = getNewsFromBingApi($kwd,20, $pageIndex);
    $totalRow = 20;
    $smarty->assign('newsList', $newsList);
    $smarty->display('news.tpl');
}elseif ( $searchType == "shopping" ){
    $shoppingList=getShopping(trim($kwd));
	$smarty->assign('shoppingList', $shoppingList);
	
$smarty->display('shopping.tpl');
}elseif ( $searchType == "game" ){
    $smarty->display('game.tpl');
}


if( isset($_GET['debug_apiurl']) && $_GET['debug_apiurl'] == 1 ){

    foreach ($apiurl_arr as $api){
        echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='".$api['url']."' target='_blank'>".$api['name']."</a> | time: ".$api ['microtime']."<br/><br/>";
    }
    echo "&nbsp;&nbsp;&nbsp;&nbsp;total_time:".($end - $now)."<br><br><br>";
    foreach ( $api_data as $a ){
        echo "<pre>";
        print_r($a);
        echo "</pre>";
        echo "<br>";
    }
}
