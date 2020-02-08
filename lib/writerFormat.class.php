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
        'full_domain' => 0,
        'name' => 'dnsmasq',
        'filename' => 'adblock-for-dnsmasq.conf',
        'require_black_list' => true,
        'require_white_list' => true,
        'src' => array(
            'base-src-easylist.txt' => array(
                'type' => 'easylist',
                'strict_mode' => false,
            ),
            'base-src-hosts.txt' => array(
                'type' => 'hosts',
                'strict_mode' => false,
            ),
            'base-src-strict-hosts.txt' => array(
                'type' => 'hosts',
                'strict_mode' => true,
            ),
        ),
    );

    /*easylist 兼容格式的屏蔽广告列表*/
    const EASYLIST = array(
        'format' => '||{DOMAIN}^',
        'header' => "!AdBlock-style blocklists\n!VER={DATE}\n!URL={URL}\n",
        'full_domain' => 0,
        'name' => 'easylist',
        'filename' => 'anti-ad-easylist.txt'
    );

    /*Surge 兼容格式的屏蔽广告列表*/
    const SURGE = array(
        'format' => 'DOMAIN-SUFFIX,{DOMAIN}',
        'header' => "#VER={DATE}\n#URL={URL}\n",
        'full_domain' => 0,
        'name' => 'surge',
        'filename' => 'anti-ad-surge.txt'
    );

    /*Domains 格式的屏蔽广告列表，用于支持pi-hole等*/
    const DOMAINS = array(
        'format' => '{DOMAIN}',
        'header' => "#VER={DATE}\n#URL={URL}\n",
        'full_domain' => 1, //保留子域名，即使其上级域名
        'name' => 'domains',
        'filename' => 'anti-ad-domains.txt'
    );

    /*and etc...*/

}
