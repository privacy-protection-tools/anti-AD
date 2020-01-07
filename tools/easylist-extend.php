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
define('LIB_DIR', ROOT_DIR . 'lib');

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
$whiterule_fp = fopen(WHITERULE_SRC, 'r');
while(!feof($whiterule_fp)){
    $row = fgets($whiterule_fp, 1024);
    if(empty($row) || $row{0} !== '@' || $row{1} !== '@'){
        continue;
    }
    $matches = array();
    if(!preg_match('/@@\|\|([0-9a-z\.\-\*]+?)\^/', $row, $matches)){
        continue;
    }
    foreach($wrote_wild as $core_str => $val){
        $match_rule = str_replace('*', '.*', $core_str);
        if(preg_match("/\|${match_rule}\^/", $row)){
            fwrite($new_fp, "@@||${matches[1]}^");
        }
    }
}

fclose($src_fp);
fclose($new_fp);
fclose($whiterule_fp);
var_dump(rename($src_file . '.txt', $src_file));
echo 'Time cost:', microtime(true) - START_TIME, "s, at ", date('m-d H:i:s'), "\n";
