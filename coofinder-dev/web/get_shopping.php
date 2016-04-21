<?php
require_once dirname(dirname(__FILE__)).'/lib/init.php';
$kwd = isset($_POST['kwd']) && $_POST['kwd'] ? urldecode($_POST['kwd']) : '';
$num = isset($_POST['num']) && is_numeric($_POST['num']) ? $_POST['num'] : 6;
$index = isset($_POST['ind']) && $_POST['ind'] ? $_POST['ind'] : 0;
$isMobile = isset($_POST['mob']) && $_POST['mob'] ? $_POST['mob'] : 0;
$isWeb = isset($_POST['web']) && $_POST['web'] ? $_POST['web'] : 0;
$uid = isset($_REQUEST['ssp']) ? str_replace(' ', '+', urldecode($_REQUEST['ssp'])) : '';
$decryptedUID = decrypt($uid, OPERATION, KEY, 0);
$TypeTag = getPV("typetag",$decryptedUID);
$TypeTag = $TypeTag ? $TypeTag : DEFAULT_TYPE_TAGE;

$shoppingList = getShoppingFromBecome($kwd, $num ,$index);

$html = "";

if ( isset($shoppingList['list']) && $isMobile ){
    foreach ( $shoppingList['list'] as $key=>$shoppingitem ){
              $html .='<div class="ir_items" data-w="162" data-h="146" style="height: 200px; width: 162px; display: block;block;background-color:#F1F1F1;">';
                                          $shoppingitem ['clickurl'] .= "&campID=".$campID."&linkID=".$TypeTag;
                                          $html .='<a href="'.$shoppingitem['clickurl'].'" target="_blank">';
                                                $html .='<div style="height:126px;position:relative;"><img src="'.$shoppingitem['img'].'">';
                                               
                                             $html .='</div>';
                                           $html .='<div class="title_vid">'.$shoppingitem ['title'].'</div>';
                                        $html .='<div class="v-age">$'.$shoppingitem ['price'].'</div>';
                                       $html .='<div class="url">'.$shoppingitem['memcache'].'</div>';
                                     $html .='</a>';
                                  $html .='</div>';
        
    }
}elseif( isset($shoppingList['list']) && $isWeb ){

    foreach ( $shoppingList['list'] as &$shoppingitem ){
        $shoppingitem ['clickurl'] .= "&campID=".$campID."&linkID=".$TypeTag;
    }

    $smarty->assign('shoppingResults', $shoppingList['list']);
    $html = $smarty->fetch("web-shopping.tpl");
}else{
  if(count($shoppingList['list'])>0){
    foreach ( $shoppingList['list'] as $key=>$shoppingitem ){
        $shoppingitem ['clickurl'] .= "&campID=".$campID."&linkID=".$TypeTag;
         $html .='<div class="vid_content_more vr vres" >';
          $html .='<a href="'.$shoppingitem ['clickurl'].'" class="ng" title="" data-rurl="#" data="#" target="_blank"  style="text-decoration:none;border:1px solid #F1F1F1">';
                   $html .='<div class="pos-bx res vg v-media" data-hvb="#" data-movie="#" >';
                            $html .='<div class="vthm fill" >';
                            
                            $html .='<img src="'.$shoppingitem['img'].'" alt="" style="margin-top:-18px;" height="131.25%" width="100%" class="thm">';
                     $html .='         </div>';
                  $html .='        </div>';
                 $html .='         <div class="v-meta bx-bb" >';
               $html .='               <h3>'.$shoppingitem ['title'].'</h3>';
              $html .='                <div class="v-age">'.$shoppingitem ['price'].'</div>';
             $html .='                 <cite class="url">'.$shoppingitem['memcache'].'</cite>';
             $html .='             </div>';
            $html .='          </a>';
           $html .='</div>';

    }
  }

}

echo $html;
die;
