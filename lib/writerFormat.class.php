<?php
/**
 * 定义输出格式
 *
 *
 */

!defined('ROOT_DIR') && die('Access Denied.');

class writerFormat{
    /*dnsmasq支持格式的屏蔽广告列表*/
    const DNSMASQ = array(
        'format' => 'address=/{DOMAIN}/',
        'header' => "#TIME={DATE}\n#URL={URL}\n",
        'name' => 'dnsmasq',
        'filename' => 'adblock-for-dnsmasq.conf'
    );

    /*easylist 兼容格式的屏蔽广告列表*/
    const EASYLIST = array(
        'format' => '||{DOMAIN}^',
        'header' => "!TIME={DATE}\n!URL={URL}\n",
        'name' => 'easylist',
        'filename' => 'anti-ad-easylist.txt'
    );

    /*Surge 兼容格式的屏蔽广告列表*/
    const SURGE = array(
        'format' => 'DOMAIN-SUFFIX,{DOMAIN},REJECT',
        'header' => "#TIME={DATE}\n#URL={URL}\n[RULE]\n",
        'name' => 'surge',
        'filename' => 'anti-ad-surge.txt'
    );

    /*and etc...*/

}
