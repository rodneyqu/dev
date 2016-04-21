<?php
include_once dirname(__FILE__).'/../lib/common.php';
$kwd = isset($_POST['kwd']) && $_POST['kwd'] ? urldecode($_POST['kwd']) : '';
$num = isset($_POST['num']) && is_numeric($_POST['num']) ? $_POST['num'] : 35;
$index = isset($_POST['ind']) && $_POST['ind'] ? $_POST['ind'] : 0;
$isMobile = isset($_POST['mob']) && $_POST['mob'] ? $_POST['mob'] : 0;

$imagesList = getImagesFromBingApi($kwd, $num ,$index+1);

$html = "";
if( isset($imagesList) && ! $isMobile){
    foreach ( $imagesList as $imgitem ){
        $html .= '<div style="float: left;margin: 4px;" class="img_div" data-w="'.$imgitem ['Thumbnail']['Width'].'" data-h="'.$imgitem ['Thumbnail']['Height'].'">';
        $html .= '<a href="'.$imgitem ['SourceUrl'].'" target="_blank">';
        $thumbnailurl = strpos($imgitem ['Thumbnail']['MediaUrl'], 'https:') ? $imgitem ['Thumbnail']['MediaUrl'] : str_replace('http', 'https', $imgitem ['Thumbnail']['MediaUrl']);
        $html .= '<img  src="'.$thumbnailurl.'" style="height: 100%;width: 100%;">';
        $html .= '</a></div>';
    }
}elseif ( isset($imagesList) && $isMobile ){
    foreach ( $imagesList as $imgitem ){
        $html .= '<div class="ir_items" data-w="'.$imgitem ['Thumbnail']['Width'].'" data-h="'.$imgitem ['Thumbnail']['Height'].'" style="height: 89px; width: 133px; display: block;">';
        $html .= '<a href="'.$imgitem ['SourceUrl'].'" target="_blank">';
        $thumbnailurl = strpos($imgitem ['Thumbnail']['MediaUrl'], 'https:') ? $imgitem ['Thumbnail']['MediaUrl'] : str_replace('http', 'https', $imgitem ['Thumbnail']['MediaUrl']);
        $html .= '<img src="'.$thumbnailurl.'">';
        $html .= '</a></div>';
    }
}



echo $html;
die;