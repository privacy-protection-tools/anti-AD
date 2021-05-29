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
define('ORIG_DIR', ROOT_DIR . 'origin-files/');
set_time_limit(600);
error_reporting(0);

if(PHP_SAPI != 'cli'){
    die('nothing.');
}

date_default_timezone_set('Asia/Shanghai');
$ARR_BLACKLIST = require ROOT_DIR . 'lib/black_domain_list.php';
$ARR_WHITELIST = require ROOT_DIR . 'lib/white_domain_list.php';
require ROOT_DIR . 'lib/writerFormat.class.php';
require ROOT_DIR . 'lib/addressMaker.class.php';

$arr_input_cache = $arr_whitelist_cache = $arr_output = array();

$reflect = new ReflectionClass('writerFormat');
$formatterList = $reflect->getConstants();
foreach($formatterList as $name => $formatObj){
    if(!is_array($formatObj['src'])){
        continue;
    }
    $arr_src_domains = array();
    $arr_tmp_whitelist = array();//单次的白名单列表
    if(is_array($formatObj['whitelist_attached']) && (count($formatObj['whitelist_attached']) > 0)){
        foreach($formatObj['whitelist_attached'] as $white_file => $white_attr){
            if(!array_key_exists("{$white_file}_{$white_attr['merge_mode']}", $arr_whitelist_cache)){
                $arr_attached = file(ORIG_DIR . $white_file, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
                $arr_attached = array_fill_keys($arr_attached, $white_attr['merge_mode']);
                $arr_whitelist_cache["{$white_file}_{$white_attr['merge_mode']}"] = $arr_attached;
            }

            $arr_tmp_whitelist = array_merge(
                $arr_tmp_whitelist,
                $arr_whitelist_cache["{$white_file}_{$white_attr['merge_mode']}"]
            );
        }
    }

    $arr_tmp_whitelist = array_merge($arr_tmp_whitelist, $ARR_WHITELIST);

    foreach($formatObj['src'] as $src_file => $src_attr){
        if(!array_key_exists($src_file, $arr_input_cache)){
            $src_content = file_get_contents(ORIG_DIR . $src_file);
            if($src_attr['type'] === 'easylist'){
                $src_content = addressMaker::get_domain_from_easylist($src_content, $src_attr['strict_mode'], $arr_tmp_whitelist);
            }elseif($src_attr['type'] === 'hosts'){
                $src_content = addressMaker::get_domain_list($src_content, $src_attr['strict_mode'], $arr_tmp_whitelist);
            }
            $arr_input_cache[$src_file] = $src_content;
        }
        $arr_src_domains = array_merge_recursive($arr_src_domains, $arr_input_cache[$src_file]);
    }

    $arr_src_domains = array_merge_recursive($arr_src_domains, $ARR_BLACKLIST);
    ksort($arr_src_domains);

    $arr_output[] = '[' . $name . ']:' . addressMaker::write_to_file($arr_src_domains, $formatObj, $arr_tmp_whitelist);
}

echo join(',', $arr_output);
