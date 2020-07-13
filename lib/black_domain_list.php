<?php
//黑名单域名，即直接封杀主域名，效果就是只要是使用该域名及其下级所有域名的请求全部被阻挡，慎重使用

//这个文件主要定义针对hosts文件中不能泛域名解析而优化减少生成行数
//对于个性化屏蔽的域名，全部移动到block_domains.root.conf中管理

return array(
    'f2pool.com' => array('openvpn.f2pool.com'),
    'gepush.com' => array('gepush.com'),
    'cnzz.com' => array('cnzz.com'),
    'cnzz.net' => array('cnzz.net'),
    'cnzz.cn' => array('cnzz.cn'),
    'inmobi.cn' => array('inmobi.cn'),
    'aliapp.org' => array('aliapp.org'),
    'snssdk.com' => array(
        'bds.snssdk.com',
        'xlog.snssdk.com',
    ),
    '51togic.com' => array(
        'customstat.video.51togic.com',
        'ad.video.51togic.com',
        'backup.customstat.video.51togic.com',

    ),
    'amazonaws.com' => array(
        'checkip.amazonaws.com', //获取真实外网ip接口
    ),
    'irs03.com' => array(
        'irs03.com',
    ),
    'bcelive.com' => array(
        'httpdns.bcelive.com', //一个不支持https的httpdns服务，并不能反制运营商劫持
    ),
    'tencentmusic.com' => array(
        'ad.tencentmusic.com',
    ),
    'qq.com' => array(
        'bugly.qq.com',
        'openmsf.3g.qq.com',
        'mtrace.qq.com',
        'btrace.qq.com',
        'mark.l.qq.com',
        'report.qq.com',
        'rcgi.video.qq.com',
        'rlog.video.qq.com',

    ),
    'openstorage.cn' => array(
        'iflyad.bjb.openstorage.cn'
    ),
    'cmpassport.com' => array(
        'log1.cmpassport.com',
        'log.cmpassport.com',
    ),
    'analysys.cn' => array('analysys.cn'),
    'mob.com' => array('mob.com'),
    'szy.cn' => array('dtlog.szy.cn'),
    'adview.cn' => array('adview.cn'),
    'wrating.com' => array('wrating.com'),
    'umengcloud.com' => array('umengcloud.com', 'ulogs.umengcloud.com'),
    'umeng.com' => array('umeng.com', 'alogs.umeng.com'),
    'umeng.co' => array('umeng.co'),
    'dftoutiao.com' => array('dftoutiao.com'),
    'miaozhen.com' => array('miaozhen.com'),
    'rubiconproject.com' => array('rubiconproject.com'),
    'adsame.com' => array('adsame.com'),
    'hexun.com' => array('hxsame.hexun.com'),
    '2345.com' => array('2345.com'),
    '51.la' => array('51.la'),
    '55.la' => array('55.la'),
    'ddns.name' => array('ddns.name'),
    '7clink.com' => array('7clink.com'),
    '88shu.cn' => array('88shu.cn'),
    '51yes.com' => array('51yes.com'),
    '3393.com' => array('3393.com'),
    'zedo.com' => array('zedo.com'),
    'admaster.com.cn' => array('admaster.com.cn'),
    'adpush.cn' => array('adpush.cn'),
    'adsage.com' => array('adsage.com'),
    'allyes.cn' => array('allyes.cn'),
    'allyes.com' => array('allyes.com'),
    'allyes.com.cn' => array('allyes.com.cn'),
    'baifendian.com' => array('baifendian.com'),
    'banmamedia.com' => array('banmamedia.com'),
    'behe.com' => array('behe.com'),
    'dnset.com' => array('dnset.com'),
    'yiqifa.com' => array('yiqifa.com'),
    'kankan.com' => array('cpm.cm.kankan.com', 'float.kankan.com', 'stat.kankan.com'),
    'oadz.com' => array('oadz.com'),
    'dopa.com' => array('dopa.com'),
    'dopa.com.cn' => array('dopa.com.cn'),
    'ok365.com' => array('ok365.com'),
    'adwo.com' => array('adwo.com'),
    'doubleclick.net' => array('doubleclick.net'),
    'youmi.net' => array('youmi.net'),
    'openxt.cn' => array('openxt.cn'),
    'adk2x.com' => array('adk2x.com'),
    'inmobi.com' => array('inmobi.com'),
    'alimama.cn' => array('alimama.cn'),
    'alimama.com' => array('alimama.com'),
    'appjiagu.com' => array('appjiagu.com'),
    'amazon-adsystem.com' => array('amazon-adsystem.com'),
    'adnxs.com' => array('adnxs.com'),
    'linezing.com' => array('linezing.com'),
    'atdmt.com' => array('atdmt.com'),
    'flurry.com' => array('flurry.com'),
    'adfuture.cn' => array('adfuture.cn'),
    'icast.cn' => array('icast.cn'),
    'cooguo.com' => array('cooguo.com'),
    'adsmogo.com' => array('adsmogo.com'),
    'wooboo.com.cn' => array('wooboo.com.cn'),
    'domob.cn' => array('domob.cn'),
    'advertising.com' => array('advertising.com'),
    'admob.com' => array('admob.com'),
    'appsflyer.com' => array('appsflyer.com'),
    'authedmine.com' => array('authedmine.com'),
    'coin-hive.com' => array('coin-hive.com'),
    'coinhive.com' => array('coinhive.com'),
    'igexin.com' => array('igexin.com'),
    'tanx.com' => array('tanx.com'),
    'smartadserver.com' => array('smartadserver.com'),
    'imrworldwide.com' => array('imrworldwide.com'),
    'fastclick.net' => array('fastclick.net'),
    'tourstogo.us' => array('tourstogo.us'),
    'barginginfrance.net' => array('barginginfrance.net'),
    'butlerelectricsupply.com' => array('butlerelectricsupply.com'),
    'cruisingsmallship.com' => array('cruisingsmallship.com'),
    'frost-electric-supply.com' => array('frost-electric-supply.com'),
    'iptvdeals.com' => array('iptvdeals.com'),
    'baidu.com' => array(
        'tuisong.baidu.com',
        'usp1.baidu.com',
        'sync.mobojoy.baidu.com',
        'api.mobojoy.baidu.com',
        'js.mobojoy.baidu.com',
        'plugin.mobopay.baidu.com',
    ),
    'youdao.com' => array('corp.youdao.com'),
    'crsspxl.com' => array('crsspxl.com'),
    'talkingdata.net' => array('talkingdata.net'),
    'kejet.net' => array('kejet.net'),
    'moad.cn' => array('moad.cn'),
    'images9999.com' => array('images9999.com'),
    'histats.com' => array('histats.com'),
    '51maiwanju.com' => array('51maiwanju.com'),
    'xiaomi.com' => array(
        'data.mistat.intl.xiaomi.com',
        'data.mistat.xiaomi.com',
        'ad.intl.xiaomi.com',
        'ad.xiaomi.com',
        'admob.xiaomi.com',
    ),
    'zhihu.com' => array(
        'lc-push.zhihu.com',
        'sugar.zhihu.com',
        'appcloud2.in.zhihu.com',
        'appcloud2.zhihu.com',
        'zhihu-web-analytics.zhihu.com',
        'event.zhihu.com',
    ),
    'crashlytics.com' => array(
        'crashlytics.com'
    ),
    'musical.ly' => array(
        'log2.musical.ly',
        'log.musical.ly',
        'applog.musical.ly',
    ),
    'adjust.com' => array(
        'adjust.com'
    ),
    'kuyun.com' => array(
        'kuyun.com'
    ),
    'amazon.com' => array(
        'device-messaging-na.amazon.com',
    ),
    'shareinstall.com.cn' => array(
        'shareinstall.com.cn' //移动广告商
    ),
    'apple.com' => array(
        'iadsdk.apple.com',
        'banners.itunes.apple.com',
        'iad.apple.com',
    ),
    '51y5.net' => array(
        '51y5.net', //wifi万能钥匙的推广
    ),
    'com.com' => array(
        'com.com', //来自ublock的规则，恶意域名 https://isc.sans.edu/diary/.COM.COM+Used+For+Malicious+Typo+Squatting/20019
    ),
    'consensu.org' => array(
        'consensu.org', //广告网址，例如：https://vendorlist.consensu.org/vendorlist.json
    ),
    'dnvod.tv' => array(
        'dnvod.tv', //官网显示 此域名已停止服务 游戏业务暂停运营
    ),
    'gentags.net' => array(
        'gentags.net', //第三方监测，例如：clk.gentags.net
    ),
    'mydas.mobi' => array(
        'mydas.mobi', //移动广告商
    ),
    'soarfi.cn' => array(
        'soarfi.cn',
    ),
    'starwave.com' => array(
        'starwave.com',
    ),
    'tradetracker.net' => array(
        'tradetracker.net', //广告联盟
    ),
    'uol.com.br' => array(
        'uol.com.br',
    ),
    'rambler.ru' => array(
        'rambler.ru'
    ),
    'zhanzhang.net' => array(
        'zhanzhang.net', //网络推广
    ),
    'adroll.com' => array(
        'adroll.com', //广告商
    ),
    'cnbanbao.com' => array(
        'cnbanbao.com', //网络推广
    ),
    '4u.pl' => array(
        '4u.pl', //访问统计
    ),
    'minisplat.cn' => array(
        'minisplat.cn',
    ),
    'bdurl.net' => array(
        'dig.bdurl.net', //数据收集
    ),
    'id1.cn' => array(
        'id1.cn', //钓鱼网站
    ),
    'ts166.net' => array(
        'ts166.net', //广告联盟
    ),
    'unity3d.com' => array(//u3d广告平台
        'unityads.unity3d.com',
        'cdp.cloud.unity3d.com',
        'data-optout-service.uca.cloud.unity3d.com',
        'thind-gke-euw.prd.data.corp.unity3d.com',
    ),

    'miui.com' => array(
        'hot.browser.intl.miui.com',
        'activity.browser.intl.miui.com',
        'adv.sec.intl.miui.com',
        'adv.sec.miui.com',
        'api.brs.intl.miui.com',
        'api.newsfeed.intl.miui.com',
        'huangye.miui.com',
        'browser.miui.com',

    ),
    'jd.com' => array(
        'mercury.jd.com', //大数据收集，用户行为埋点上报
        'wl.jd.com',
    ),
    'ixigua.com' => array(
        'v3-ad.ixigua.com', //移动广告
    ),
    'huan.tv' => array(
        'ads.huan.tv', //广告
    ),

    'kingsoft-office-service.com' => array(
        'abroad-ad.kingsoft-office-service.com',
    ),
    'amap.com' => array('logs.amap.com'),
    'tt114.net' => array('tt114.net'), //例如http://www.tt114.net/html/tlink.html
    'taobao.com' => array(
      'ip.taobao.com',
      'fourier.taobao.com',
      'accscdn.m.taobao.com',
      'acs.m.taobao.com',
      'acs.wapa.taobao.com',
      'openjmacs.m.taobao.com',
    ),
    'aiclk.com' => array('aiclk.com'),
    '5ubei.com' => array('5ubei.com'), //统计类例如http://dnm.5ubei.com:7098/hlink.html
    'jpush.cn' => array('jpush.cn'),
    'jpush.io' => array('jpush.io'),
    'jiguang.cn' => array('jiguang.cn'),
    'easytomessage.com' => array('easytomessage.com'), //极光SDK
    'getui.com' => array('getui.com'),
    'getui.net' => array('getui.net'),
    'jumei.com' => array('adxapi.jumei.com', 'sd.int.jumei.com', 'sd.jumei.com'),
    '92caijing.com' => array('92caijing.com'), //广告联盟
    'mm100.com' => array('mm100.com'), //广告联盟
    'juyoufan.net' => array('juyoufan.net'), //博彩类
    'hpplay.cn' => array('hpplay.cn'), //广告下发
    'supersonic.com' => array('logs.supersonic.com'), //交叉推广平台
    'advmob.cn' => array('advmob.cn'), //交叉推广平台
    'adnexus.mobi' => array('adnexus.mobi'), //广告平台
    'mobileapptracking.com' => array('mobileapptracking.com'), //广告追踪
    '360in.com' => array('360in.com'), //广告追踪
    'ad4.com.cn' => array('ad4.com.cn'), //广告商
    'adform.com' => array('adform.com'), //广告商
    'adgoji.com' => array('adgoji.com'), //广告商
    'adups.com' => array('adups.com'), //大数据收集
    'crasheye.cn' => array('crasheye.cn'), //大数据收集
    'adcome.cn' => array('adcome.cn'), //广告服务
    'adsunflower.cn' => array('adsunflower.cn'), //广告服务
    'bsclink.cn' => array('sdk.appadhoc.com.bsclink.cn'), //统计数据
    'diditaxi.com.cn' => array('static.diditaxi.com.cn'), //统计数据
    'dotui.cn' => array('dotui.cn'), //推送广告
    'droid4x.cn' => array('log.droid4x.cn', 'mtlog.droid4x.cn', 'nlog.droid4x.cn'), //日志收集
    'fmobi.cn' => array('api.sdk.fmobi.cn'), //广告sdk
    'ht55.cn' => array('ht55.cn'), //赌博恶意网址
    'huidakms.com.cn' => array('huidakms.com.cn'), //恶意网址
    'immob.cn' => array('immob.cn'), //恶意网址
    'inmobicdn.cn' => array('inmobicdn.cn'), //广告商
    'inmobicdn.com' => array('inmobicdn.com'), //广告商
    'inmobicdn.net' => array('inmobicdn.net'), //广告商
    'intely.cn' => array('intely.cn'), //营销服务商
    'lomark.cn' => array('lomark.cn'), //营销服务商
    'p0y.cn' => array('p0y.cn'), //大数据服务商
    'superads.cn' => array('superads.cn'), //广告商
    'tv2phone.cn' => array('appwall.tv2phone.cn'),
    'vivo.com.cn' => array(
      'adlog.vivo.com.cn',
      'adreq.vivo.com.cn',
      'adsdk.vivo.com.cn',
      'adsstatic.vivo.com.cn',
      'adxlog.vivo.com.cn',
      'stnetsdk.appstore.vivo.com.cn',
      'monitor-stsdk.vivo.com.cn',
      'onrt-stsdk.vivo.com.cn',
      'ort-stsdk.vivo.com.cn',
      'pnrt-stsdk.vivo.com.cn',
      'prt-stsdk.vivo.com.cn',
      'stnetsdk.vivo.com.cn',
      'stsdk.vivo.com.cn',
      'vcardsdkservice.vivo.com.cn',
    ),
    'vnet.cn' => array('vnet.cn'), //互联星空
    'wannaplay.cn' => array('h5.wannaplay.cn'), //游戏广告
    'waps.cn' => array('waps.cn'), //广告商
    'yomob.com.cn' => array('yomob.com.cn'), //移动视频广告
    'kochava.com' => array('kochava.com'), //移动大数据收集
    'supersonicads.com' => array('supersonicads.com'), //广告聚合平台
    'voodoo-ads.io' => array('voodoo-ads.io'), //广告平台
    'voodoo-analytics.io' => array('voodoo-analytics.io'), //数据收集
    'voodoo.io' => array('crosspromo.voodoo.io'), //交叉推广
    'inner-active.mobi' => array('inner-active.mobi'), //广告追踪
    'adtilt.com' => array('adtilt.com'), //隐私收集
    'nextmedia.com' => array(
        'imp.nextmedia.com', //行为追踪
        'dev.imp.nextmedia.com',
        'dev-imp.nextmedia.com',
    ),
    'sdo.com' => array(
        'aa.sdo.com',//行为追踪
        'dfp.aa.sdo.com',
        'snyu.sdo.com',
    ),
    'wasu.cn' => array(
        'acsystem.wasu.cn', //广告系统
    ),
    'sandai.net' => array(
        'cpm.cm.sandai.net', //cpm广告
    ),
    'cdndm.com' => array(
        'by.tel.cdndm.com', //行为收集
    ),
    'zol.com.cn' => array(
        'p.zol.com.cn', //统计脚本
    ),
    'adm668.com' => array( //不良投注网站
        'adm668.com',
        'www.adm668.com'
    ),
    'jiguangzhuisu.com' => array(
        'jiguangzhuisu.com', //怀疑是恶意网站，例如https://etc.jiguangzhuisu.com/701f41a599cdbf67cea081ed9abda6ee.js
        //例如 https://etc.jiguangzhuisu.com/act.html
        'etc.jiguangzhuisu.com',
    ),
    'aliyuncs.com' => array(
        'sspmiaoshuo.cn-hangzhou.log.aliyuncs.com', //日志收集
        'arms-retcode.aliyuncs.com',
    ),

    '186078.com' => array(
        'api.186078.com',
        '186078.com', //行为追踪，在https://etc.jiguangzhuisu.com/701f41a599cdbf67cea081ed9abda6ee.js
    ),

    'iask.cn' => array(
        'iask.cn', //广告服务商
        'pic.iask.cn',
    ),

    'iask.com.cn' => array(
        'iask.com.cn', //广告服务商
        'dw.iask.com.cn',
    ),

    'dushu.io' => array(
      'advertising.dushu.io', //广告域名
    ),

    'unitychina.cn' => array(
      'config.unityads.unitychina.cn',
      'unityads.unitychina.cn',
    ),

    'upltv.com' => array(
      'ads-sdk-cn.upltv.com',
      'a-sta-cn.upltv.com',
      'ads-sdk.upltv.com',
      'report-ads-sdk.upltv.com',
      'c-sta-cn.upltv.com',
    ),

    //上传分享wifi密码
    'ggsafe.com' => array(
      'ggsafe.com',
      'wifi.ggsafe.com',
    ),
    '2345.cn' => array(
        '2345.cn', //广告联盟
        'dl.2345.cn',
        'download.2345.cn',
        'houtai.2345.cn',
        'jifen.2345.cn',
        'jifendownload.2345.cn',
        'minipage.2345.cn',
        'wan.2345.cn',
        'zhushou.2345.cn',
    ),
    '19869.com' => array(
        '19869.com',
        'a.19869.com',
        'b.19869.com',
    ),
    '1drj.com' => array( //第三方劫持
        '1drj.com',
        'md.1drj.com',
        'xs.1drj.com',
    ),


    //一窝恶意劫持搞推广的域名
    'duoroumao.cn' => array(
      's.duoroumao.cn', //广告分发，例如https://s.duoroumao.cn/yxs191.js
      'duoroumao.cn',
    ),
    'geakr.com' => array(
      'geakr.com', //广告 例如：https://www.geakr.com/tkl/cp.js?channel_id=3
      'www.geakr.com',
    ),
    'qichetiemo.info' => array(
      'qichetiemo.info',
      'about.qichetiemo.info', //广告，例如 https://about.qichetiemo.info/apf/mkdjJSjcs113 ，此页面有js加密代码，应属于恶意网站
    ),
    'bbhyqp.com' => array(
      'bbhyqp.com', //“澳门真金”。。推广页面 例如 https://bbhyqp.com/mifiqp/index.html
    ),
    'sntzq.com' => array(
      'sntzq.com', //https://c.sntzq.com/init/proxy.html?v=1.2
      'c.sntzq.com',
    ),
    '35kds.com' => array(
      '35kds.com',
      'n.35kds.com', //https://n.35kds.com/Exposead/index/?re=
    ),
    'mobaders.com' => array(
        'mobaders.com', //行为统计，例如http://d1.mobaders.com/cnzzA/1260857752
        'd1.mobaders.com',
        'd2.mobaders.com',
        'd3.mobaders.com',
        'd4.mobaders.com',
        'd5.mobaders.com',
        'd6.mobaders.com',
        'd7.mobaders.com',
        'd8.mobaders.com',
        'd9.mobaders.com',
    ),
    '61677.com' => array( //澳门新葡京
        '61677.com',
        'www.61677.com',
    ),
    '111ol.com' => array(
        '111ol.com',
        'www.111ol.com',
        '111ol.111ol.com',
    ),
    '61677c.com' => array(
        '61677c.com',
    ),
    'www-61677.com' => array(
        'www-61677.com'
    ),
    '11599jgj.com' => array(
        '11599jgj.com',
        'www.11599jgj.com'
    ),
    'duote.com' => array( //https://zhuanlan.zhihu.com/p/111435102
      'duote.com',
      'www.duote.com',
    ),
    'zzb6.cn' => array(
      'zzb6.cn',
      'download.zzb6.cn',
      'i.zzb6.cn',
    ),
    'xp666.com' => array(
      'xp666.com',
      'download.xp666.com',
    ),
    'dh810.com' => array(
      'dh810.com',
    ),
    'dh820.com' => array(
      'dh820.com',
    ),
    'bsrkt.com' => array(//http://www.bsrkt.com/diy/b/commander/tips/index.html
      'bsrkt.com',
      'www.bsrkt.com'
    ),
    'zjsyawqj.cn' => array(//http://js.zjsyawqj.cn/diy/b/commander/tips/default.js
      'zjsyawqj.cn',
      'www.zjsyawqj.cn',
      'js.zjsyawqj.cn',
      'download.zjsyawqj.cn',
    ),
    'v4dwkcv.com' => array(// http://c.v4dwkcv.com/html/click/23421_5605.html
      'v4dwkcv.com',
      'c.v4dwkcv.com',
    ),
    'he2d.com' => array(// 相关http://c.v4dwkcv.com/html/click/23421_5605.html
      'ss2.he2d.com',
      'he2d.com'
    ),
    'sdqoi2d.com' => array(// 统计 http://j.sdqoi2d.com/click/ffb.php
      'j.sdqoi2d.com',
      'sdqoi2d.com'
    ),
    'youhuiguan.com' => array(// 神药？ http://cr.youhuiguan.com/attachments/201908/28/20/3658-5lmj04.jpg
      'youhuiguan.com',
      'cr.youhuiguan.com'
    ),
    'doumaibiji.cn' => array(// http://diy.doumaibiji.cn/diy/js/b.js
      'doumaibiji.cn',
      'diy.doumaibiji.cn',
    ),
    'oneplus.net' => array(
        'open.oneplus.net',
    ),
    'live.com' => array(
        'nexusrules.officeapps.live.com',
        'nexus.officeapps.live.com',
    ),
    'twitter.com' => array(
        'p.twitter.com',
    ),
    'nsimg.net' => array(
        'm2.nsimg.net'
    ),
    'microsoft.com' => array(
        'mobile.pipe.aria.microsoft.com',
        'events.data.microsoft.com',
    ),
    'leixjun.com' => array(//恶意诱导下载app
      'leixjun.com',
      'zq2.leixjun.com',
    ),
    'xi9p.com' => array(//诈骗网址
      'xi9p.com'
    ),

    'doukekan.cn' => array(//广告平台
        'doukekan.cn',
        'y3.doukekan.cn',
    ),
    'dzdkw9.cn' => array(//恶意推广 #65
        'dzdkw9.cn',
        'm.dzdkw9.cn',
    ),

    'feeddsp.cn' => array(
        '1.feeddsp.cn', //游戏推广落地页
    ),
    'huya.com' => array(
        'ylog.huya.com', // #86
    ),

    'grammarly.io' => array(
        'f-log-extension.grammarly.io',
        'f-log-mobile-ios.grammarly.io',
        'f-log-at.grammarly.io',
    ),
    'ximalaya.com' => array(
        'adse.wsa.ximalaya.com',
        'linkeye.ximalaya.com',
        'location.ximalaya.com',
    ),
    'googleapis.com' => array(
        'footprints-pa.googleapis.com',
    ),
    'ebjvu.cn' => array(
      'ebjvu.cn',
    ),
    'nvidia.com' => array(
      'events.gfe.nvidia.com'
    ),
    'axbxgg.com' => array( // 恶意推广app下载
      'axbxgg.com',
      '2ydl.axbxgg.com',
    ),
    'rayjump.com' => array( // 广告域名 #98
      'rayjump.com',
      'adx-tk.rayjump.com',
    ),
    'baicizhan.org' => array( // 百词斩
        'advertise.baicizhan.org',
    ),
    'baicizhan.com' => array( // 百词斩
        'advertise.baicizhan.com',
    ),
    'yiche.com' => array( // 易车ad
        'adx.yiche.com',
        'log.ycapp.yiche.com',
    ),
    'csheaven.com' => array( // 总结到主域名上
        'csheaven.com',
    ),
    'bckrono.cn' => array( // 恶意跳转下载app
        'bckrono.cn',
        'js.bckrono.cn',
    ),
    'yemnn.cn' => array( // 恶意跳转下载app
        'yemnn.cn',
    ),
    'familytaste.cn' => array( // 恶意跳转下载app
        'familytaste.cn',
        's350.familytaste.cn',
    ),
    'iyfsearch.com' => array(
        'iyfsearch.com',
    ),
    'click.com.cn' => array(
        'click.com.cn',
    ),























    //一些电视盒子相关的屏蔽列表
    'tuiapple.com' => array('activity.tuiapple.com'),
    'tudou.com' => array('ad.api.3g.tudou.com'),
    'youku.com' => array('ad.api.3g.youku.com', 'ad.api.mobile.youku.com'),
    'sohu.com' => array('agn.aty.sohu.com'),
    'gitv.tv' => array('api.cupid.ptqy.gitv.tv'),
    'tatagou.com.cn' => array('api.tatagou.com.cn'),
    'shandjj.com' => array('app.shandjj.com'),
    'koudaitong.com' => array('tj.koudaitong.com'),

    '011211.cn' => array('011211.cn'),
    '013572.cn' => array('013572.cn'),
    '020wujin.cn' => array('020wujin.cn'),
    '0512pifa.com.cn' => array('0512pifa.com.cn'),
    '0591jiajiao.com.cn' => array('0591jiajiao.com.cn'),
    '1357902.cn' => array('1357902.cn'),
    '1haows.cn' => array('1haows.cn'),
    '4008813318.com.cn' => array('4008813318.com.cn'),
    '431.red' => array('431.red'),
    '43gw.cn' => array('43gw.cn'),
    '467.red' => array('467.red'),
    '51juejinjie.com.cn' => array('51juejinjie.com.cn'),
    '555vps.cn' => array('555vps.cn'),
    '58xiao.cn' => array('58xiao.cn'),
    '77av.cn' => array('77av.cn'),
    '77tianxu.cn' => array('77tianxu.cn'),
    '77vip.wang' => array('77vip.wang'),
    '7ssw.cn' => array('7ssw.cn'),
    '7x-star.info' => array('7x-star.info'),
    '8020home.com.cn' => array('8020home.com.cn'),
    '805.red' => array('805.red'),
    '815ss.cn' => array('815ss.cn'),
    '8pay.wang' => array('8pay.wang'),
    '964ka.cn' => array('964ka.cn'),
    '98hx.cn' => array('98hx.cn'),
    'aaayc.cn' => array('aaayc.cn'),
    'abtao.wang' => array('abtao.wang'),
    'ahksqc.com.cn' => array('ahksqc.com.cn'),
    'ahxhny.cn' => array('ahxhny.cn'),
    'aibantian.cn' => array('aibantian.cn'),
    'aiia.xin' => array('aiia.xin'),
    'aiks.wang' => array('aiks.wang'),
    'aipu.mobi' => array('aipu.mobi'),
    'aivento.cn' => array('aivento.cn'),
    'aiwenyisheng.mobi' => array('aiwenyisheng.mobi'),
    'aixintou.com.cn' => array('aixintou.com.cn'),
    'amao.mobi' => array('amao.mobi'),
    'aup.mobi' => array('aup.mobi'),
    'baichuanbi.wang' => array('baichuanbi.wang'),
    'barrister.org.cn' => array('barrister.org.cn'),
    'baseniao.com.cn' => array('baseniao.com.cn'),
    'baxt.mobi' => array('baxt.mobi'),
    'beiyu.xin' => array('beiyu.xin'),
    'benniuluntai.cn' => array('benniuluntai.cn'),
    'bjhjw.com.cn' => array('bjhjw.com.cn'),
    'blood23.cn' => array('blood23.cn'),
    'bsmakeup.com.cn' => array('bsmakeup.com.cn'),
    'bzcjy.cn' => array('bzcjy.cn'),
    'calarm.info' => array('calarm.info'),
    'callmewx.cn' => array('callmewx.cn'),
    'cangshu.info' => array('cangshu.info'),
    'canwi.mobi' => array('canwi.mobi'),
    'cdshusen.cn' => array('cdshusen.cn'),
    'cdxjt.mobi' => array('cdxjt.mobi'),
    'chaoxianleather.ltd' => array('chaoxianleather.ltd'),
    'chengjie168.com.cn' => array('chengjie168.com.cn'),
    'chenyayun.com.cn' => array('chenyayun.com.cn'),
    'china-oxygen.cn' => array('china-oxygen.cn'),
    'china99315.cn' => array('china99315.cn'),
    'chinae.mobi' => array('chinae.mobi'),
    'chinapsj.com.cn' => array('chinapsj.com.cn'),
    'chinapulverizer.com.cn' => array('chinapulverizer.com.cn'),
    'chinaqirun.cn' => array('chinaqirun.cn'),
    'chinaso.red' => array('chinaso.red'),
    'chinaxiedu.cn' => array('chinaxiedu.cn'),
    'chuanmen.mobi' => array('chuanmen.mobi'),
    'codetips.wang' => array('codetips.wang'),
    'cqmjjx.cn' => array('cqmjjx.cn'),
    'crystalmart.cn' => array('crystalmart.cn'),
    'cs-bailing.com.cn' => array('cs-bailing.com.cn'),
    'cstmedia.com.cn' => array('cstmedia.com.cn'),
    'curtainsky.wang' => array('curtainsky.wang'),
    'cxlm.net.cn' => array('cxlm.net.cn'),
    'cyp889.cn' => array('cyp889.cn'),
    'cz4444.cn' => array('cz4444.cn'),
    'dashantechan.cn' => array('dashantechan.cn'),
    'dat.red' => array('dat.red'),
    'dhouse.mobi' => array('dhouse.mobi'),
    'diaoguoshi.mobi' => array('diaoguoshi.mobi'),
    'dinuojixie.com.cn' => array('dinuojixie.com.cn'),
    'dnjj.mobi' => array('dnjj.mobi'),
    'dspack.com.cn' => array('dspack.com.cn'),
    'dzhss.cn' => array('dzhss.cn'),
    'edmontonlife.info' => array('edmontonlife.info'),
    'eduace.com.cn' => array('eduace.com.cn'),
    'eyewand.cn' => array('eyewand.cn'),
    'fadian.xin' => array('fadian.xin'),
    'fanjis.cn' => array('fanjis.cn'),
    'fashion-hat.cn' => array('fashion-hat.cn'),
    'fdkjt.cn' => array('fdkjt.cn'),
    'feiyun.info' => array('feiyun.info'),
    'fhfg.net.cn' => array('fhfg.net.cn'),
    'fjs043.cn' => array('fjs043.cn'),
    'fjs056.cn' => array('fjs056.cn'),
    'forgot.mobi' => array('forgot.mobi'),
    'freestudio.info' => array('freestudio.info'),
    'fy6x8o.cn' => array('fy6x8o.cn'),
    'fzojq.info' => array('fzojq.info'),
    'getmos.cn' => array('getmos.cn'),
    'gjh111.cn' => array('gjh111.cn'),
    'glnvdc.cn' => array('glnvdc.cn'),
    'gpscard.cn' => array('gpscard.cn'),
    'greenprints.org.cn' => array('greenprints.org.cn'),
    'gsgqwl.wang' => array('gsgqwl.wang'),
    'gtlp.net.cn' => array('gtlp.net.cn'),
    'gzjtfzs.cn' => array('gzjtfzs.cn'),
    'gzmcjt.cn' => array('gzmcjt.cn'),
    'gzqczl.cn' => array('gzqczl.cn'),
    'gzsadlmy.cn' => array('gzsadlmy.cn'),
    'hanhooo.cn' => array('hanhooo.cn'),
    'haoduoyi1688.cn' => array('haoduoyi1688.cn'),
    'haoeat.info' => array('haoeat.info'),
    'haoyangmao.ltd' => array('haoyangmao.ltd'),
    'haoyoushuo.cn' => array('haoyoushuo.cn'),
    'hbyinzhibao.cn' => array('hbyinzhibao.cn'),
    'hccwwz.cn' => array('hccwwz.cn'),
    'heimi.red' => array('heimi.red'),
    'helove.xyz' => array('helove.xyz'),
    'hihufu.cn' => array('hihufu.cn'),
    'hktedu.site' => array('hktedu.site'),
    'hnwlyy.com.cn' => array('hnwlyy.com.cn'),
    'hongze.info' => array('hongze.info'),
    'hot-stories.cn' => array('hot-stories.cn'),
    'hskj88.cn' => array('hskj88.cn'),
    'htnote.info' => array('htnote.info'),
    'huanbao110.com.cn' => array('huanbao110.com.cn'),
    'huanbaoxiangmu.xyz' => array('huanbaoxiangmu.xyz'),
    'huangdao.info' => array('huangdao.info'),
    'huaqikonggu.com.cn' => array('huaqikonggu.com.cn'),
    'huaqiss.cn' => array('huaqiss.cn'),
    'huayiav.cn' => array('huayiav.cn'),
    'huha.ink' => array('huha.ink'),
    'huilian.info' => array('huilian.info'),
    'hundun.mobi' => array('hundun.mobi'),
    'hupuzhibo.cn' => array('hupuzhibo.cn'),
    'hygqtz.cn' => array('hygqtz.cn'),
    'hzdhr.cn' => array('hzdhr.cn'),
    'ib00.cn' => array('ib00.cn'),
    'imzhide.net.cn' => array('imzhide.net.cn'),
    'iqyewu.cn' => array('iqyewu.cn'),
    'iyumiao.com.cn' => array('iyumiao.com.cn'),
    'japheth.com.cn' => array('japheth.com.cn'),
    'jbcbio.cn' => array('jbcbio.cn'),
    'jhbsq.cn' => array('jhbsq.cn'),
    'jiaxinkang.cn' => array('jiaxinkang.cn'),
    'jingyixueyuan.cn' => array('jingyixueyuan.cn'),
    'jinlanqiangyi.cn' => array('jinlanqiangyi.cn'),
    'jiuaixianzhi.mobi' => array('jiuaixianzhi.mobi'),
    'jmait.cn' => array('jmait.cn'),
    'jmogo.cn' => array('jmogo.cn'),
    'jnykjgs.cn' => array('jnykjgs.cn'),
    'jpuv.cn' => array('jpuv.cn'),
    'jqki.cn' => array('jqki.cn'),
    'jsjs.pro' => array('jsjs.pro'),
    'judantech.site' => array('judantech.site'),
    'jxqfu.cn' => array('jxqfu.cn'),
    'jxss88.mobi' => array('jxss88.mobi'),
    'jyzmsy.com.cn' => array('jyzmsy.com.cn'),
    'kcvc.com.cn' => array('kcvc.com.cn'),
    'kedeng.xin' => array('kedeng.xin'),
    'king-oak.cn' => array('king-oak.cn'),
    'kocom.mobi' => array('kocom.mobi'),
    'kuaica.info' => array('kuaica.info'),
    'kuaidifeng.cn' => array('kuaidifeng.cn'),
    'l520.ltd' => array('l520.ltd'),
    'lafontainedessenterue.cn' => array('lafontainedessenterue.cn'),
    'lcr.kim' => array('lcr.kim'),
    'lcyt.info' => array('lcyt.info'),
    'ledian.pro' => array('ledian.pro'),
    'lightblue.red' => array('lightblue.red'),
    'lilangdianqi.cn' => array('lilangdianqi.cn'),
    'limkokwing-edu.cn' => array('limkokwing-edu.cn'),
    'lindawei.cn' => array('lindawei.cn'),
    'littlebee.site' => array('littlebee.site'),
    'liuguoyu.wang' => array('liuguoyu.wang'),
    'lixincxy.cn' => array('lixincxy.cn'),
    'llanotextiles.cn' => array('llanotextiles.cn'),
    'lningcity.com.cn' => array('lningcity.com.cn'),
    'lnjseq.info' => array('lnjseq.info'),
    'lnsbhzy.cn' => array('lnsbhzy.cn'),
    'lovecar.net.cn' => array('lovecar.net.cn'),
    'lulumao.com.cn' => array('lulumao.com.cn'),
    'lumeo.cn' => array('lumeo.cn'),
    'luomanzhubao.cn' => array('luomanzhubao.cn'),
    'lvxingxian.cn' => array('lvxingxian.cn'),
    'lwfw88.cn' => array('lwfw88.cn'),
    'lygnasa.cn' => array('lygnasa.cn'),
    'lytrjx.cn' => array('lytrjx.cn'),
    'lyzon.com.cn' => array('lyzon.com.cn'),
    'meigeer.com.cn' => array('meigeer.com.cn'),
    'menghuanzhilv.cn' => array('menghuanzhilv.cn'),
    'mifun.mobi' => array('mifun.mobi'),
    'murroliving.com.cn' => array('murroliving.com.cn'),
    'myzhuanghe.cn' => array('myzhuanghe.cn'),
    'nankuan.xin' => array('nankuan.xin'),
    'newweb.top' => array('newweb.top'),
    'newwiesdom.com.cn' => array('newwiesdom.com.cn'),
    'newzheng.cn' => array('newzheng.cn'),
    'ngtraveler.com.cn' => array('ngtraveler.com.cn'),
    'opai.red' => array('opai.red'),
    'opto-22.com.cn' => array('opto-22.com.cn'),
    'oxi23.cn' => array('oxi23.cn'),
    'pdiinfo.com.cn' => array('pdiinfo.com.cn'),
    'pdsxp.cn' => array('pdsxp.cn'),
    'penglei.info' => array('penglei.info'),
    'phjml.cn' => array('phjml.cn'),
    'pilipala.info' => array('pilipala.info'),
    'pszs388.cn' => array('pszs388.cn'),
    'qhsyg.top' => array('qhsyg.top'),
    'qianwei.wang' => array('qianwei.wang'),
    'qianyilamian.cn' => array('qianyilamian.cn'),
    'qichacha.ink' => array('qichacha.ink'),
    'qincai.info' => array('qincai.info'),
    'qishituan.top' => array('qishituan.top'),
    'qiyeit.com.cn' => array('qiyeit.com.cn'),
    'qkxlyg.cn' => array('qkxlyg.cn'),
    'qmin.xin' => array('qmin.xin'),
    'qnvljz.info' => array('qnvljz.info'),
    'qqwlfm.cn' => array('qqwlfm.cn'),
    'qrtjwa.cn' => array('qrtjwa.cn'),
    'samevay.com.cn' => array('samevay.com.cn'),
    'sapwells.info' => array('sapwells.info'),
    'scdcd333.cn' => array('scdcd333.cn'),
    'scfans.cn' => array('scfans.cn'),
    'scfw.wang' => array('scfw.wang'),
    'scifc.mobi' => array('scifc.mobi'),
    'sdlzmm.cn' => array('sdlzmm.cn'),
    'sdyongyan.com.cn' => array('sdyongyan.com.cn'),
    'shanyi.info' => array('shanyi.info'),
    'shinedaily.cn' => array('shinedaily.cn'),
    'shkunjia.com.cn' => array('shkunjia.com.cn'),
    'shoujiawang.cn' => array('shoujiawang.cn'),
    'shouyili.mobi' => array('shouyili.mobi'),
    'sjdjcn.cn' => array('sjdjcn.cn'),
    'smart-way2.com.cn' => array('smart-way2.com.cn'),
    'smmx3.cn' => array('smmx3.cn'),
    'sobin.wang' => array('sobin.wang'),
    'spreadable.com.cn' => array('spreadable.com.cn'),
    'sscjchina.com.cn' => array('sscjchina.com.cn'),
    'steeltrader.com.cn' => array('steeltrader.com.cn'),
    'sunderport.com.cn' => array('sunderport.com.cn'),
    'suntechauto.com.cn' => array('suntechauto.com.cn'),
    'sxjcjdc.cn' => array('sxjcjdc.cn'),
    'sxltfj.cn' => array('sxltfj.cn'),
    'szmpc.cn' => array('szmpc.cn'),
    'taihe2002.cn' => array('taihe2002.cn'),
    'tanzhen.info' => array('tanzhen.info'),
    'taogou.site' => array('taogou.site'),
    'tastevision.cn' => array('tastevision.cn'),
    'techkey.com.cn' => array('techkey.com.cn'),
    'tianhuicun.com.cn' => array('tianhuicun.com.cn'),
    'titan-solar.cn' => array('titan-solar.cn'),
    'tkmly.cn' => array('tkmly.cn'),
    'todayjiaxiang.cn' => array('todayjiaxiang.cn'),
    'tradesoul.cn' => array('tradesoul.cn'),
    'tuoens.cn' => array('tuoens.cn'),
    'txtxz.org.cn' => array('txtxz.org.cn'),
    'udr26c.cn' => array('udr26c.cn'),
    'uk8866.cn' => array('uk8866.cn'),
    'vaniok.cn' => array('vaniok.cn'),
    'vpkq.cn' => array('vpkq.cn'),
    'wangjinhu.wang' => array('wangjinhu.wang'),
    'wangzhichao.info' => array('wangzhichao.info'),
    'weilang.site' => array('weilang.site'),
    'wimaxnetworks.cn' => array('wimaxnetworks.cn'),
    'wojiacanting.info' => array('wojiacanting.info'),
    'wpe.red' => array('wpe.red'),
    'wtorain.red' => array('wtorain.red'),
    'wucheng.info' => array('wucheng.info'),
    'wzfjsh.cn' => array('wzfjsh.cn'),
    'wzhagc.cn' => array('wzhagc.cn'),
    'x1ka.cn' => array('x1ka.cn'),
    'xcvf.info' => array('xcvf.info'),
    'xiaocai-rookie.info' => array('xiaocai-rookie.info'),
    'xiaomeihq.info' => array('xiaomeihq.info'),
    'xinshengchuanmei.cn' => array('xinshengchuanmei.cn'),
    'xinyikeji.red' => array('xinyikeji.red'),
    'xmglass.cn' => array('xmglass.cn'),
    'xuexingkeji.cn' => array('xuexingkeji.cn'),
    'xxdlg.cn' => array('xxdlg.cn'),
    'xz518.cn' => array('xz518.cn'),
    'xztyzs.cn' => array('xztyzs.cn'),
    'yanhao.red' => array('yanhao.red'),
    'yaxujiancai.cn' => array('yaxujiancai.cn'),
    'ych168.cn' => array('ych168.cn'),
    'ycreateam.cn' => array('ycreateam.cn'),
    'ycx.kim' => array('ycx.kim'),
    'yglhcn.cn' => array('yglhcn.cn'),
    'ygpd.wang' => array('ygpd.wang'),
    'yimingxiang.com.cn' => array('yimingxiang.com.cn'),
    'yiqifaxian.wang' => array('yiqifaxian.wang'),
    'yiqiu.mobi' => array('yiqiu.mobi'),
    'yisheng120.info' => array('yisheng120.info'),
    'yizhongyi.info' => array('yizhongyi.info'),
    'ynyfcz.cn' => array('ynyfcz.cn'),
    'yppw666.cn' => array('yppw666.cn'),
    'yucefa.cn' => array('yucefa.cn'),
    'yw78.cn' => array('yw78.cn'),
    'yybeast.mobi' => array('yybeast.mobi'),
    'zghs.net.cn' => array('zghs.net.cn'),
    'zgjckgys.com.cn' => array('zgjckgys.com.cn'),
    'zhaowaibao.mobi' => array('zhaowaibao.mobi'),
    'zhougong.info' => array('zhougong.info'),
    'zhuren.site' => array('zhuren.site'),
    'zioe.com.cn' => array('zioe.com.cn'),
    'ziyouxiaoyuan.cn' => array('ziyouxiaoyuan.cn'),
    'zq-hk.cn' => array('zq-hk.cn'),
    'zsdzcpw.mobi' => array('zsdzcpw.mobi'),
    'zswhcsfww.mobi' => array('zswhcsfww.mobi'),
    'zszgjiejuw.mobi' => array('zszgjiejuw.mobi'),
    'zzasj.cn' => array('zzasj.cn'),
    'zzhssy.cn' => array('zzhssy.cn'),
    '158aq.com' => array('158aq.com'),
    '166br.com' => array('166br.com'),
    '2yt.cn' => array('2yt.cn'),
    '322927.com' => array('322927.com'),
    '559gp.com' => array('559gp.com'),
    'adszui.com' => array('adszui.com'),
    'baimuyuan.com.cn' => array('baimuyuan.com.cn'),
    'bibi100.com' => array('bibi100.com'),
    'bjsncykyjctsbjxzx.cn' => array('bjsncykyjctsbjxzx.cn'),
    'bontech-zh.com' => array('bontech-zh.com'),
    'bxg68.com' => array('bxg68.com'),
    'd9ad.com' => array('d9ad.com'),
    'dapaogg.xyz' => array('dapaogg.xyz'),
    'dreamine.com' => array('dreamine.com'),
    'duoduo.net' => array('duoduo.net'),
    'eeeqi.cn' => array('eeeqi.cn'),
    'fxsqsng.com' => array('fxsqsng.com'),
    'lee789.com' => array('lee789.com'),
    'loupan99.com' => array('loupan99.com'),
    'lrswl.com' => array('lrswl.com'),
    'myhard.com' => array('myhard.com'),
    'pagechoice.com' => array('pagechoice.com'),
    'pee.cn' => array('pee.cn'),
    'tenoad.com' => array('tenoad.com'),
    'itruni.com' => array('itruni.com'),
    'ucoz.com' => array('ucoz.com'),
    'union001.com' => array('union001.com'),
    'xiankandy.com' => array('xiankandy.com'),
    'xifatime.com' => array('xifatime.com'),
    'yjkyj.cn' => array('yjkyj.cn'),
    'zamar.cn' => array('zamar.cn'),


);
