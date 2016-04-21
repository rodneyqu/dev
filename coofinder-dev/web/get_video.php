<?php
include_once dirname(__FILE__).'/../lib/common.php';

$kwd = isset($_POST['kwd']) && $_POST['kwd'] ? urldecode($_POST['kwd']) : '';
$num = isset($_POST['num']) && is_numeric($_POST['num']) ? $_POST['num'] : 20;
$index = isset($_POST['ind']) && $_POST['ind'] ? $_POST['ind'] : 0;
$isMobile = isset($_POST['mob']) && $_POST['mob'] ? $_POST['mob'] : 0;


$videosList = getVideosFromBingApi($kwd, $num ,$index*10+1);

$html = "";
// pc
if( isset($videosList) && ! $isMobile){
    foreach ( $videosList as $viditem ){
        $html .='<div class="vid_content_more vr vres" >';
        $html .='<a href="'.$viditem ['MediaUrl'].'" class="ng" title="" data-rurl="#" data="#" target="_blank"  style="text-decoration:none;">';
                 $html .='<div class="pos-bx res vg v-media" data-hvb="#" data-movie="#" >';
                          $html .='<div class="vthm fill" >';
                          $thumbnailurl=strpos($viditem ['Thumbnail']['MediaUrl'], 'https:') ? $viditem ['Thumbnail']['MediaUrl'] : str_replace('http', 'https', $viditem ['Thumbnail']['MediaUrl']);
                          $html .='<img src="'.$thumbnailurl.'"  height="100%" width="100%" class="thm">';
                               $html .=' <div class="stack grad" >';
                                   $html .=' <div class="bt inf ta-r" >';
                                       $html .=' <span class="v-preview"><s></s></span>';
                                        $html .='<span class="play-cont"><s class="splay"></s></span>';
                                        $html .='<span class="v-time">'.gmdate("H:i:s", $viditem ['RunTime']).'</span>';
                           $html .='         </div>';
                       $html .='         </div>';
                   $html .='         </div>';
                $html .='        </div>';
               $html .='         <div class="v-meta bx-bb" >';
             $html .='               <h3>'.$viditem ['Title'].'</h3>';
            
           $html .='                 <cite class="url">'.fillterURL($viditem['MediaUrl']).'</cite>';
           $html .='             </div>';
          $html .='          </a>';
         $html .='</div>';
    }
    // mobile
}elseif ( isset($videosList) && $isMobile ){
    foreach ( $videosList as $viditem ){
              $html .='<div class="ir_items" data-w="162" data-h="146" style="height: 200px; width: 162px; display: block;block;background-color:#F1F1F1;">';
                                          $html .='<a href="'.$viditem ['MediaUrl'].'" target="_blank">';
                                                $thumbnailurl = strpos($viditem ['Thumbnail']['MediaUrl'], 'https:') ? $viditem ['Thumbnail']['MediaUrl'] : str_replace('http', 'https', $viditem ['Thumbnail']['MediaUrl']);
                                                $html .='<div style="height:126px;position:relative;"><img src="'.$thumbnailurl.'">';
                                                $html .='<div class="bt inf ta-r"  style="position: absolute;bottom: 0;right:0;">';
                                        $html .='<span class="v-preview"><s></s></span>';
                                       $html .='<span class="play-cont"><s class="splay"></s></span>';
                                     $html .='<span class="v-time" style="color:#FFF">'.gmdate("H:i:s", $viditem ['RunTime']).'</span>';
                                  $html .='</div>';
                                             $html .='</div>';
                                           $html .='<div class="title_vid">'.$viditem ['Title'].'</div>';
                                        
                                       $html .='<div class="url">'.fillterURL($viditem['MediaUrl']).'</div>';
                                     $html .='</a>';
                                  $html .='</div>';
        
    }
}




echo $html;
die;