<?php
	$path = dirname(__FILE__) . '/../etc/';
	include_once $path . 'config.php';
	
	
	$memcache_center = new Memcache();
	$memcache_status = $memcache_center->connect(MEMCACHE_HOST, MEMCACHE_PORT);
	//if(!$memcache_status) {send626mail('626apps warning', '<br>memcache:'.MEMCACHE_HOST.':'.MEMCACHE_PORT); return false;}
	
	$memcache_local = new Memcache();
	$memcache_status = $memcache_local->connect(MEMCACHE_LOCAL_HOST, MEMCACHE_LOCAL_PORT);
	//if(!$memcache_status) {send626mail('626apps warning', '<br>memcache:'.MEMCACHE_LOCAL_HOST.':'.MEMCACHE_LOCAL_PORT); return false;}
	
	
	$local_suffix = '_local';

	$key_index = $memcache_center->get('safesearch_key_index_list');

	set_config_to_local_memcache($memcache_center, $memcache_local, array(
		'key' => $key_index,
		'local_suffix' => $local_suffix,
		'debug' => false
	));


	$memcache_center->close();
	$memcache_local->close();




	function set_config_to_local_memcache(&$memcache_center, &$memcache_local, $config) {
		$keys = $config['key'];
		$local_suffix = $config['local_suffix'];
		$debug = $config['debug'];

		$center_config = $memcache_center->get($keys);
		$number = count($keys);

		foreach ($keys as &$key) {
			$local_key = $key . $local_suffix;
			$memcache_local->set($local_key, $center_config[$key], MEMCACHE_COMPRESSED, 2592000);
			echo date('Y-m-d H:i:s') . ' - ' . $key . ' done.' . PHP_EOL;
			
			if ($debug) {
				print_r($memcache_local->get($local_key));
			}
		}
	}
?>
