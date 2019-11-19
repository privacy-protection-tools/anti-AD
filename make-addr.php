<?php
//在命令行下运行，直接生成dnsmasq的去广告用途的配置文件
//2017年12月31日

set_time_limit(600);

error_reporting(0);

if(PHP_SAPI != 'cli'){
	die('nothing.');
}

$arr_blacklist = require('./black_domain_list.php');
$arr_whitelist = require('./white_domain_list.php');


$arr_result = array();


$easylist1 = file_get_contents('./easylistchina+easylist.txt');
$arr_result = array_merge_recursive($arr_result, makeAddr::get_domain_from_easylist($easylist1));

$easylist2 = file_get_contents('./cjx-annoyance.txt');
$arr_result = array_merge_recursive($arr_result, makeAddr::get_domain_from_easylist($easylist2));

$easylist3 = file_get_contents('./fanboy-annoyance.txt');
$arr_result = array_merge_recursive($arr_result, makeAddr::get_domain_from_easylist($easylist3));


$host1 = file_get_contents('./hosts1');
$arr_result = array_merge_recursive($arr_result, makeAddr::get_domain_list($host1));

// $host2 = makeAddr::http_get('http://www.malwaredomainlist.com/hostslist/hosts.txt');
$host2 = file_get_contents('./hosts2');
$arr_result = array_merge_recursive($arr_result, makeAddr::get_domain_list($host2));

$host3 = file_get_contents('./hosts3');
$arr_result = array_merge_recursive($arr_result, makeAddr::get_domain_list($host3));

$arr_result = array_merge_recursive($arr_result, $arr_blacklist);

echo 'Written file size:';
echo makeAddr::write_to_conf($arr_result, './adblock-for-dnsmasq.conf', 'q-filter.conf');




class makeAddr{


	public static function http_get($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, '^_^ angent 2.2.5/' . phpversion());
		$result = curl_exec($ch);
		$errno = curl_errno($ch);
		curl_close($ch);

