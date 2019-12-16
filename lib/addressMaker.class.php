<?php
/**
 * url地址相关的操作类
 *
 * @file addressMaker.class.php
 * @author gently
 * @date 2017.12.31
 *
 *
 */

class addressMaker {

    /**
     * 分离域名
     *
     * @param $str_domain
     * @return string
     */
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
        if(preg_match($str_reg, $str_domain, $matches)){
            return strval($matches[1]);
        }

        return "";

    }

    /**
     * 从 easylist类源文件中提取可用地址
     *
     * @param $str_easylist
     * @return array
     */
    public static function get_domain_from_easylist($str_easylist){
        $strlen = strlen($str_easylist);
        if($strlen < 10){
            return array();
        }

        $str_easylist = $str_easylist . "\n"; //防止最后一行没有换行符

        $i = 0;
        $arr_domains = array();
        while($i < $strlen){
            $end_pos = strpos($str_easylist, "\n", $i);
            $line = trim(substr($str_easylist, $i, $end_pos - $i));
            $i = $end_pos + 1;
            if(empty($line) || strlen($line) < 3){
                continue;
            }

            if($line{0} != '|' || $line{1} != '|'){
                continue;
            }

            if(preg_match('/^\|\|([0-9a-z\-\.]+[a-z]+)[\^\$]*(image|third-party|script|subdocument|popup)?(,.+)?$/', $line, $matches)){

                if(substr($matches[1], 0, 4) == 'www.'){
                    $row = substr($matches[1], 4);
                }else{
                    $row = $matches[1];
                }

                $arr_domains[self::extract_main_domain($matches[1])][] = $row;
            }
        }

        return $arr_domains;
    }

    /**
     * 从hosts或dnsmasq类文件中提取地址
     *
     * @param $str_hosts
     * @return array
     */
    public static function get_domain_list($str_hosts){
        $strlen = strlen($str_hosts);
        if($strlen < 3){
            return array();
        }

        $str_hosts = $str_hosts . "\n"; //防止最后一行没有换行符

        $i = 0;
        $arr_domains = array();
        while($i < $strlen){
            $end_pos = strpos($str_hosts, "\n", $i);
            $line = trim(substr($str_hosts, $i, $end_pos - $i));
            $i = $end_pos + 1;
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
        $write_len = fwrite($fp, '#TIME=' . date('YmdHis') . "\n");
        $write_len += fwrite($fp, '#URL=https://github.com/privacy-protection-tools/anti-AD' . "\n");

        foreach($arr_result as $rk => $rv){

            if(array_key_exists($rk, $GLOBALS['arr_whitelist'])){//主域名在白名单的，整个不写入屏蔽列表
                continue;
            }

            if(empty($rk)){//遗漏的域名，不会写入到最终的配置里
//                print_r($rv);
                continue;
            }

            if(!is_array($rv)){
                if(array_key_exists($rv, $GLOBALS['arr_whitelist'])){//单个域名的白名单检查
                    continue;
                }
                $write_len += fwrite($fp, 'address=/' . $rv . '/' . "\n");
                continue;
            }

            $rv = array_unique($rv);

            if(in_array('.' . $rk, $rv) || in_array('www.' . $rk, $rv) || in_array($rk, $rv)){
                $write_len += fwrite($fp, 'address=/' . $rk . '/' . "\n");
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
            }
        }

        fclose($fp);

        return $write_len;
    }
}