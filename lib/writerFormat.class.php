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
        'header' => "#VER={DATE}\n#URL={URL}\n",
        'name' => 'dnsmasq',
        'filename' => 'adblock-for-dnsmasq.conf'
    );

    /*easylist 兼容格式的屏蔽广告列表*/
    const EASYLIST = array(
        'format' => '||{DOMAIN}^',
        'header' => "!AdBlock-style blocklists\n!VER={DATE}\n!URL={URL}\n",
        'name' => 'easylist',
        'filename' => 'anti-ad-easylist.txt'
    );

    /*Surge 兼容格式的屏蔽广告列表*/
    const SURGE = array(
        'format' => 'DOMAIN-SUFFIX,{DOMAIN}',
        'header' => "#VER={DATE}\n#URL={URL}\n",
        'name' => 'surge',
        'filename' => 'anti-ad-surge.txt'
    );

    /*Domains 格式的屏蔽广告列表，用于支持pi-hole等*/
    const DOMAINS = array(
        'format' => '{DOMAIN}',
        'header' => "#VER={DATE}\n#URL={URL}\n",
        'name' => 'surge',
        'filename' => 'anti-ad-domains.txt'
    );

    /*and etc...*/

}
