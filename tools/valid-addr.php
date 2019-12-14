<?php
/**
 * address dns checker
 *
 * @file valid-addr.php
 * @date 2019-12-14
 * @author gently
 *
 */
set_time_limit(0);

error_reporting(7);

if(PHP_SAPI != 'cli'){
    die('nothing.');
}

$src_file = '';
$file_num = 'unknown';
try{
    $file = $argv[1];
    $src_file = dirname(__DIR__) . '/origin-files/' . $file;
    list(, $file_num) = explode('_', $file);
}catch(Exception $e){
    echo "get args failed.", $e->getMessage(), "\n";
    die(0);
}

if(empty($src_file) || !is_file($src_file)){
    echo 'src_file:', $src_file, ' is not found.';
    die(0);
}

define('START_TIME', microtime(true));
define('LIB_DIR', dirname(__DIR__) . '/lib');
define('CHINA_LIST', dirname(__DIR__) . '/origin-files/china-list_' . $file_num . '.php');
define('DEAD_HORSE', dirname(__DIR__) . '/origin-files/dead-horse_' . $file_num . '.php');

//http://download.ip2location.com/lite/IP2LOCATION-LITE-DB1.BIN.ZIP
require_once LIB_DIR . '/IP2Location.php';
require_once LIB_DIR . '/Net/DNS2.php';

$china_list = is_file(CHINA_LIST) ? require CHINA_LIST : array();
$dead_horse = is_file(DEAD_HORSE) ? require DEAD_HORSE : array();

//大中华区
$CHINA_AREA = array('CN' => true, 'HK' => true, 'MO' => true, 'TW' => true);


$db = new \IP2Location\Database(LIB_DIR.'/databases/IP2LOCATION-LITE-DB1.BIN', \IP2Location\Database::MEMORY_CACHE);
$r = new Net_DNS2_Resolver(array('nameservers' => array('223.5.5.5', '223.6.6.6', '119.29.29.29')));

$src_fp = fopen($src_file, 'r');

while(!feof($src_fp)){
    $row = fgets($src_fp, 512);
    if(empty($row)){
        continue;
    }

    echo $row;

    if(preg_match('/^address=\/(.+)?\/$/', $row, $matches)){
        try{
            $result = $r->query($matches[1], 'A');
            $result = $result->answer;

            if(is_array($result) && count($result) > 0){

                //find the A record
                $a_record = null;
                foreach($result as $res){
                    if($res->type == 'A'){
                        $a_record = $res;
                        break;
                    }
                }

                if(!$a_record){
                    $dead_horse[$matches[1]]['empty']++;
                    continue;
                }
                $records = $db->lookup($a_record->address, \IP2Location\Database::ALL);

                if(array_key_exists($records['countryCode'], $CHINA_AREA) && !array_key_exists($matches[1], $china_list)){
                    $china_list[$matches[1]] = $records['countryCode'];//$records['countryName'];
                }
            }else{
                $dead_horse[$matches[1]]['empty']++;
            }
        }catch(Net_DNS2_Exception $e){
            if($e->getCode() == 3){
                $dead_horse[$matches[1]]['dead']++;//3=dns记录不存在
            }elseif($e->getCode() == 2){
                $dead_horse[$matches[1]]['problem']++;//2=查询失败，dns服务器没有返回正确记录
            }elseif($e->getCode() == 203){
                $dead_horse[$matches[1]]['timeout']++;//203=查询超时
            }else{
                echo date('m-d H:i:s'), "[", $matches[1], "]", $e->getMessage(), ",code:", $e->getCode(), "\n";
            }
        }
    }
}

try{
    $dead_horse = "<?php \nreturn " . var_export($dead_horse, true) . ';';
    $china_list = "<?php \nreturn " . var_export($china_list, true) . ';';
    file_put_contents(DEAD_HORSE, $dead_horse);
    file_put_contents(CHINA_LIST, $china_list);
}catch(Exception $e){
    echo date('m-d H:i:s'), "write file failed:", $e->getMessage(), "\t", $e->getCode(), "\n";
}

echo 'Time cost:', microtime(true) - START_TIME, "s, at", date('m-d H:i:s'), "\n";
