<?php
/**
 * 定义输出格式
 *
 *
 */

class writerFormat{
    /*dnsmasq支持格式的屏蔽广告列表*/
    const DNSMASQ = array('format' => 'address=/{DOMAIN}/', 'header' => "#TIME={DATE}\n#URL={URL}\n");
    /*easylist 兼容格式的屏蔽广告列表*/
    const EASYLIST = array('format' => '||{DOMAIN}^', 'header' => "#TIME={DATE}\n#URL={URL}\n");
    /*Surge 兼容格式的屏蔽广告列表*/
    const SURGE = array('format' => 'DOMAIN-SUFFIX,{DOMAIN},REJECT', 'header' => "#TIME={DATE}\n#URL={URL}\n[RULE]\n");
    /*and etc...*/

}
