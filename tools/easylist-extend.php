<?php
/**
 * easylist extend
 *
 * @file easylist-extend.php
 * @date 2019-12-24
 * @author gently
 *
 */
set_time_limit(0);

error_reporting(7);

define('START_TIME', microtime(true));
define('ROOT_DIR', dirname(__DIR__). '/');
define('LIB_DIR', ROOT_DIR . 'lib/');

$black_domain_list = require_once LIB_DIR . 'black_domain_list.php';
require_once LIB_DIR . 'addressMaker.class.php';
define('WILDCARD_SRC', ROOT_DIR . 'origin-files/wildcard-src-easylist.txt');
define('WHITERULE_SRC', ROOT_DIR . 'origin-files/whiterule-src-easylist.txt');

$ARR_MERGED_WILD_LIST = array(
    'ad*.udn.com' => null,
    'cnt*rambler.ru' => null,
    '*.mgr.consensu.org' => null,
    'vs*.gzcu.u3.ucweb.com' => null,
    'ad*.goforandroid.com' => null,
    'bs*.9669.cn' => null,
    '*dnserror*.wo.com.cn' => null,
    '*mistat*.xiaomi.com' => null,
    'affrh20*.com' => null,
    'gsp*.baidu.com' => null,
    'assoc-amazon.*' => null,
    'clkservice*.youdao.com' => null,
    'dsp*.youdao.com' => null,
    'ad*.sina.com.cn' => null,
    'sax*.sina.com.cn' => null,
    'pussl*.com' => null,
    'putrr*.com' => null,
    'ad.*.360.cn' => null,
    't*.a.market.xiaomi.com' => null,
    'ad*.bigmir.net' => null,
    'log*.molitv.cn' => null,
    'adm*.autoimg.cn' => null,
    'cloudservice*.kingsoft-office-service.com' => null,
    'gg*.51cto.com' => null,
    'log.*.hunantv.com' => null,
    '*.log.hunantv.com' => null,
    'iflyad.*.openstorage.cn' => null,
    '*customstat*.51togic.com' => null,
    'appcloud*.zhihu.com' => null,
    'sf*-ttcdn-tos.pstatp.com' => null,
    'ad*.molitv.cn' => null,
    'ads*-adnow.com' => null,
    'aeros*.tk' => null,
    'analyzer*.fc2.com' => null,
    'admicro*.vcmedia.vn' => null,
    'xn--xhq9mt12cf5v.*' => null,
    'freecontent.*' => null,
    'hostingcloud.*' => null,
    'jshosting.*' => null,
    'flightzy.*' => null,
    'sunnimiq*.cf' => null,

);

$ARR_REGEX_LIST = array(
    '/^01daa\.[a-z]+\.com$/' => null,
    '/^9377[a-z]{2}\.com$/' => null,
//    '/^[1-3]\.[0-9a-z\.\-]+\.(com|cn|net|org)$/' => null,
//    '/^a1\.[0-9a-z\.]+\.(com|cn|org|net|me)$/' => null,
    '/^ad([0-9]|m|s)?\./' => null,
    '/^affiliat(es|ion|e)\./' => null,
    '/^afgr[0-9]{1,2}\.com$/' => null,
    '/^analytics(\-|\.)/' => null,
    '/^counter(\-|\.)/' => null,
    '/^pixels?\./' => null,
    '/^syma[a-z]\.cn$/' => null,
    '/^widgets?\./' => null,
    '/^(web)?stats?\./' => null,
    '/^track(er|ing)?\./' => null,
    '/^tongji\./' => null,
    '/^toolbar\./' => null,
    '/^adservice\.google\./' => null,
);

$ARR_WHITE_RULE_LIST = array(
    '@@||github.com^',
    '@@||tracker.ipv6.scau.edu.cn^',
    '@@||tracker.openbittorrent.com^',
    '@@||tracker.chdbits.org^',
    '@@||tracker.m-team.cc^',
    '@@||tracker.keepfrds.com^',
    '@@||tracker.hdcmct.org^',
    '@@||tracker.fastdownload.xyz^',
    '@@||tracker.bt4g.com^',
    '@@||tracker.publictorrent.net^',
);

