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
$arr_blacklist = require('./black_domain_list.php');
$arr_whitelist = require('./white_domain_list.php');


$arr_result = array();


$easylist1 = file_get_contents('./origin-files/easylistchina+easylist.txt');
$arr_result = array_merge_recursive($arr_result, addressMaker::get_domain_from_easylist($easylist1));

$easylist2 = file_get_contents('./origin-files/cjx-annoyance.txt');
$arr_result = array_merge_recursive($arr_result, addressMaker::get_domain_from_easylist($easylist2));

$easylist3 = file_get_contents('./origin-files/fanboy-annoyance.txt');
$arr_result = array_merge_recursive($arr_result, addressMaker::get_domain_from_easylist($easylist3));


$host1 = file_get_contents('./origin-files/hosts1');
$arr_result = array_merge_recursive($arr_result, addressMaker::get_domain_list($host1));

// $host2 = makeAddr::http_get('http://www.malwaredomainlist.com/hostslist/hosts.txt');
$host2 = file_get_contents('./origin-files/hosts2');
$arr_result = array_merge_recursive($arr_result, addressMaker::get_domain_list($host2));

$host3 = file_get_contents('./origin-files/hosts3');
$arr_result = array_merge_recursive($arr_result, addressMaker::get_domain_list($host3));

$arr_result = array_merge_recursive($arr_result, $arr_blacklist);

echo 'Written file size:';
echo addressMaker::write_to_conf($arr_result, './adblock-for-dnsmasq.conf', 'q-filter.conf');


