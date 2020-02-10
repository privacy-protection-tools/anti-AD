<?php
//white_domain_list
//白名单机制...，白名单是
//@date 2018年12月23日
//value=0,代表仅加白单条域名
//value=1,代表其下级域名全部加白（例如3级域名，则其4级子域名全部加白）
//value=2,代表仅加白主域名及其子域名，即如果是主域名，加白全部，如果是子域名，加白命中的单条

return array(

    'cdn-thumb.fds.api.xiaomi.com' => 0,
    'bce.baidu.com' => 0,
    'b.bdstatic.com' => 0,
    'gss0.bdstatic.com' => 0, //百度贴吧头像
    'googleadapis.l.google.com' => 0, //解决google字体下载异常
    'gstaticadssl.l.google.com' => 0, //解决google字体下载异常
    'gvt2.com' => 1, //gvt2，安卓系统相关
    'wangbase.com' => 1, //阮一峰同志的博客图片显示
    'l.qq.com' => 0, //解决腾讯视频无法播放
    'dldir1.qq.com' => 0, //qq下载安装包路径
    'cgi.connect.qq.com' => 0, //qq互联
    'stdl.qq.com' => 0, //qq浏览器
    'wup.imtt.qq.com' => 0, //qq浏览器书签
    'pacaio.match.qq.com' => 0, //腾讯网qq登录
    'gia.jd.com' => 0, //京东滑动验证码
    'edge.yunjiasu.com' => 0, //百度云加速javascript快速加载功能
    'cd.bendibao.com' => 0, //成都本地宝
    'm.qpic.cn' => 0, // qq，微信，QQ空间等用到的静态资源域名
    'ipify.org' => 0, // 获得公网 IP
    'pass.1688.com' => 0, // 阿里巴巴网站访问不正常
    'cedexis.net' => 0, // windowsupdate CNAME
    'y0.cn' => 0, // 短网址服务，涉及本次丁香医生实时疫情页面 http://y0.cn/sari
    'click.taobao.com' => 0, //淘宝粉丝福利购
    't1.baidu.com' => 0, //百度图片自有平台
    't2.baidu.com' => 0, //百度图片自有平台
    't3.baidu.com' => 0, //百度图片自有平台
    't4.baidu.com' => 0, //百度图片自有平台
    't5.baidu.com' => 0, //百度图片自有平台
    't6.baidu.com' => 0, //百度图片自有平台
    't7.baidu.com' => 0, //百度图片自有平台
    't8.baidu.com' => 0, //百度图片自有平台
    't9.baidu.com' => 0, //百度图片自有平台
    't10.baidu.com' => 0, //百度图片自有平台
    't11.baidu.com' => 0, //百度图片自有平台
    't12.baidu.com' => 0, //百度图片自有平台
    'bytedance.com' => 0, //字节跳动
    'tbskip.taobao.com' => 1, //淘宝订单搜索相关
    'wl.jd.com' => 0, //修复京东pc首页加载异常
    'tanx.com' => 0, //饿了么店铺异常
    'promotion.aliyun.com' => 0, //阿里云控制台

    'herokuapp.com' => 0,
    'vidoza.net' => 0,
    'nahnoji.cz' => 1,
    'cloudfront.net' => 0,
    'activate.adobe.com' => 0,
    'ereg.adobe.com' => 0,
    'hlrcv.stage.adobe.com' => 0,
    'lmlicenses.wip4.adobe.com' => 0,
    'na1r.services.adobe.com' => 0,
    'licenses.adobe.com' => 1,
    'alcohol-soft.com' => 1,
    'trial.alcohol-soft.com' => 0,
    'licenses.ashampoo.com' => 0,
    'bluesoleil.com' => 1,
    'activation.phaseone.com' => 0,
    'corel.com' => 1,
    'dbregistration.cuteftp.com' => 0,
    'activation.cyberlink.com' => 0,
    'cap.cyberlink.com' => 0,
    'activation.easeus.com' => 0,
    'upd.faronicslabs.com' => 0,
    'lumion3d.com' => 1,
    'lumion3d.net' => 1,
    'act2.mediafour.com' => 0,
    'sams.nikonimaging.com' => 0,
    'license.piriform.com' => 0,
    'www.bitsumactivationserver.com' => 0,
    'licensing.tableausoftware.com' => 0,
    'techsmith.com' => 1,
    'binaryage.com' => 1,
    'wisecleaner.com' => 1,
);
