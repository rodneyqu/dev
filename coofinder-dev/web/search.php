<?php
require_once dirname(dirname(__FILE__)).'/lib/init.php';
//CSP
startCSP();

$title_kwd = isset($kwd) && $kwd ? $kwd." - " : '';
$smarty->assign('title_kwd', $title_kwd);
$rss_url = isset($_GET['rss']) ? strtolower(trim($_GET['rss'])) : $_REQUEST['rss'];
    if ($rss_url) {
      setcookie("rss", $rss_url);
      $rss = $rss_url;
    }else{
      $rss = $_COOKIE['rss'];
    }
    if($rss==''){
        $rss='b';
    }
    $smarty->assign('rss',$rss);

if( $searchType == 'web' ){  // web
    $searchList=getResultsFromDDC($kwd,50,$pageIndex);
    $searchListArr= array_chunk($searchList['results'],10,true);
    $smarty->assign('searchList', $searchListArr[$pageIndex-1]);
    $totalRow = $searchList['total'];

    // pagination
    $pagination = getWebPagination($searchList,$pageIndex, 5, $kwd, $http_url_path, $url_uid);
    //shopping

    // update at 2016/1/11: mv to ajax get_shopping
   /* $shoppingResults=getShoppingFromBecome($kwd,6,$pageIndex);
   
    $shoppingResults_content=$shoppingResults['list'];
    $smarty->assign('shoppingResults', $shoppingResults_content);*/

    $smarty->assign('pagination', $pagination);
}elseif( $searchType == 'img' ){  // img
    //$imagesList = getImagesFromYahooBossAPI($kwd , 35 , $pageIndex);
    $imagesList= getImagesFromBingApi($kwd,35,$pageIndex-1);
    //$totalRow = $imagesList['images']['@attributes']['totalresults'];
    $smarty->assign('imagesList', $imagesList);
    $totalRow = 0;

}elseif( $searchType == 'vid' ){  // vid
    //$videosList = getVideosFromYahooBossAPI($kwd,20, $pageIndex);
    $videosList = getVideosFromBingApi($kwd,20, $pageIndex);
    
    $smarty->assign('videosList', $videosList);
}elseif( $searchType == 'news' ){  // news
    //$newsList = getNewsFromYahooBossAPI($kwd,20, $pageIndex);
    $newsList = getNewsFromBingApi($kwd,20, $pageIndex);
    

    

    $totalRow = 20;
    $smarty->assign('newsList', $newsList);
}elseif($searchType=='shopping'){ // shopping
   /* $product_num='24';
    
    $startIndex = empty ( $_REQUEST ['page'] ) ? 1 : $_REQUEST ['page'];
    if($startIndex<1)$startIndex=1;

    $shoppingResults=getShoppingFromBecome($kwd,$product_num,$startIndex);
    if($shoppingResults==false){
        $noShoppingResults='Sorry we don\'t have an products for that search term - please try searching for something else.';
        $smarty->assign('noShoppingResults',$noShoppingResults);
    }else{
        $shoppingResults_content=$shoppingResults['list'];
        $smarty->assign('shoppingResults', $shoppingResults_content);
    }*/
    
}

$smarty->assign("totalRow", $totalRow);



if( $isMobile ){
    if( $searchType == 'web' ){
        $smarty->display('m-web.tpl');
    }elseif( $searchType == 'img' ){
        $smarty->display('m-images.tpl');
    }elseif( $searchType == 'vid' ){
        $smarty->display('m-video.tpl');
    }elseif ( $searchType == 'news' ){
        $smarty->display('m-news.tpl');
    }elseif ( $searchType == 'shopping' ){
        $smarty->display('m-shopping.tpl');
    }
}else{
    if( $searchType == 'web' ){
        $smarty->display('web.tpl');
    }elseif( $searchType == 'img' ){
        $smarty->display('images.tpl');
    }elseif( $searchType == 'vid' ){
        $smarty->display('video.tpl');
    }elseif ( $searchType == 'news' ){
        $smarty->display('news.tpl');
    }elseif($searchType=='shopping'){
        $smarty->display('shopping.tpl');
    }
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