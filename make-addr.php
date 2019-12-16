<?php
/**
 * 根据下载的原始文件，生成dnsmasq的屏蔽广告用途的配置
 *
 * @file make-addr.php
 * @author gently
 * @date 2017.12.31
 *
 *
 */

set_time_limit(600);

error_reporting(0);

if(PHP_SAPI != 'cli'){
	die('nothing.');
}
require('./lib/addressMaker.class.php');
$arr_blacklist = require('./lib/black_domain_list.php');
$arr_whitelist = require('./lib/white_domain_list.php');


$arr_result = array();


$easylist = file_get_contents('./origin-files/base-src-easylist.txt');
$arr_result = array_merge_recursive($arr_result, addressMaker::get_domain_from_easylist($easylist));

$hosts = file_get_contents('./origin-files/base-src-hosts.txt');
$arr_result = array_merge_recursive($arr_result, addressMaker::get_domain_list($hosts));

echo 'Written file size:';
echo addressMaker::write_to_conf($arr_result, './adblock-for-dnsmasq.conf', 'q-filter.conf');


