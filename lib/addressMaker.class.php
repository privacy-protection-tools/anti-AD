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
!defined('ROOT_DIR') && die('Access Denied.');

class addressMaker{

    const LINK_URL = 'https://github.com/privacy-protection-tools/anti-AD';

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

        $str_reg = '/^(?:(?:[a-z0-9\-]*[a-z0-9]\.)*?|\.)?([a-z0-9\-]*[a-z0-9](';
        /************start CN域名的特殊处理规则，其中包括了各行政区特别后缀的cn域名*****************************/
        $str_reg .= '\.ac\.cn|\.ah\.cn|\.bj\.cn|\.com\.cn|\.cq\.cn|\.fj\.cn|\.gd\.cn|\.gov\.cn|\.gs\.cn';
        $str_reg .= '|\.gx\.cn|\.gz\.cn|\.ha\.cn|\.hb\.cn|\.he\.cn|\.hi\.cn|\.hk\.cn|\.hl\.cn|\.hn\.cn';
        $str_reg .= '|\.jl\.cn|\.js\.cn|\.jx\.cn|\.ln\.cn|\.mo\.cn|\.net\.cn|\.nm\.cn|\.nx\.cn|\.org\.cn';
        $str_reg .= '|\.qh\.cn|\.sc\.cn|\.sd\.cn|\.sh\.cn|\.sn\.cn|\.sx\.cn|\.tj\.cn|\.tw\.cn|\.xj\.cn';
        $str_reg .= '|\.xz\.cn|\.yn\.cn|\.zj\.cn|\.edu.cn';
        /************end CN域名的特殊处理规则，其中包括了各行政区特别后缀的cn域名******************************/
        $str_reg .= '|\.cn|\.com|\.net|\.org|\.me|\.co|\.info|\.cc|\.tv';
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
        $str_reg .= '|\.kim|\.download|\.ag|\.technology|\.company|\.guru|\.gt|\.sg|\.photo|\.digital|\.one|\.tr';
        $str_reg .= '|\.show|\.sncf|\.uz|\.as|\.ee|\.fyi|\.cloud|\.group|\.promo|\.party|\.services|\.life|\.no';
        $str_reg .= '|\.watch|\.works|\.buzz|\.best|\.center|\.host|\.style|\.press|\.solutions|\.exchange|\.wtf';
        $str_reg .= '|\.delivery|\.page|\.webcam|\.cam|\.supply|\.accountant|\.systems|\.agency|\.science|\.awe';
        $str_reg .= '|\.gd|\.review|\.tc|\.mn|\.cool|\.monster|\.do|\.bi|\.news|\.boom|\.lol|\.events|\.jobs';
        $str_reg .= '|\.ooo|\.social|\.ninja|\.blue|\.plus|\.racing|\.ht|\.tl|\.cat|\.tf|\.al|\.vc|\.cr';
        $str_reg .= ')';

        $str_reg .= '(\.hk|\.tw|\.uk|\.jp|\.kr|\.th|\.au|\.ua|\.so|\.br|\.sg|\.pt|\.ec|\.ar|\.my';
        $str_reg .= '|\.tr|\.bd|\.mk|\.za|\.mt|\.sm|\.ge|\.kg|\.ke|\.de|\.ve|\.es|\.ru|\.pk|\.mx';
        $str_reg .= '|\.nz|\.py|\.pe|\.ph|\.pl|\.ng|\.pa|\.fj';

        $str_reg .= ')?)$/';
        if(preg_match($str_reg, $str_domain, $matches)){
            return strval($matches[1]);
        }