		return $result;
	}

	public static function extract_main_domain($str_domain){
		if(empty($str_domain)){
			return "";
		}

		$str_reg = '/^(?:(?:[a-z0-9\-]+\.)*?|\.)?([a-z0-9\-]+(\.com|\.cn|\.net|\.org|\.cn|\.me|\.co|\.info|\.cc|\.tv';
		$str_reg .= '|\.pw|\.biz|\.top|\.win|\.bid|\.cf|\.club|\.ne|\.de|\.la|\.us|\.mobi|\.hn|\.asia';
		$str_reg .= '|\.jp|\.tw|\.am|\.hk|\.site|\.live|\.xyz|\.space|\.fr|\.es|\.nl|\.au|\.in|\.ru';
		$str_reg .= '|\.su|\.world|\.io|\.trade|\.bet|\.im|\.fm|\.today|\.wang|\.rocks|\.vip|\.eu|\.run';
		$str_reg .= '|\.online|\.website|\.cricket|\.date|\.men|\.ca|\.xxx|\.name|\.pl|\.be|\.il|\.gov|\.it';
		$str_reg .= '|\.cl|\.tk|\.cz|\.hu|\.ro|\.vg|\.ws|\.nu|\.vn|\.lt|\.edu|\.lv|\.mx|\.by|\.gr|\.br|\.fi';
		$str_reg .= '|\.pt|\.dk|\.se|\.at|\.id|\.ve|\.ir|\.ma|\.ch|\.nf|\.bg|\.ua|\.is|\.hr|\.shop|\.xin|\.si|\.or';
		$str_reg .= '|\.sk|\.kz|\.tt|\.so|\.gg|\.ms|\.ink|\.pro|\.work|\.click|\.link|\.ly|\.ai|\.tech|\.kr|\.to';
		$str_reg .= '|\.uk|\.ad|\.ac|\.md|\.ml|\.cm|\.re|\.ph|\.my|\.lu|\.network|\.sh|\.fun|\.az|\.cx|\.ga';
		$str_reg .= '|\.ae|\.bz|\.gq|\.gs|\.pk|\.sex|\.stream|\.support|\.pub|\.nz|\.ng|\.zw|\.sx|\.studio|\.media|\.zone';
		$str_reg .= '|\.icu|\.ie|\.li|\.bar|\.video|\.wiki|\.ltd|\.cash|\.pink|\.loan|\.gdn|\.app|\.ovh|\.land|\.st|\.how';
		$str_reg .= ')';

		$str_reg .= '(\.cn|\.hk|\.tw|\.uk|\.jp|\.kr|\.th|\.au|\.ua|\.so|\.br|\.sg|\.pt|\.ec|\.ar|\.my|\.tr|\.bd|\.mk|\.za|\.mt)?)$/';
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
					$row = substr($matchs[1], 4);
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

	public static function write_to_conf($arr_result, $str_file, $q_file){

		$fp = fopen($str_file, 'w');
		$fp2 = fopen($q_file, 'w');
		$write_len = fwrite($fp, '#TIME=' . date('YmdHis'). "\n");
		$write_len += fwrite($fp, '#URL=https://github.com/gentlyxu/anti-AD' . "\n");
		fwrite($fp2, '[TCP]' . "\n");
		fwrite($fp2, 'USER-AGENT,com.apple.*,DIRECT' . "\n");
		fwrite($fp2, 'USER-AGENT,FindMy*,DIRECT' . "\n");
		fwrite($fp2, 'USER-AGENT,Maps*,DIRECT' . "\n");

		foreach($arr_result as $rk => $rv){

			if(array_key_exists($rk, $GLOBALS['arr_whitelist'])){//主域名在白名单的，整个不写入屏蔽列表
				continue;
			}

			if(empty($rk)){//遗漏的域名，不会写入到最终的配置里
				// print_r($rv);
				continue;
			}

			if(!is_array($rv)){
				if(array_key_exists($rv, $GLOBALS['arr_whitelist'])){//单个域名的白名单检查
					continue;
				}
				$write_len += fwrite($fp, 'address=/' . $rv . '/' . "\n");
				fwrite($fp2, 'HOST-SUFFIX,' . $rv . ',REJECT' . "\n");
				continue;
			}

			$rv = array_unique($rv);

			if(in_array('.' . $rk, $rv) || in_array('www.' . $rk, $rv) || in_array($rk, $rv)){
				$write_len += fwrite($fp, 'address=/' . $rk . '/' . "\n");
				fwrite($fp2, 'HOST-SUFFIX,' . $rk . ',REJECT' . "\n");
				continue;
			}

			$arr_written = [];
			foreach($rv as $rvv){
				if(array_key_exists($rvv, $GLOBALS['arr_whitelist'])){
					continue;
				}

				//合并三级域名逻辑
				$tmp_arr1 = explode('.', $rvv);
				$written_flag = false;

				if(count($tmp_arr1) > 2){
					for($tmp_pos = 3; $tmp_pos <= count($tmp_arr1); $tmp_pos++){
						$tmp_arr2 = array_slice($tmp_arr1, -1 * $tmp_pos);
						if(in_array(implode('.', $tmp_arr2), $rv)){
							if(!in_array(implode('.', $tmp_arr2), $arr_written)){
								$arr_written[] = implode('.', $tmp_arr2);
								if(array_key_exists(implode('.', $tmp_arr2), $GLOBALS['arr_whitelist'])){
									continue;
								}
								$write_len += fwrite($fp, 'address=/' . implode('.', $tmp_arr2) . '/' . "\n");
								fwrite($fp2, 'HOST-SUFFIX,' . implode('.', $tmp_arr2) . ',REJECT' . "\n");
							}
							$written_flag = true;
							break;
						}
					}
				}

				if(in_array($rvv, $arr_written) || $written_flag){
					continue;
				}

				$arr_written[] = $rvv;
				$write_len += fwrite($fp, 'address=/' . $rvv . '/' . "\n");
				fwrite($fp2, 'HOST-SUFFIX,' . $rvv . ',REJECT' . "\n");
			}
		}

		fclose($fp);
		fclose($fp2);

		return $write_len;
	}
}
