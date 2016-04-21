<?php

error_reporting(E_ALL ^ E_NOTICE);
session_start();

// include file
require_once dirname(__FILE__).'/geoip.inc';
require_once dirname(__FILE__).'/oauth.php';
require_once dirname(__FILE__).'/common.php';
require_once dirname(__FILE__).'/smarty/Smarty.class.php';
require_once dirname(dirname(__FILE__)).'/etc/const.php';
require_once dirname(dirname(__FILE__)).'/etc/config.php';


//init smarty
$smarty = new Smarty();
$smarty->setTemplateDir(dirname(dirname(__FILE__)).'/templates');
$smarty->setCompileDir(dirname(dirname(__FILE__)).'/templates_c');
$smarty->setCacheDir(dirname(dirname(__FILE__)).'/cache');
$smarty->left_delimiter = '<!--{';
$smarty->right_delimiter = '}-->';

$searchType = isset($_GET['t']) && in_array(trim($_GET['t']), $defaultType) ? trim($_GET['t']) : 'web';
$smarty->assign("searchType", $searchType);

// set keywords
$kwd = isset($_GET['q']) ? $_GET['q'] : '';
$smarty->assign('kwd', $kwd);


$http = 'http://';
if( isset($_SERVER['HTTPS']) || $_SERVER['SERVER_PORT'] == 443 ){
    $http = 'https://';
}elseif( (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') || ( isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443 ) ){
    $http = 'https://';
}
$http_url_path = parse_url($_SERVER['REQUEST_URI']);
$http_url_path = $http_url_path['path'];
$http_url = $http.$_SERVER['HTTP_HOST'].$http_url_path;
$smarty->assign('http', $http);
$smarty->assign('http_url', $http_url);


$pageIndex = 1;


