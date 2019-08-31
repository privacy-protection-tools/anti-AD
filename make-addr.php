<?php
//在命令行下运行，直接生成dnsmasq的去广告用途的配置文件
//2017年12月31日

set_time_limit(600);

if(PHP_SAPI != 'cli'){
	die('nothing.');
}

$arr_blacklist = require('./black_domain_list.php');
$arr_whitelist = require('./white_domain_list.php');


$arr_result = array();


$easylist1 = file_get_contents('./easylistchina+easylist.txt');

$arr_result = array_merge_recursive($arr_result, makeAddr::get_domain_from_easylist($easylist1));

//$easylist2 = file_get_contents('./koolproxy.txt');

//$arr_result = array_merge_recursive($arr_result, makeAddr::get_domain_from_easylist($easylist2));


echo '开始下载host1....',"\n";
$host1 = makeAddr::http_get('https://hosts.nfz.moe/full/hosts');
$arr_result = array_merge_recursive($arr_result, makeAddr::get_domain_list($host1));

echo '开始下载host2....',"\n";
$host2 = makeAddr::http_get('http://www.malwaredomainlist.com/hostslist/hosts.txt');
$arr_result = array_merge_recursive($arr_result, makeAddr::get_domain_list($host2));


$arr_result = array_merge($arr_result, $arr_blacklist);

echo '写入文件大小：';
var_dump(makeAddr::write_to_conf($arr_result, './adblock-for-dnsmasq.conf'));




class makeAddr{


	public static function http_get($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'T_T angent 2.0.5/' . phpversion());
		$result = curl_exec($ch);
		$errno = curl_errno($ch);
		curl_close($ch);
	
