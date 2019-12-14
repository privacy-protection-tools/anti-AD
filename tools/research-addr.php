<?php
/**
 * 重新整理列表，分离出basic，full，剔除失效域名
 *
 * @file research-addr.php
 * @author gently
 * @date 2019.12.14
 *
 */

set_time_limit(600);

error_reporting(0);

if(PHP_SAPI != 'cli'){
    die('nothing.');
}
require dirname(__DIR__) . '/lib/utils.class.php';

define('ORIGIN_DIR', dirname(__DIR__) . '/origin-files/');
define('DIST_DIR', dirname(__DIR__) . '/dist/');
define('LIB_DIR', dirname(__DIR__) . '/lib/');
define('SRC_FILE', dirname(__DIR__) . '/adblock-for-dnsmasq.conf');

$arr_dead_horse = array();
$arr_china_list = array();

$dead_horse_files = glob(ORIGIN_DIR . 'dead-horse_*');

foreach($dead_horse_files as $f){
    $arr_content = require_once $f;
    $arr_dead_horse = utils::array_merge_plus($arr_dead_horse, $arr_content);
}

$china_list_files = glob(ORIGIN_DIR . 'china-list_*');
foreach($china_list_files as $f){
    $arr_content = require_once $f;
    $arr_china_list = array_merge($arr_china_list, $arr_content);
}

if(count($arr_china_list) <= 0 && count($arr_dead_horse) <= 0){
    die('empty filter list');
}

//黑名单在basic中也是必须的
$black_list = require LIB_DIR . '/black_domain_list.php';

$src_fp = fopen(SRC_FILE, 'r');
$basic_fp = fopen(DIST_DIR . '/anti-ad-basic.conf', 'w');
$full_fp = fopen(DIST_DIR . '/anti-ad-full.conf', 'w');
$write_len = fwrite($basic_fp, '#TIME=' . date('YmdHis') . "\n");
$write_len += fwrite($basic_fp, '#URL=https://github.com/gentlyxu/anti-AD' . "\n");
$write_len = fwrite($full_fp, '#TIME=' . date('YmdHis') . "\n");
$write_len += fwrite($full_fp, '#URL=https://github.com/gentlyxu/anti-AD' . "\n");

while(!feof($src_fp)){
    $row = fgets($src_fp, 512);
    if(empty($row)){
        continue;
    }

    if(preg_match('/^address=\/(.+)?\/$/', $row, $matches)){
        if(array_key_exists($matches[1], $arr_dead_horse)){
            if(isset($arr_dead_horse[$matches[1]]['dead']) && $arr_dead_horse[$matches[1]]['dead'] > 2){
                continue;
            }elseif(isset($arr_dead_horse[$matches[1]]['empty']) && $arr_dead_horse[$matches[1]]['empty'] > 3){
                continue;
            }elseif(isset($arr_dead_horse[$matches[1]]['problem']) && $arr_dead_horse[$matches[1]]['problem'] > 3){
                continue;
            }
        }

        fwrite($full_fp, "address=/{$matches[1]}/\n");
        if(array_key_exists($matches[1], $arr_china_list) || array_key_exists($matches[1], $black_list)){
            fwrite($basic_fp, "address=/{$matches[1]}/\n");
        }
    }
}

//删除之前验证工具生成的中间结果
foreach(array_merge($china_list_files, $dead_horse_files) as $f){
//    unlink($f);
}