        return "";

    }

    /**
     * 从 easylist类源文件中提取可用地址
     *
     * @param String $str_easylist 原始的easylist列表字符串
     * @param Boolean $strict_mode 严格模式，启用时将屏蔽该域所在的主域名，例如www.baidu.com，将获取到baidu.com并写入最终列表
     * @param Array $arr_whitelist 白名单列表
     * @return array
     */
    public static function get_domain_from_easylist($str_easylist, $strict_mode = false, $arr_whitelist = array()){
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

            if(preg_match('/^\|\|([0-9a-z\-\.]+[a-z]+)\^(\$([^=]+?,)?(image|third-party|script)(,[^=]+)?)?$/', $line, $matches)){

                if(substr($matches[1], 0, 4) == 'www.'){
                    $row = substr($matches[1], 4);
                }else{
                    $row = $matches[1];
                }
                $main_domain = self::extract_main_domain($matches[1]);
                if($strict_mode && (!array_key_exists($main_domain, $arr_whitelist) || ($arr_whitelist[$main_domain] >= 1))){
                    $arr_domains[$main_domain] = array($main_domain);
                }else{
                    $arr_domains[$main_domain][] = $row;
                }
            }
        }

        return $arr_domains;
    }

    /**
     * 从hosts或dnsmasq类文件中提取地址
     *
     * @param String $str_hosts 原始的hosts字符串
     * @param Boolean $strict_mode 严格模式，启用时将屏蔽该域所在的主域名，例如www.baidu.com，将获取到baidu.com并写入最终列表
     * @param Array $arr_whitelist 白名单
     * @return array
     */
    public static function get_domain_list($str_hosts, $strict_mode = false, $arr_whitelist = array()){
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
            $main_domain = self::extract_main_domain($row[1]);
            if($strict_mode && (!array_key_exists($main_domain, $arr_whitelist) || ($arr_whitelist[$main_domain] >= 1))){
                $arr_domains[$main_domain] = array($main_domain);
            }else{
                $arr_domains[$main_domain][] = $row[1];
            }
        }

        return $arr_domains;
    }

    private static function write_conf_header($fp, $header, $arr_params = array()){
        $header = str_replace('{DATE}', date('YmdHis'), $header);
        $header = str_replace('{URL}', self::LINK_URL, $header);

        foreach($arr_params as $keyword => $val){
            $header = str_replace('{' . $keyword . '}', $val, $header);
        }
        return fwrite($fp, $header);
    }

    /**
     * 写入结果到最终文件
     *
     * @param array $arr_src
     * @param $arr_format
     * @param array $arr_whitelist
     * @return false|int
     */
    public static function write_to_file(array $arr_src, array $arr_format, array $arr_whitelist = array()){

        if(count($arr_src) < 1){
            return false;
        }

        foreach($arr_whitelist as $wlk => $wlv){
            if(-1 === $wlv){
                unset($arr_whitelist[$wlk]);
            }
        }

        $str_result = '';
        $line_count = 0;

        $arr_written = [];
        foreach($arr_src as $main_domain => $arr_subdomains){

            if(array_key_exists($main_domain, $arr_whitelist) && ($arr_whitelist[$main_domain] > 0)){
                continue;
            }

            if(empty($main_domain)){//不匹配记录（一般是不合法域名或者未收录的后缀）
                continue;
            }


            if(
                (1 !== $arr_format['full_domain'])
                && (!array_key_exists($main_domain, $arr_whitelist))
                && (in_array($main_domain, $arr_subdomains)
                    || in_array('www.' . $main_domain, $arr_subdomains)
                    || in_array('.' . $main_domain, $arr_subdomains)
                    )
            ){
                $str_result .= str_replace('{DOMAIN}', $main_domain, $arr_format['format']) . "\n";
                $line_count ++;
                continue;
            }

            $arr_subdomains = array_fill_keys($arr_subdomains, 2);

            foreach($arr_subdomains as $subdomain => $__){
                if(array_key_exists($subdomain, $arr_whitelist)){
                    continue;
                }

                $arr_tmp_domain = explode('.', $subdomain);
                $tmp_domain_len = count($arr_tmp_domain);
                if($tmp_domain_len < 3){
                    $str_result .= str_replace('{DOMAIN}', $subdomain, $arr_format['format']) . "\n";
                    $line_count ++;
                    $arr_written[$subdomain] = 2;
                    continue;
                }

                $matched_flag = false;
                for($pos = 3; $pos <= $tmp_domain_len; $pos ++){
                    $arr_tmp = array_slice($arr_tmp_domain, -1 * $pos);
                    $tmp = implode('.', $arr_tmp);

                    if(array_key_exists($tmp, $arr_whitelist)){
                        $matched_flag = $arr_whitelist[$tmp] === 1;
                        break;
                    }

                    if(($tmp === $subdomain) || array_key_exists($tmp, $arr_subdomains)){
                        if(!array_key_exists($tmp, $arr_written)){
                            $str_result .= str_replace('{DOMAIN}', $tmp, $arr_format['format']) . "\n";
                            $line_count ++;
                            $arr_written[$tmp] = 2;
                        }
                        $matched_flag = 1 !== $arr_format['full_domain'];
                        break;
                    }
                }

                if($matched_flag){
                    continue;
                }

                if(!array_key_exists($subdomain, $arr_written)){
                    $str_result .= str_replace('{DOMAIN}', $subdomain, $arr_format['format']) . "\n";
                    $line_count ++;
                    $arr_written[$subdomain] = 3;
                }
            }
        }
        unset($arr_written);

        $fp = fopen(ROOT_DIR . $arr_format['filename'], 'w');
        $write_len = self::write_conf_header($fp, $arr_format['header'], array('COUNT' => $line_count));
        $write_len += fwrite($fp, $str_result);
        return $write_len;
    }
}