<?php
	$path = dirname(__FILE__) . '/../../etc/';
	include_once $path . 'config.php';

	$memcache = new Memcache();
	$memcache_status = $memcache->connect(MEMCACHE_LOCAL_HOST, MEMCACHE_LOCAL_PORT);

	echo $memcache->get('safesearch_site_configure_local');

	$memcache->close();
?>