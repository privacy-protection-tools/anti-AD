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

define('ROOT_DIR', __DIR__ . '/');
set_time_limit(600);
error_reporting(0);

if(PHP_SAPI != 'cli'){
	die('nothing.');
}

require ROOT_DIR . 'lib/writerFormat.class.php';
require ROOT_DIR . 'lib/addressMaker.class.php';
$arr_blacklist = require ROOT_DIR . 'lib/black_domain_list.php';
$arr_whitelist = require ROOT_DIR . 'lib/white_domain_list.php';

$arr_result = array();
$easylist = file_get_contents('./origin-files/base-src-easylist.txt');
$arr_result = array_merge_recursive($arr_result, addressMaker::get_domain_from_easylist($easylist));

$hosts = file_get_contents('./origin-files/base-src-hosts.txt');
$arr_result = array_merge_recursive($arr_result, addressMaker::get_domain_list($hosts));

$arr_result = array_merge_recursive($arr_result, $arr_blacklist);

echo 'Written file size:';
echo addressMaker::write_to_conf($arr_result, writerFormat::EASYLIST);