		return $result;
	}

	public static function extract_main_domain($str_domain){
		if(empty($str_domain)){
			return "";
		}

		$str_reg = '/^[a-z0-9\-\.]*?([a-z0-9\-]+(\.com|\.cn|\.net|\.org|\.cn|\.me|\.co|\.info|\.cc|\.tv';
		$str_reg .= '|\.pw|\.biz|\.top|\.win|\.bid|\.cf|\.club|\.ne|\.de|\.la|\.us|\.mobi|\.hn|\.asia';
		$str_reg .= '|\.jp|\.tw|\.am|\.hk|\.site|\.live|\.xyz|\.space|\.fr|\.es|\.nl|\.au|\.in|\.ru';
		$str_reg .= '|\.su|\.world|\.io|\.trade|\.bet|\.im|\.fm|\.today|\.wang|\.rocks|\.vip|\.eu|\.run';
		$str_reg .= '|\.online|\.website|\.cricket|\.date|\.men|\.ca|\.xxx|\.name|\.pl|\.be|\.il|\.gov|\.it';
		$str_reg .= '|\.cl|\.tk|\.cz|\.hu|\.ro|\.vg|\.ws|\.nu|\.vn|\.lt|\.edu|\.lv|\.mx|\.by|\.gr|\.br|\.fi';
		$str_reg .= '|\.pt|\.dk|\.se|\.at|\.id|\.ve|\.ir|\.ma|\.ch|\.nf|\.bg|\.ua|\.is|\.hr|\.shop|\.xin|\.si|\.or';
		$str_reg .= '|\.sk|\.kz|\.tt|\.so|\.gg|\.ms|\.ink|\.pro|\.work|\.click|\.link|\.ly';
		$str_reg .= ')';

		$str_reg .= '(\.cn|\.tw|\.uk|\.jp|\.kr|\.th|\.au|\.ua|\.so|\.br|\.sg|\.pt|\.ec|\.ar|\.my|\.tr|\.bd|\.mk|\.za)?)$/';
		if(preg_match($str_reg, $str_domain,$matchs)){
			return strval($matchs[1]);
		}

		return "";

	}

	public static function get_domain_from_easylist($str_easylist){
		$strlen = strlen($str_easylist);
		if($strlen < 10){
			return array();
		}

		$str_easylist = $str_easylist . "\n"; //防止最后一行没有换行符

		$i=0;
		$arr_domains = array();
		while($i < $strlen){
			$end_pos = strpos($str_easylist, "\n", $i);
			$line = trim(substr($str_easylist, $i, $end_pos - $i));
			$i = $end_pos+1;
			if(empty($line) || strlen($line) < 3){
				continue;
			}

			if($line{0} != '|' || $line{1} != '|'){
				continue;
			}

			if(preg_match('/^\|\|([0-9a-z\-\.]+[a-z]+)[\^\$]*(image|third-party|script)?$/', $line, $matchs)){

				if(substr($matchs[1], 0, 4) == 'www.'){
					$row = substr($matchs[1], 3);
				}else{
					$row = $matchs[1];
				}
				
				$arr_domains[self::extract_main_domain($matchs[1])][] = $row;
			}
		}

		return $arr_domains;
	}
	
	public static function get_domain_list($str_hosts){
		$strlen = strlen($str_hosts);
		if($strlen < 10){
			return array();
		}

		$str_hosts = $str_hosts . "\n"; //防止最后一行没有换行符

		$i=0;
		$arr_domains = array();
		while($i < $strlen){
			$end_pos = strpos($str_hosts, "\n", $i);
			$line = trim(substr($str_hosts, $i, $end_pos - $i));
			$i = $end_pos+1;
			if(empty($line) || ($line{0} == '#')){//注释行忽略
				continue;
			}
			$line = strtolower(preg_replace('/[\s\t]+/', "/", $line));

			if((strpos($line, '127.0.0.1') === false) && 
				(strpos($line, '::') === false) && 
				(strpos($line, '0.0.0.0') === false)){
				continue;
			}
		
			$row = explode('/', $line);
			if(strpos($row[1], '.') === false){
				continue;
			}
			
			$arr_domains[self::extract_main_domain($row[1])][] = $row[1];
		}

		return $arr_domains;
	}

	public static function write_to_conf($arr_result, $str_file){

		$fp = fopen($str_file, 'w');
		$write_len = fwrite($fp, '#Date:' . date('YmdHis'). "\n");

		foreach($arr_result as $rk => $rv){
			if(array_key_exists($rk, $GLOBALS['arr_blacklist'])){//黑名单操作

				if(in_array($rk, $GLOBALS['arr_blacklist'][$rk]) || in_array('.' . $rk , $GLOBALS['arr_blacklist'][$rk])){
					$write_len += fwrite($fp, 'address=/' . $rk . '/' . "\n");
					continue;
				}

				foreach($GLOBALS['arr_blacklist'][$rk] as $bv){
					$write_len += fwrite($fp, 'address=/' . $bv . '/' . "\n");
				}
				continue;
			}

			if(empty($rk)){//遗漏的域名，不会写入到最终的配置里
				// print_r($rv);
				continue;
			}

			if(array_key_exists($rk, $GLOBALS['arr_whitelist'])){//白名单机制
				continue;
			}

			if(!is_array($rv)){
				if(array_key_exists($rv, $GLOBALS['arr_whitelist'])){//白名单机制
					continue;
				}
				$write_len += fwrite($fp, 'address=/' . $rv . '/' . "\n");
				continue;
			}

			$rv = array_unique($rv);

			if(in_array('.' . $rk, $rv) || in_array('www.' . $rk, $rv)){
				$write_len += fwrite($fp, 'address=/' . $rk . '/' . "\n");
				continue;
			}

			foreach($rv as $rvv){
				if(array_key_exists($rvv, $GLOBALS['arr_whitelist'])){//白名单机制
					continue;
				}
				$write_len += fwrite($fp, 'address=/' . $rvv . '/' . "\n");
			}
		}

		fclose($fp);

		return $write_len;
	}
}





























