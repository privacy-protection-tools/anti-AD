<?php
/**
 * 工具类
 *
 * @date 2019.12.14
 * @author gently
 */

class utils{

    /**
     * http get 方法，一般用于下载文件
     *
     * @param $url
     * @return bool|string
     */
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

    /**
     * 数组合并，将相同key的值相加而不是生成数组或合并，不同key将全部保留
     *
     * @param $arr1
     * @param $arr2
     * @return array
     */
    public static function array_merge_plus($arr1, $arr2){
        if(!is_array($arr1)){
            $arr1 = array();
        }

        if(!is_array($arr2)){
            $arr2 = array();
        }

        $arr1 = array_merge_recursive($arr1, $arr2);

        $arr_result = array();
        foreach($arr1 as $key => $val){
            $arr_result[$key] = array();

            if(!is_array($val)){
                continue;
            }

            foreach($val as $k => $v){
                $arr_result[$key][$k] = is_array($v) ? array_sum($v) : $v;
            }
        }

        return $arr_result;
    }
}