if(PHP_SAPI != 'cli'){
    die('nothing.');
}

$src_file = '';
try{
    $file = $argv[1];
    $src_file = ROOT_DIR . $file;
}catch(Exception $e){
    echo "get args failed.", $e->getMessage(), "\n";
    die(0);
}

if(empty($src_file) || !is_file($src_file)){
    echo 'src_file:', $src_file, ' is not found.';
    die(0);
}

if(!is_file(WILDCARD_SRC) || !is_file(WHITERULE_SRC)){
    echo 'key file is not found.';
    die(0);
}

$src_fp = fopen($src_file, 'r');
$wild_fp = fopen(WILDCARD_SRC, 'r');
$new_fp = fopen($src_file . '.txt', 'w');

$wrote_wild = array();
$arr_wild_src = array();

while(!feof($wild_fp)){
    $wild_row = fgets($wild_fp, 512);
    if(empty($wild_row)){
        continue;
    }
    if(!preg_match('/^\|\|?([\w\-\.\*]+?)\^(\$([^=]+?,)?(image|third-party|script)(,[^=]+)?)?$/', $wild_row, $matches)){
        continue;
    }
    $arr_wild_src[$matches[1]] = $wild_row;
}
fclose($wild_fp);

$arr_wild_src = array_merge($arr_wild_src, $ARR_MERGED_WILD_LIST);

while(!feof($src_fp)){
    $row = fgets($src_fp, 512);
    if(empty($row)){
        continue;
    }

    if(!preg_match('/^\|.+?/', $row)){
        fwrite($new_fp, $row);
        continue;
    }

    $matched = false;
    foreach($ARR_REGEX_LIST as $regex_str => $regex_row){
        if(preg_match($regex_str, substr(trim($row), 2, -1))){
            $matched = true;
            if(!array_key_exists($regex_str, $wrote_wild)){
                fwrite($new_fp, "${regex_str}\n");
                $wrote_wild[$regex_str] = 1;
            }
        }
    }

    if($matched){
        continue;
    }

    foreach ($arr_wild_src as $core_str => $wild_row){
        $match_rule = str_replace('*', '.*', $core_str);
        if(preg_match("/\|${match_rule}/", $row)){
            if(!array_key_exists($core_str, $wrote_wild)){
                fwrite($new_fp, "||${core_str}^\n");
                $wrote_wild[$core_str] = 1;
            }
            $matched = true;
            break;
        }
    }

    if($matched){
        continue;
    }
    fwrite($new_fp, $row);
}

//按需写入白名单规则
$wrote_whitelist = array();
$whiterule = file(WHITERULE_SRC, FILE_SKIP_EMPTY_LINES);
$ARR_WHITE_RULE_LIST = array_merge($ARR_WHITE_RULE_LIST, $whiterule);
foreach ($ARR_WHITE_RULE_LIST as $row){
    if(empty($row) || $row{0} !== '@' || $row{1} !== '@'){
        continue;
    }
    $matches = array();
    if(!preg_match('/@@\|\|([0-9a-z\.\-\*]+?)\^/', $row, $matches)){
        continue;
    }
    foreach($wrote_wild as $core_str => $val){
        if($core_str{0} === '/'){
            $match_rule = $core_str;
        }else{
            $match_rule = str_replace('*', '.*', $core_str);
            $match_rule = "/${match_rule}/";
        }
        if(preg_match($match_rule, $matches[1])) {
            $domain = addressMaker::extract_main_domain($matches[1]); //@TODO 注意！这里假设白名单域名无通配符
            if(array_key_exists($domain, $black_domain_list) ||
                (is_array($black_domain_list[$domain]) && in_array($matches[1], $black_domain_list[$domain]))
            ){
                continue;
            }
            if(array_key_exists($matches[1], $wrote_whitelist)){
                continue;
            }
            $wrote_whitelist[$matches[1]] = null;
            fwrite($new_fp, "@@||${matches[1]}^\n");
        }
    }
}

fclose($src_fp);
fclose($new_fp);
rename($src_file . '.txt', $src_file);
echo 'Time cost:', microtime(true) - START_TIME, "s, at ", date('m-d H:i:s'), "\n";
