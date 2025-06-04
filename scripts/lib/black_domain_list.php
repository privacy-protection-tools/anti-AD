<?php
//黑名单域名，即直接封杀主域名，效果就是只要是使用该域名及其下级所有域名的请求全部被阻挡，慎重使用

//这个文件主要定义针对hosts文件中不能泛域名解析而优化减少生成行数
//对于个性化屏蔽的域名，全部移动到block_domains.root.conf中管理
// Formatter: https://www.duplichecker.com/php-formatter

return [
    "f2pool.com" => ["openvpn.f2pool.com"],
    "gepush.com" => ["gepush.com"],
    "cnzz.com" => ["cnzz.com"],
    "cnzz.net" => ["cnzz.net"],
    "cnzz.cn" => ["cnzz.cn"],
    "inmobi.cn" => ["inmobi.cn"],
    "aliapp.org" => ["aliapp.org"],
    "snssdk.com" => [
        "bds.snssdk.com",
        "xlog.snssdk.com",
        "gecko.snssdk.com", // #989
    ],
    "51togic.com" => [
        "customstat.video.51togic.com",
        "ad.video.51togic.com",
        "backup.customstat.video.51togic.com",
    ],
    "amazonaws.com" => [
        "checkip.amazonaws.com", //获取真实外网ip接口
    ],
    "irs03.com" => ["irs03.com"],
    "bcelive.com" => [
        "httpdns.bcelive.com", //一个不支持https的httpdns服务，并不能反制运营商劫持
    ],
    "tencentmusic.com" => ["ad.tencentmusic.com"],
    "tencent.com" => [
        "tpstelemetry.tencent.com", // #883
        "report.meeting.tencent.com", // #966
    ],
    "qq.com" => [
        "bugly.qq.com",
        "openmsf.3g.qq.com",
        "mtrace.qq.com",
        "btrace.qq.com",
        "mark.l.qq.com",
        "report.qq.com",
        "rcgi.video.qq.com",
        "rlog.video.qq.com",
        "ad.browser.qq.com", // #682
        "rdelivery.qq.com", // #764
        "aedns.weixin.qq.com", // #764
        "date.ab.qq.com", // #764
        "report.nfa.qq.com", // #764
        "wnsmusic.qq.com", // #847
        "tmeadbak.y.qq.com", // #847
        "ugcup.music.qq.com", // #847
        "ipv6.kg.qq.com", // #847
        "log.node.minigame.qq.com", // #1012
    ],
    "openstorage.cn" => ["iflyad.bjb.openstorage.cn"],
    "analysys.cn" => ["analysys.cn"],
    "mob.com" => [
        "mob.com",
        "cache-verify.mob.com", // #971
        "cdn-api-verify.mob.com", // #971
        "log-verify.mob.com", // #971
    ],
    "szy.cn" => ["dtlog.szy.cn"],
    "adview.cn" => ["adview.cn"],
    "wrating.com" => ["wrating.com"],
    "umengcloud.com" => ["umengcloud.com", "ulogs.umengcloud.com"],
    "umeng.com" => [
        "umeng.com",
        "alogs.umeng.com",
        "utoken.umeng.com", // #1006
    ],
    "umeng.co" => ["umeng.co"],
    "dftoutiao.com" => ["dftoutiao.com"],
    "miaozhen.com" => ["miaozhen.com"],
    "rubiconproject.com" => ["rubiconproject.com"],
    "adsame.com" => ["adsame.com"],
    "hexun.com" => ["hxsame.hexun.com"],
    "2345.com" => ["2345.com"],
    "51.la" => ["51.la"],
    "ddns.name" => ["ddns.name"],
    "7clink.com" => ["7clink.com"],
    "88shu.cn" => ["88shu.cn"],
    "51yes.com" => ["51yes.com"],
    "3393.com" => ["3393.com"],
    "zedo.com" => ["zedo.com"],
    "admaster.com.cn" => ["admaster.com.cn"],
    "adpush.cn" => ["adpush.cn"],
    "adsage.com" => ["adsage.com"],
    "allyes.cn" => ["allyes.cn"],
    "allyes.com" => ["allyes.com"],
    "allyes.com.cn" => ["allyes.com.cn"],
    "baifendian.com" => ["baifendian.com"],
    "banmamedia.com" => ["banmamedia.com"],
    "behe.com" => ["behe.com"],
    "dnset.com" => ["dnset.com"],
    "yiqifa.com" => ["yiqifa.com"],
    "kankan.com" => ["float.kankan.com", "stat.kankan.com"],
    "oadz.com" => ["oadz.com"],
    "dopa.com" => ["dopa.com"],
    "dopa.com.cn" => ["dopa.com.cn"],
    "ok365.com" => ["ok365.com"],
    "adwo.com" => ["adwo.com"],
    "doubleclick.net" => ["doubleclick.net"],
    "youmi.net" => ["youmi.net"],
    "openxt.cn" => ["openxt.cn"],
    "adk2x.com" => ["adk2x.com"],
    "inmobi.com" => ["inmobi.com"],
    "alimama.cn" => ["alimama.cn"],
    "appjiagu.com" => ["appjiagu.com"],
    "amazon-adsystem.com" => ["amazon-adsystem.com"],
    "adnxs.com" => ["adnxs.com"],
    "linezing.com" => ["linezing.com"],
    "atdmt.com" => ["atdmt.com"],
    "flurry.com" => ["flurry.com"],
    "adfuture.cn" => ["adfuture.cn"],
    "icast.cn" => ["icast.cn"],
    "cooguo.com" => ["cooguo.com"],
    "adsmogo.com" => ["adsmogo.com"],
    "wooboo.com.cn" => ["wooboo.com.cn"],
    "domob.cn" => ["domob.cn"],
    "advertising.com" => ["advertising.com"],
    "admob.com" => ["admob.com"],
    "appsflyer.com" => ["appsflyer.com"],
    "authedmine.com" => ["authedmine.com"],
    "coin-hive.com" => ["coin-hive.com"],
    "coinhive.com" => ["coinhive.com"],
    "igexin.com" => ["igexin.com"],
    "tanx.com" => ["tanx.com"],
    "smartadserver.com" => ["smartadserver.com"],
    "imrworldwide.com" => ["imrworldwide.com"],
    "fastclick.net" => ["fastclick.net"],
    "tourstogo.us" => ["tourstogo.us"],
    "barginginfrance.net" => ["barginginfrance.net"],
    "butlerelectricsupply.com" => ["butlerelectricsupply.com"],
    "cruisingsmallship.com" => ["cruisingsmallship.com"],
    "frost-electric-supply.com" => ["frost-electric-supply.com"],
    "iptvdeals.com" => ["iptvdeals.com"],
    "baidu.com" => [
        "tuisong.baidu.com",
        "usp1.baidu.com",
        "sync.mobojoy.baidu.com",
        "api.mobojoy.baidu.com",
        "js.mobojoy.baidu.com",
        "plugin.mobopay.baidu.com",
        "dj1.baidu.com",
        "isite.baidu.com",
        "sjh.baidu.com", #367
    ],
    "youdao.com" => ["corp.youdao.com"],
    "crsspxl.com" => ["crsspxl.com"],
    "kejet.net" => ["kejet.net"],
    "moad.cn" => ["moad.cn"],
    "images9999.com" => ["images9999.com"],
    "histats.com" => ["histats.com"],
    "51maiwanju.com" => ["51maiwanju.com"],
    "xiaomi.com" => [
        "data.mistat.intl.xiaomi.com",
        "data.mistat.xiaomi.com",
        "ad.intl.xiaomi.com",
        "ad.xiaomi.com",
        "admob.xiaomi.com",
        "tz.sec.xiaomi.com", // #885
    ],
    "zhihu.com" => [
        "lc-push.zhihu.com",
        "sugar.zhihu.com",
        "appcloud2.in.zhihu.com",
        "zhihu-web-analytics.zhihu.com",
        "event.zhihu.com",
        "udd1i5.zhihu.com", #395
    ],
    "crashlytics.com" => ["crashlytics.com"],
    "musical.ly" => ["log2.musical.ly", "log.musical.ly", "applog.musical.ly"],
    "adjust.com" => ["adjust.com"],
    "kuyun.com" => ["kuyun.com"],
    "shareinstall.com.cn" => [
        "shareinstall.com.cn", //移动广告商
    ],
    "apple.com" => [
        "iadsdk.apple.com",
        "banners.itunes.apple.com",
        "iad.apple.com",
        "api-adservices.apple.com", // #864
    ],
    "51y5.net" => [
        "51y5.net", //wifi万能钥匙的推广
    ],
    "com.com" => [
        "com.com", //来自ublock的规则，恶意域名 https://isc.sans.edu/diary/.COM.COM+Used+For+Malicious+Typo+Squatting/20019
    ],
    "consensu.org" => [
        "consensu.org", //广告网址，例如：https://vendorlist.consensu.org/vendorlist.json
    ],
    "dnvod.tv" => [
        "dnvod.tv", //官网显示 此域名已停止服务 游戏业务暂停运营
    ],
    "gentags.net" => [
        "gentags.net", //第三方监测，例如：clk.gentags.net
    ],
    "mydas.mobi" => [
        "mydas.mobi", //移动广告商
    ],
    "soarfi.cn" => ["soarfi.cn"],
    "starwave.com" => ["starwave.com"],
    "tradetracker.net" => [
        "tradetracker.net", //广告联盟
    ],
    "rambler.ru" => ["rambler.ru"],
    "zhanzhang.net" => [
        "zhanzhang.net", //网络推广
    ],
    "adroll.com" => [
        "adroll.com", //广告商
    ],
    "cnbanbao.com" => [
        "cnbanbao.com", //网络推广
    ],
    "4u.pl" => [
        "4u.pl", //访问统计
    ],
    "minisplat.cn" => ["minisplat.cn"],
    "id1.cn" => [
        "id1.cn", //钓鱼网站
    ],
    "ts166.net" => [
        "ts166.net", //广告联盟
    ],
    "unity3d.com" => [
        //u3d广告平台
        "unityads.unity3d.com",
        "cdp.cloud.unity3d.com",
        "data-optout-service.uca.cloud.unity3d.com",
        "thind-gke-euw.prd.data.corp.unity3d.com",
    ],

    "miui.com" => [
        "hot.browser.intl.miui.com",
        "activity.browser.intl.miui.com",
        "adv.sec.intl.miui.com",
        "adv.sec.miui.com",
        "api.brs.intl.miui.com",
        "api.newsfeed.intl.miui.com",
    ],
    "jd.com" => [
        "mercury.jd.com", //大数据收集，用户行为埋点上报
        "wl.jd.com",
        "blackhole.m.jd.com", // #428
        "firevent.jd.com", // #428
    ],
    "ixigua.com" => [
        "v1-ad.ixigua.com",
        "v3-ad.ixigua.com", //移动广告
        "v6-ad.ixigua.com",
        "v9-ad.ixigua.com",
        "v1-dc-ad.ixigua.com",
        "v3-dc-ad.ixigua.com",
        "v6-dc-ad.ixigua.com",
        "v9-dc-ad.ixigua.com",
    ],
    "huan.tv" => [
        "ads.huan.tv", //广告
    ],

    "kingsoft-office-service.com" => ["abroad-ad.kingsoft-office-service.com"],
    "amap.com" => [
        "logs.amap.com",
        "dualstack-logs.amap.com",
        "v6-adashx.ut.amap.com",
        "h-adashx.ut.amap.com", // #1026
    ],
    "tt114.net" => ["tt114.net"], //例如http://www.tt114.net/html/tlink.html
    "taobao.com" => [
        "ip.taobao.com",
        "fourier.taobao.com",
        "accscdn.m.taobao.com",
        "acs.m.taobao.com",
        "acs.wapa.taobao.com",
        "openjmacs.m.taobao.com",
        "v6-adashx.ut.taobao.com", // #859
        "wcp.taobao.com", // #847
        "gaode-jmacs.m.taobao.com", // #989
    ],
    "aiclk.com" => ["aiclk.com"],
    "5ubei.com" => ["5ubei.com"], //统计类例如http://dnm.5ubei.com:7098/hlink.html
    "jpush.cn" => ["jpush.cn"],
    "jpush.io" => ["jpush.io"],
    "jiguang.cn" => ["jiguang.cn"],
    "easytomessage.com" => ["easytomessage.com"], //极光SDK
    "getui.com" => ["getui.com"],
    "getui.net" => ["getui.net"],
    "jumei.com" => ["adxapi.jumei.com", "sd.int.jumei.com", "sd.jumei.com"],
    "92caijing.com" => ["92caijing.com"], //广告联盟
    "mm100.com" => ["mm100.com"], //广告联盟
    "juyoufan.net" => ["juyoufan.net"], //博彩类
    "hpplay.cn" => [
        "imdns.hpplay.cn",
        "vipauth.hpplay.cn",
        "sl.hpplay.cn",
        "hotupgrade.hpplay.cn",
        "tvapp.hpplay.cn",
        "image.hpplay.cn",
        "gslb.hpplay.cn",
        "adeng.hpplay.cn",
        "conf.hpplay.cn",
        "adcdn.hpplay.cn",
        "pin.hpplay.cn",
        "rp.hpplay.cn",
    ], //广告下发 #306
    "hpplay.com.cn" => [
        #306
        "h5.hpplay.com.cn",
        "cdn.hpplay.com.cn",
    ],
    "cibn.cc" => [
        #306
        "hpplay.cdn.cibn.cc",
    ],
    "supersonic.com" => ["logs.supersonic.com"], //交叉推广平台
    "advmob.cn" => ["advmob.cn"], //交叉推广平台
    "adnexus.mobi" => ["adnexus.mobi"], //广告平台
    "mobileapptracking.com" => ["mobileapptracking.com"], //广告追踪
    "360in.com" => ["360in.com"], //广告追踪
    "ad4.com.cn" => ["ad4.com.cn"], //广告商
    "adform.com" => ["adform.com"], //广告商
    "adgoji.com" => ["adgoji.com"], //广告商
    "adups.com" => ["adups.com"], //大数据收集
    "crasheye.cn" => ["crasheye.cn"], //大数据收集
    "adcome.cn" => ["adcome.cn"], //广告服务
    "adsunflower.cn" => ["adsunflower.cn"], //广告服务
    "bsclink.cn" => ["sdk.appadhoc.com.bsclink.cn"], //统计数据
    "diditaxi.com.cn" => ["static.diditaxi.com.cn"], //统计数据
    "dotui.cn" => ["dotui.cn"], //推送广告
    "droid4x.cn" => ["log.droid4x.cn", "mtlog.droid4x.cn", "nlog.droid4x.cn"], //日志收集
    "fmobi.cn" => ["api.sdk.fmobi.cn"], //广告sdk
    "ht55.cn" => ["ht55.cn"], //赌博恶意网址
    "huidakms.com.cn" => ["huidakms.com.cn"], //恶意网址
    "immob.cn" => ["immob.cn"], //恶意网址
    "inmobicdn.cn" => ["inmobicdn.cn"], //广告商
    "inmobicdn.com" => ["inmobicdn.com"], //广告商
    "inmobicdn.net" => ["inmobicdn.net"], //广告商
    "intely.cn" => ["intely.cn"], //营销服务商
    "lomark.cn" => ["lomark.cn"], //营销服务商
    "p0y.cn" => ["p0y.cn"], //大数据服务商
    "superads.cn" => ["superads.cn"], //广告商
    "tv2phone.cn" => ["appwall.tv2phone.cn"],
    "vivo.com.cn" => [
        "adlog.vivo.com.cn",
        "adreq.vivo.com.cn",
        "adsdk.vivo.com.cn",
        "adsstatic.vivo.com.cn",
        "adxlog.vivo.com.cn",
        "stnetsdk.appstore.vivo.com.cn",
        "monitor-stsdk.vivo.com.cn",
        "onrt-stsdk.vivo.com.cn",
        "ort-stsdk.vivo.com.cn",
        "pnrt-stsdk.vivo.com.cn",
        "prt-stsdk.vivo.com.cn",
        "stnetsdk.vivo.com.cn",
        "stsdk.vivo.com.cn",
        "vcardsdkservice.vivo.com.cn",
        "h5.vivo.com.cn", // #847
        "browser.vivo.com.cn", // #847
        "zhan.vivo.com.cn", // #847
        "ads-marketing-vivofs.vivo.com.cn", // #847
    ],
    "onewsvod.com" => ["onewsvod.com"], // #847
    "vnet.cn" => ["vnet.cn"], //互联星空
    "wannaplay.cn" => ["h5.wannaplay.cn"], //游戏广告
    "waps.cn" => ["waps.cn"], //广告商
    "yomob.com.cn" => ["yomob.com.cn"], //移动视频广告
    "kochava.com" => ["kochava.com"], //移动大数据收集
    "supersonicads.com" => ["supersonicads.com"], //广告聚合平台
    "voodoo-ads.io" => ["voodoo-ads.io"], //广告平台
    "voodoo-analytics.io" => ["voodoo-analytics.io"], //数据收集
    "voodoo.io" => ["crosspromo.voodoo.io"], //交叉推广
    "inner-active.mobi" => ["inner-active.mobi"], //广告追踪
    "adtilt.com" => ["adtilt.com"], //隐私收集
    "nextmedia.com" => [
        "imp.nextmedia.com", //行为追踪
        "dev.imp.nextmedia.com",
        "dev-imp.nextmedia.com",
    ],
    "sdo.com" => [
        "aa.sdo.com", //行为追踪
        "dfp.aa.sdo.com",
        "snyu.sdo.com",
    ],
    "wasu.cn" => [
        "acsystem.wasu.cn", //广告系统
    ],
    "sandai.net" => [
        "cpm.cm.sandai.net", //cpm广告
    ],
    "cdndm.com" => [
        "by.tel.cdndm.com", //行为收集
    ],
    "zol.com.cn" => [
        "p.zol.com.cn", //统计脚本
    ],
    "adm668.com" => [
        //不良投注网站
        "adm668.com",
        "www.adm668.com",
    ],
    "jiguangzhuisu.com" => [
        "jiguangzhuisu.com", //怀疑是恶意网站，例如https://etc.jiguangzhuisu.com/701f41a599cdbf67cea081ed9abda6ee.js
        //例如 https://etc.jiguangzhuisu.com/act.html
        "etc.jiguangzhuisu.com",
    ],
    "aliyuncs.com" => [
        "sspmiaoshuo.cn-hangzhou.log.aliyuncs.com", //日志收集
    ],

    "186078.com" => [
        "api.186078.com",
        "186078.com", //行为追踪，在https://etc.jiguangzhuisu.com/701f41a599cdbf67cea081ed9abda6ee.js
    ],

    "iask.cn" => [
        "iask.cn", //广告服务商
        "pic.iask.cn",
    ],

    "iask.com.cn" => [
        "iask.com.cn", //广告服务商
        "dw.iask.com.cn",
    ],

    "dushu.io" => [
        "advertising.dushu.io", //广告域名
    ],

    "unitychina.cn" => [
        "config.unityads.unitychina.cn",
        "unityads.unitychina.cn",
    ],

    "upltv.com" => [
        "ads-sdk-cn.upltv.com",
        "a-sta-cn.upltv.com",
        "ads-sdk.upltv.com",
        "report-ads-sdk.upltv.com",
        "c-sta-cn.upltv.com",
    ],

    //上传分享wifi密码
    "ggsafe.com" => ["ggsafe.com", "wifi.ggsafe.com"],
    "2345.cn" => [
        "2345.cn", //广告联盟
        "dl.2345.cn",
        "download.2345.cn",
        "houtai.2345.cn",
        "jifen.2345.cn",
        "jifendownload.2345.cn",
        "minipage.2345.cn",
        "wan.2345.cn",
        "zhushou.2345.cn",
    ],
    "19869.com" => ["19869.com", "a.19869.com", "b.19869.com"],
    "1drj.com" => [
        //第三方劫持
        "1drj.com",
        "md.1drj.com",
        "xs.1drj.com",
    ],

    //一窝恶意劫持搞推广的域名
    "duoroumao.cn" => [
        "s.duoroumao.cn", //广告分发，例如https://s.duoroumao.cn/yxs191.js
        "duoroumao.cn",
    ],
    "geakr.com" => [
        "geakr.com", //广告 例如：https://www.geakr.com/tkl/cp.js?channel_id=3
        "www.geakr.com",
    ],
    "qichetiemo.info" => [
        "qichetiemo.info",
        "about.qichetiemo.info", //广告，例如 https://about.qichetiemo.info/apf/mkdjJSjcs113 ，此页面有js加密代码，应属于恶意网站
    ],
    "bbhyqp.com" => [
        "bbhyqp.com", //“澳门真金”。。推广页面 例如 https://bbhyqp.com/mifiqp/index.html
    ],
    "sntzq.com" => [
        "sntzq.com", //https://c.sntzq.com/init/proxy.html?v=1.2
        "c.sntzq.com",
    ],
    "35kds.com" => [
        "35kds.com",
        "n.35kds.com", //https://n.35kds.com/Exposead/index/?re=
    ],
    "mobaders.com" => [
        "mobaders.com", //行为统计，例如http://d1.mobaders.com/cnzzA/1260857752
        "d1.mobaders.com",
        "d2.mobaders.com",
        "d3.mobaders.com",
        "d4.mobaders.com",
        "d5.mobaders.com",
        "d6.mobaders.com",
        "d7.mobaders.com",
        "d8.mobaders.com",
        "d9.mobaders.com",
    ],
    "61677.com" => [
        //澳门新葡京
        "61677.com",
        "www.61677.com",
    ],
    "111ol.com" => ["111ol.com", "www.111ol.com", "111ol.111ol.com"],
    "61677c.com" => ["61677c.com"],
    "www-61677.com" => ["www-61677.com"],
    "11599jgj.com" => ["11599jgj.com", "www.11599jgj.com"],
    "duote.com" => [
        //https://zhuanlan.zhihu.com/p/111435102
        "duote.com",
        "www.duote.com",
    ],
    "zzb6.cn" => ["zzb6.cn", "download.zzb6.cn", "i.zzb6.cn"],
    "xp666.com" => ["xp666.com", "download.xp666.com"],
    "dh810.com" => ["dh810.com"],
    "dh820.com" => ["dh820.com"],
    "bsrkt.com" => [
        //http://www.bsrkt.com/diy/b/commander/tips/index.html
        "bsrkt.com",
        "www.bsrkt.com",
    ],
    "zjsyawqj.cn" => [
        //http://js.zjsyawqj.cn/diy/b/commander/tips/default.js
        "zjsyawqj.cn",
        "www.zjsyawqj.cn",
        "js.zjsyawqj.cn",
        "download.zjsyawqj.cn",
    ],
    "v4dwkcv.com" => [
        // http://c.v4dwkcv.com/html/click/23421_5605.html
        "v4dwkcv.com",
        "c.v4dwkcv.com",
    ],
    "he2d.com" => [
        // 相关http://c.v4dwkcv.com/html/click/23421_5605.html
        "ss2.he2d.com",
        "he2d.com",
    ],
    "sdqoi2d.com" => [
        // 统计 http://j.sdqoi2d.com/click/ffb.php
        "j.sdqoi2d.com",
        "sdqoi2d.com",
    ],
    "youhuiguan.com" => [
        // 神药？ http://cr.youhuiguan.com/attachments/201908/28/20/3658-5lmj04.jpg
        "youhuiguan.com",
        "cr.youhuiguan.com",
    ],
    "doumaibiji.cn" => [
        // http://diy.doumaibiji.cn/diy/js/b.js
        "doumaibiji.cn",
        "diy.doumaibiji.cn",
    ],
    "oneplus.net" => ["open.oneplus.net"],
    "live.com" => [
        "nexusrules.officeapps.live.com",
        "nexus.officeapps.live.com",
    ],
    "twitter.com" => ["p.twitter.com"],
    "nsimg.net" => ["m2.nsimg.net"],
    "microsoft.com" => [
        "mobile.pipe.aria.microsoft.com",
        "events.data.microsoft.com", // #882
    ],
    "leixjun.com" => [
        //恶意诱导下载app
        "leixjun.com",
        "zq2.leixjun.com",
    ],
    "xi9p.com" => [
        //诈骗网址
        "xi9p.com",
    ],

    "doukekan.cn" => [
        //广告平台
        "doukekan.cn",
        "y3.doukekan.cn",
    ],
    "dzdkw9.cn" => [
        //恶意推广 #65
        "dzdkw9.cn",
        "m.dzdkw9.cn",
    ],

    "feeddsp.cn" => [
        "1.feeddsp.cn", //游戏推广落地页
    ],
    "huya.com" => [
        "ylog.huya.com", // #86
        "metric.huya.com", // https://adguardteam.github.io/AdGuardSDNSFilter/Filters/filter.txt
        "statwup.huya.com", // https://adguardteam.github.io/AdGuardSDNSFilter/Filters/filter.txt
        "e-stat.huya.com", // https://adguardteam.github.io/AdGuardSDNSFilter/Filters/filter.txt
    ],

    "grammarly.io" => [
        "f-log-extension.grammarly.io",
        "f-log-mobile-ios.grammarly.io",
        "f-log-at.grammarly.io",
    ],
    "ximalaya.com" => [
        "adse.wsa.ximalaya.com",
        "linkeye.ximalaya.com",
        "location.ximalaya.com",
    ],
    "googleapis.com" => ["footprints-pa.googleapis.com"],
    "ebjvu.cn" => ["ebjvu.cn"],
    "nvidia.com" => ["events.gfe.nvidia.com"],
    "axbxgg.com" => [
        // 恶意推广app下载
        "axbxgg.com",
        "2ydl.axbxgg.com",
    ],
    "rayjump.com" => [
        // 广告域名 #98
        "rayjump.com",
        "adx-tk.rayjump.com",
    ],
    "baicizhan.org" => [
        // 百词斩
        "advertise.baicizhan.org",
    ],
    "baicizhan.com" => [
        // 百词斩
        "advertise.baicizhan.com",
    ],
    "yiche.com" => [
        // 易车ad
        "adx.yiche.com",
        "log.ycapp.yiche.com",
    ],
    "csheaven.com" => [
        // 总结到主域名上
        "csheaven.com",
    ],
    "bckrono.cn" => [
        // 恶意跳转下载app
        "bckrono.cn",
        "js.bckrono.cn",
    ],
    "yemnn.cn" => [
        // 恶意跳转下载app
        "yemnn.cn",
    ],
    "familytaste.cn" => [
        // 恶意跳转下载app
        "familytaste.cn",
        "s350.familytaste.cn",
    ],
    "iyfsearch.com" => ["iyfsearch.com"],
    "click.com.cn" => ["click.com.cn"],
    "yl89.cn" => ["yl89.cn", "cdnqq.yl89.cn"],
    "sgbbc.cn" => [
        // #187
        "sgbbc.cn",
        "7202019monday.sgbbc.cn",
    ],
    "shgansheng.cn" => [
        // #187
        "shgansheng.cn",
        "aa.shgansheng.cn", // https://aa.shgansheng.cn/safe/pot/iui/index.html?6101595245409&pkg=31
    ],
    "guiheng.wang" => ["guiheng.wang", "s.guiheng.wang"],
    "whbmy.com" => ["whbmy.com", "a-llq.whbmy.com"],
    "bd-gl.com" => [
        "bd-gl.com",
        "api.bd-gl.com", // /www/nodejs/暗刷api/node_modules/
    ],
    "zbwowo.com" => [
        "zbwowo.com",
        "cdn-7n-pt.zbwowo.com", // https://cdn-7n-pt.zbwowo.com/pjs/as/apias0.js?c=12
    ],
    "ijinshan.com" => [
        "mobad.ijinshan.com",
        "union.ijinshan.com",
        "tj.ijinshan.com",
    ],
    "ifeng.com" => [
        "iaclick.ifeng.com",
        "avideo.ifengcdn.com",
        "cx.ifengbi.com",
    ],
    "shllhz.net" => [
        // #204
        "shllhz.net",
        "p.shllhz.net",
    ],
    "pubghio.fun" => [
        "pubghio.fun", // #212, https://pubghio.fun/login?agency=200
    ],
    "izuiyou.com" => [
        // 手机迅雷广告
        "xladapi.izuiyou.com",
        "xlstat.izuiyou.com",
    ],
    "idmchina.net" => [
        // 假冒官网
        "www.idmchina.net",
        "idmchina.net",
    ],

    "cntingyun.com" => [
        // #234
        "www.cntingyun.com",
        "cntingyun.com",
    ],
    "networkbench.com" => [
        // #234
        "networkbench.com",
        "www.networkbench.com",
    ],
    "tingyun.com" => [
        // #234
        "tingyun.com",
        "www.tingyun.com",
    ],
    "appsmall.mobi" => [
        // #234
        "appsmall.mobi",
        "www.appsmall.mobi",
    ],
    "babybubble.cn" => [
        // #234
        "www.babybubble.cn",
        "babybubble.cn",
    ],
    "babymoment.net" => [
        // #234
        "www.babymoment.net",
        "babymoment.net",
    ],
    "coolppa.cn" => [
        // #234
        "coolppa.cn",
        "www.coolppa.cn",
    ],
    "effirst.cn" => [
        // #234
        "www.effirst.cn",
        "effirst.cn",
    ],
    "effirst.com" => [
        // #234
        "www.effirst.com",
        "effirst.com",
    ],
    "hdyzx.cn" => [
        // #234
        "hdyzx.cn",
        "www.hdyzx.cn",
    ],
    "minippa.cn" => [
        // #234
        "www.minippa.cn",
        "minippa.cn",
    ],
    "open-uc.cn" => [
        // #234
        "open-uc.cn",
        "www.open-uc.cn",
    ],

    "tinya1.cn" => [
        // #234
        "tinya1.cn",
        "www.tinya1.cn",
    ],
    "tinyap2.cn" => [
        // #234
        "tinyap2.cn",
        "www.tinyap2.cn",
    ],
    "tinypap.cn" => [
        // #234
        "tinypap.cn",
        "www.tinypap.cn",
    ],
    "tinyppa.cn" => [
        // #234
        "tinyppa.cn",
        "www.tinyppa.cn",
    ],
    "u-mob.cn" => [
        // #234
        "u-mob.cn",
        "www.u-mob.cn",
    ],
    "ubibibi.com" => [
        // #234
        "ubibibi.com",
        "www.ubibibi.com",
    ],
    "uc123.com" => [
        // #234
        "uc123.com",
        "www.uc123.com",
    ],
    "ucdesk.cn" => [
        // #234
        "ucdesk.cn",
        "www.ucdesk.cn",
    ],
    "ucfly.com" => [
        // #234
        "ucfly.com",
        "www.ucfly.com",
    ],
    "ucweb.cn" => [
        // #234
        "ucweb.cn",
        "www.ucweb.cn",
    ],
    "uflowx.com" => [
        // #234
        "uflowx.com",
        "www.uflowx.com",
    ],
    "xiaomengquan.cn" => [
        // #234
        "xiaomengquan.cn",
        "www.xiaomengquan.cn",
    ],
    "xmq123.cn" => [
        // #234
        "xmq123.cn",
        "www.xmq123.cn",
    ],
    "dabaicai.cn" => [
        // #240
        "dabaicai.cn",
        "www.dabaicai.cn",
    ],
    "diannaodian.com" => [
        // #240
        "diannaodian.com",
        "www.diannaodian.com",
    ],
    "laomaotao.com" => [
        // #240
        "laomaotao.com",
        "www.laomaotao.com",
    ],
    "myfeng.cn" => [
        // #240
        "myfeng.cn",
        "www.myfeng.cn",
    ],
    "laomaotao.net" => [
        // #240
        "laomaotao.net",
        "www.laomaotao.net",
    ],
    "winbaicai.com" => [
        // #240
        "winbaicai.com",
        "www.winbaicai.com",
    ],
    "dabaicai.com" => [
        // #240
        "dabaicai.com",
        "www.dabaicai.com",
    ],
    "fancydsp.com" => [
        // fancyapi.com同备案号
        "fancydsp.com",
        "www.fancydsp.com",
    ],
    "fancydigital.com.cn" => [
        // fancyapi.com同备案号
        "fancydigital.com.cn",
        "www.fancydigital.com.cn",
    ],
    "fancydmp.com" => [
        // fancyapi.com同备案号
        "fancydmp.com",
        "www.fancydmp.com",
    ],
    "adfancy.com.cn" => [
        // fancyapi.com同备案号
        "adfancy.com.cn",
        "www.adfancy.com.cn",
    ],
    "fancysmp.com" => [
        // fancyapi.com同备案号
        "fancysmp.com",
        "www.fancysmp.com",
    ],
    "fancysocialtalk.com" => [
        // fancyapi.com同备案号
        "fancysocialtalk.com",
        "www.fancysocialtalk.com",
    ],
    "188api.com" => [
        // fancyapi.com同备案号
        "188api.com",
        "www.188api.com",
    ],
    "rdtk.io" => [
        // #253
        "rdtk.io",
        "jtuzd.rdtk.io",
    ],
    "c4frc.info" => [
        // #253
        "c4frc.info",
    ],
    "163.com" => [
        "crash.163.com",
        "httpdns.music.163.com", // #847
        "netapm.music.163.com", // #847
        // "ipv6.music.163.com", // #847, #948
        // "ipv4.music.163.com", // #847, #948
    ],
    "360.cn" => ["mclean.f.360.cn", "vconf.f.360.cn"],
    "gsgsr.xyz" => ["gsgsr.xyz", "www.gsgsr.xyz", "gdp.gsgsr.xyz"],
    "zmzfile.com" => [
        #299
        "zmzfile.com",
    ],
    "playcvn.com" => [
        #299
        "playcvn.com",
    ],
    "mgtv.com" => [
        #306
        "da.mgtv.com",
        "video.da.mgtv.com",
    ],
    "wwads.cn" => [
        #323
        "wwads.cn",
        "www.wwads.cn",
    ],
    "pigvideo.com.cn" => [
        #372
        "pigvideo.com.cn",
        "www.pigvideo.com.cn",
    ],
    "pigvideo.cn" => [
        #372
        "pigvideo.cn",
        "www.pigvideo.cn",
    ],
    "xiaozhuvideo.cn" => [
        #372
        "xiaozhuvideo.cn",
        "www.xiaozhuvideo.cn",
    ],
    "wikawika.xyz" => [
        #375
        "ad-display.wikawika.xyz",
        "ad-channel.wikawika.xyz",
    ],
    "shujupie.com" => [
        #379
        "shujupie.com",
        "umini.shujupie.com",
    ],
    "pcidata.cn" => [
        #379
        "pcidata.cn",
        "spi.pcidata.cn",
    ],
    "3.cn" => [
        #392
        "atom-log.3.cn",
    ],
    "gz-data.com" => [
        #402
        "gz-data.com",
        "www.gz-data.com",
    ],
    "gzads.com" => [
        #402
        "gzads.com",
        "www.gzads.com",
    ],
    "gozendata.com" => [
        #402
        "gozendata.com",
        "www.gozendata.com",
    ],
    "zhuangjizhuli.net" => [
        #400
        "www.zhuangjizhuli.net",
        "zhuangjizhuli.net",
    ],
    "coumie.top" => [
        #400
        "coumie.top",
        "softdown.coumie.top",
    ],
    "avbdf.com" => [
        #400
        "avbdf.com",
        "hs.avbdf.com",
    ],
    "sxyunyou.cn" => [
        #400
        "sxyunyou.cn",
        "hs.sxyunyou.cn",
    ],
    "sxdanke.cn" => [
        #400
        "sxdanke.cn",
        "hbs.sxdanke.cn",
    ],
    "o7h.net" => [
        #400
        "o7h.net",
        "www.o7h.net",
    ],
    "uzhuangji.cn" => [
        #400
        "xiazai.uzhuangji.cn",
        "uzhuangji.cn",
    ],
    "sdxitong.com" => [
        #400
        "www.sdxitong.com",
        "sdxitong.com",
    ],
    "haozhuangji.com" => [
        #400
        "www.haozhuangji.com",
        "haozhuangji.com",
    ],
    "lao9123.com" => [
        #400
        "www.lao9123.com",
        "lao9123.com",
    ],
    "pe8.com" => [
        #400
        "www.pe8.com",
        "pe8.com",
    ],
    "ycxjtd.com" => [
        #400
        "cdn.ycxjtd.com",
        "www.ycxjtd.com",
        "ycxjtd.com",
    ],
    "pkkjxs.cn" => [
        #400
        "pkkjxs.cn",
        "dbc.pkkjxs.cn",
        "www.pkkjxs.cn",
        "windows.pkkjxs.cn",
    ],
    "telegram-cn.org" => [
        #431, #616
        "telegram-cn.org",
        "www.telegram-cn.org",
    ],
    "telegram-vip.com" => [
        #431
        "telegram-vip.com",
        "www.telegram-vip.com",
    ],
    "telegramcn.org" => [
        #431
        "telegramcn.org",
        "www.telegramcn.org",
    ],
    "telegrcn.org" => [
        #431
        "telegrcn.org",
        "www.telegrcn.org",
    ],
    "telegramsvip.com" => [
        #431
        "telegramsvip.com",
        "www.telegramsvip.com",
    ],
    "ucweb.com" => [
        // #442
        "px-intl.ucweb.com",
        "gjapplog.ucweb.com",
    ],
    "tradplus.cn" => [
        // #444
        "tradplus.cn",
    ],
    "tradplus.com" => [
        // #444
        "tradplus.com",
    ],
    "qutaovip.com" => [
        // #473
        "qutaovip.com",
        "api-ads.qutaovip.com",
    ],
    "7moor.com" => [
        // #464
        "7moor.com",
    ],
    "oray.com" => [
        // #464
        "tk.oray.com",
        "sl-tk.oray.com",
    ],
    "oray.net" => [
        // #464
        "sl-log.oray.net",
        "pubsub02.oray.net",
    ],
    "bcebos.com" => [
        "staticsns.cdn.bcebos.com", // #489
        "mobads-pre-config.cdn.bcebos.com", // #784
    ],
    "pglstatp-toutiao.com" => [
        // #494
        "pglstatp-toutiao.com",
    ],
    "netease.com" => [
        "mam6.netease.com", // #496
        "httpdns-sdk.n.netease.com", // #847
        "httpdns.n.netease.com", // #847
        // "nstool.netease.com", // #847, #967
    ],
    "cibntv.net" => [
        // #507
        "vali-g1.cp31.ott.cibntv.net",
        "ykad-data.cp31.ott.cibntv.net", // #914
    ],
    "byteimg.com" => [
        "p6-ad-sign.byteimg.com", // #513
    ],
    "gvt2.com" => [
        "gvt2.com", // #558
    ],

    "dealmoon.com" => [
        "analytics.dealmoon.com", // #575
    ],
    "cmpassport.com" => [
        "config.cmpassport.com", // #547
        "log1.cmpassport.com",
        "log.cmpassport.com",
    ],
    "wo.cn" => [
        "hmrz.wo.cn", // #547
        "id.mail.wo.cn", // #547
        "mdn.open.wo.cn", // #547
    ],
    "id6.me" => [
        "id6.me", // #547
    ],
    "wostore.cn" => [
        "opencloud.wostore.cn", // #547
    ],
    "wosms.cn" => [
        "auth.wosms.cn", // #547
    ],
    "zijieapi.com" => [
        "ads5-normal-hl.zijieapi.com", // #592
        "ads3-normal-hl.zijieapi.com", // #592
    ],
    "cncrk.com" => [
        "js.cncrk.com", // #583
    ],
    //     'dianshihome.com' => array(
    //         'api.dianshihome.com', // #571
    //         'cdn.dianshihome.com', // #571
    //     ),
    //     'dianshige.com' => array(
    //         'api.dianshige.com', // #571
    //     ),
    //     'tvfuwu.com' => array(
    //         'pushapi.tvfuwu.com', // #571
    //     ),
    //     'cdnimg.org' => array(
    //         'pushapi.cdnimg.org', // #571
    //     ),
    "telegrem.org" => [
        "telegrem.org", // #616
    ],
    "tcgnclibk.xyz" => [
        "tcgnclibk.xyz", // #616
    ],
    "telegramstr.com" => [
        "telegramstr.com", // #616
    ],
    "telegramv.com" => [
        "telegramv.com", // #616
    ],
    "telegramim.org" => [
        "telegramim.org", // #616
    ],
    "teleylc.com" => [
        "teleylc.com", // #616
    ],
    "teleylm.com" => [
        "teleylm.com", // #616
    ],
    "telegrcn.com" => [
        "telegrcn.com", // #616
    ],
    "telepang.com" => [
        "telepang.com", // #616
    ],
    "telegramos.org" => [
        "telegramos.org", // #616
    ],
    "telegvam.org" => [
        "telegvam.org", // #616
    ],
    "telegramyy.com" => [
        "telegramyy.com", // #616
    ],
    "telegram-china.org" => [
        "telegram-china.org", // #616
    ],
    "teledai.com" => [
        "teledai.com", // #616
    ],
    "telegmcn.org" => [
        "telegmcn.org", // #616
    ],
    "ali213.net" => [
        "click.ali213.net", // #633
    ],
    "gjctwh.cn" => [
        "gjctwh.cn", // #637
    ],
    "weibo.com" => [
        "fastimage.uve.weibo.com", // #629
    ],
    "telecome.cn" => [
        "telecome.cn", // #844
    ],
    "unioncom.cc" => [
        "unioncom.cc", // #844
    ],
    "hubcloud.com.cn" => [
        "hubcloud.com.cn", // #859
        "api.htp.hubcloud.com.cn", //#859
        "res1.hubcloud.com.cn", // #859
        "sdktmp.hubcloud.com.cn", // #813
        "v.adx.hubcloud.com.cn", // #859
    ],
    "cainiao.com" => [
        "v6-adashx.ut.cainiao.com", //#859
    ],
    "ele.me" => [
        "v6-adashx.ut.ele.me", //#859
    ],

    "50union.com" => [
        // #644
        "50union.com",
        "www.50union.com",
        "mclean.50union.com", // https://github.com/deep-bhatt/huawei-block-list/blob/badc2ffe5ba651bfba7c8b92c5009a79d609c7eb/huawei-block-host.txt#L31
        "mvconf.50union.com", // https://github.com/deep-bhatt/huawei-block-list/blob/badc2ffe5ba651bfba7c8b92c5009a79d609c7eb/huawei-block-host.txt#L32
    ],
    "8289.tv" => [
        // #641
        "8289.tv",
    ],
    "postex10.com" => [
        // #641
        "postex10.com",
        "land3.postex10.com",
    ],
    "rscc3.cc" => [
        // #641
        "rscc3.cc",
        "stat.rscc3.cc",
    ],
    "eib2.cc" => [
        // #641
        "eib2.cc",
        "app.eib2.cc",
    ],
    "mlsjh.com" => [
        // #641
        "mlsjh.com",
        "mh1.mlsjh.com",
    ],
    "dvkbfj.cn" => [
        // #641
        "dvkbfj.cn",
        "www.dvkbfj.cn",
    ],
    "4rw6x0b.cn" => [
        // #641
        "4rw6x0b.cn",
        "5rd25e.4rw6x0b.cn",
    ],
    "sujev.cn" => [
        // #641
        "sujev.cn",
        "e5m2gp.sujev.cn",
    ],
    "kktly.cn" => [
        // #641
        "kktly.cn",
    ],
    "swallowcrockerybless.com" => [
        // #673
        "swallowcrockerybless.com",
    ],
    "entirelysacrament.com" => [
        // #673
        "entirelysacrament.com",
    ],
    "2345.cc" => [
        // #683
        "2345.cc",
    ],
    "yes115.com" => [
        // #683
        "yes115.com",
    ],
    "fkw.com" => [
        // #698
        "datareport.fkw.com",
    ],
    "xiaohongshu.com" => [
        // #704
        "s.xiaohongshu.com",
        "crash.xiaohongshu.com",
        "apppush-sh5.xiaohongshu.com",
        "flash.xiaohongshu.com",
        "referee.xiaohongshu.com",
        "vi.xiaohongshu.com",
        "store.xiaohongshu.com",
        "starry.xiaohongshu.com",
    ],
    "todesk.com" => [
        // #704
        "st.todesk.com",
    ],
    "189.cn" => [
        // #526
        "webwebfenxi.189.cn",
    ],
    "dutils.com" => [
        // #768
        "api-c.dutils.com",
        "api-d.dutils.com",
        "api-devs.dutils.com",
        "api-df.dutils.com",
        "api-error.dutils.com",
        "api-exc.dutils.com",
        "api-fc.dutils.com",
        "api-fd.dutils.com",
        "api-gd.dutils.com",
        "devs-data.dutils.com",
        "jp-api-fc.dutils.com",
        "jp-devs-data.dutils.com",
        "m.mpl.dutils.com",
        "h.m.mpl.dutils.com",
        "us-api-d.dutils.com",
        "us-api-fc.dutils.com",
        "us-devs-data.dutils.com",
        "www.dutils.com",
    ],
    "gifshow.com" => [
        // #768
        "gdfp.gifshow.com",
        "log-sdk.gifshow.com",
        "ad.partner.gifshow.com",
        "ulog-sdk.gifshow.com",
    ],
    "adukwai.com" => [
        // #768
        "adukwai.com",
        "p1-jx.adukwai.com",
        "p1-lm.adukwai.com",
        "p2-jx.adukwai.com",
        "p2-lm.adukwai.com",
        "v1-lm.adukwai.com",
        "v2-lm.adukwai.com",
        "v4-lm.adukwai.com",
    ],
    "diwodiwo.xyz" => [
        // #775
        "ad-display.diwodiwo.xyz",
        "ad-channel.diwodiwo.xyz",
    ],
    "126.net" => [
        "ads.music.126.net", // #784
        "iadmusicmat.music.126.net", // #847
    ],
    "xhscdn.com" => [
        "ads-img-al.xhscdn.com", // #784
        "ads-img-qc.xhscdn.com", // #793
        "ads-video-al.xhscdn.com", // #793
        "ads-video-qc.xhscdn.com", // #793
    ],
    "cmbchina.com" => [
        "mbads.paas.cmbchina.com", // #784
    ],
    "heytapimage.com" => [
        "img-c.heytapimage.com", // #789
    ],
    "google.cn" => [
        "ads.google.cn", // #793
        "adsense.google.cn", // #793
    ],
    "azureedge.net" => [
        "advertiseonbing.azureedge.net", // #793
    ],
    "duoduo.link" => [
         "ad.duoduo.link", // #793
    ],
    "pangolin-sdk-toutiao1.com" => [
        "pangolin-sdk-toutiao1.com", // #800
    ],
    "beizi.biz" => [
        "sdk.beizi.biz", // #813
        "api-htp.beizi.biz", // #859
    ],
    "mobileservice.cn" => [
        "zxid-m.mobileservice.cn", // #816
    ],
    "kakao.com" => [
        "play.kakao.com", // #833
    ],
    "kgslb.com" => [
        "p1-play.kgslb.com", // #833
    ],
    "edge4k.com" => [
        "p1-play.edge4k.com", // #833
        "p2-play.edge4k.com", // #833
    ],
    "trackingio.com" => [
        "trackingio.com", // #857
        "www.trackingio.com", // #857
    ],
    "quark.cn" => [
        "applog.lc.quark.cn", // #859
        "adtrack.quark.cn", // #859
        "track.lc.quark.cn", // #859
    ],
    "aligames.com" => [
        "cddp-track.aligames.com", // #859
    ],
    "aispeech.com" => [
        "log.aispeech.com", // #859
    ],
    "xiaomi.net" => [
        "sentry.d.xiaomi.net", // #859
    ],
    "wps.cn" => [
        "co-sentry.wps.cn", // #859
    ],
    "zdmimg.com" => [
        "sentry-monitor-new.zdmimg.com", // #859
    ],
    "mihoyo.com" => [
        "hkrpg-log-upload.mihoyo.com", // #843
    ],
    "volceapplog.com" => [
        "volceapplog.com", // #859
    ],
    "10010.com" => [
        "nishub1.10010.com", // #866
        "enrichgw.10010.com", // #866
    ],
    "inkuai.com" => [
        "apidns.kwd.inkuai.com", // #847
    ],
    "httpdns.pro" => [
        "kuaishou.httpdns.pro", // #847
        "httpdns.pro", // #847
    ],
    "ksyun.com" => [
        "hdns.ksyun.com", // #847
    ],
    "qq.com.cn" => [
        "dns.weixin.qq.com.cn", // #847
    ],
    "cdnhwc2.com" => [
        "httpdns.c.cdnhwc2.com", // #847
    ],
    "alicdn.com" => [
        // "httpdns.alicdn.com", // #847, #916
    ],
    "onethingpcs.com" => [
        "natdetection.onethingpcs.com", // #847
    ],
    "bootcdn.cn" => [
        "bootcdn.cn", // #938
        "www.bootcdn.cn", // #938
    ],
    "bootcdn.net" => [
        "bootcdn.net", // #938
        "www.bootcdn.net", // #938
    ],
    "bootcss.com" => [
        "bootcss.com", // #938
        "www.bootcss.com", // #938
    ],

    "staticfile.net" => [
        "staticfile.net", // #938
        "www.staticfile.net", // #938
    ],
    "staticfile.org" => [
        "staticfile.org", // #938
        "www.staticfile.org", // #938
    ],
    "anythinktech.com" => [
        "adx-os.anythinktech.com", // #958
        "cn-api.anythinktech.com", // #989
        "datk.anythinktech.com", // #989
    ],
    "bhbapp.cn" => [
        "sentry.bhbapp.cn", // #966
    ],
    "chinacloudsites.cn" => [
        "pcmactivity.chinacloudsites.cn", // #966
    ],
    "fzzixun.com" => [
        "simulatelab-datasink.fzzixun.com", // #966
    ],
    "geelark.cn" => [
        "cooper.geelark.cn", // #966
        "datasink.geelark.cn", // #966
    ],
    "geelark.com" => [
        "datasink.geelark.com", // #966
    ],
    "linkfox.com" => [
        "datasink.linkfox.com", // #966
    ],
    "meituan.net" => [
        "dreport.meituan.net", // #966
        "babel-statistics-android.dreport.meituan.net", // #966
    ],
    "yximgs.com" => [
        "tob-tracker.yximgs.com", // #966
    ],
    "ziniao.com" => [
        "datasink.ziniao.com", // #966
        "logs-collect.ziniao.com", // #966
        "test-cb-log.ziniao.com", // #966
    ],
    "163yun.com" => [
        "ye.dun.163yun.com", // #971
    ],
    "birdgesdk.com" => [
        "aa.birdgesdk.com", // #989
    ],
    "bytedance.com" => [
        "mssdk-bu.bytedance.com", // #989
    ],
    "pinduoduo.com" => [
        "dspsdk.pinduoduo.com", // #989
    ],
    "toutiao.com" => [
        "dm-hl.toutiao.com", // #989
    ],
    "volces.com" => [
        "apmplus.volces.com", // #989
    ],
    "volctrack.com" => [
        "volctrack.com", // #989
    ],
    "brg0.com" => [
        "brg0.com", // #970
    ],
    "doglobal.net" => [
        // #1006
        "doglobal.net",
        "api-es.doglobal.net",
    ],
    "yfanads.cn" => [
        "yfanads.cn", // #1006
    ],
    "yfanads.com" => [
        // #1006
        "yfanads.com",
        "adx-data.yfanads.com",
        "api.yfanads.com",
        "tracker.yfanads.com",
    ],
    "adanxing.com" => [
        // #1015
        "adanxing.com",
        "statics.adanxing.com",
    ],
    "kuaishou.com" => [
        "promotion-partner.kuaishou.com", // #1015
    ],
    "qttunion.com" => [
        "api.qttunion.com", // #1015
    ],
    "qm989.com" => [
        // #1045
        "a6-remad.qm989.com",
        "a-qmad.qm989.com",
        "t-remad.qm989.com",
    ],

    "2mdn-cn.net" => ["2mdn-cn.net"],
    "admob-cn.com" => ["admob-cn.com"],
    "app-measurement-cn.com" => ["app-measurement-cn.com"],
    "dartsearch-cn.net" => ["dartsearch-cn.net"],
    "doubleclick-cn.net" => ["doubleclick-cn.net"],
    "ggpht.cn" => ["ggpht.cn"],
    "gongyichuangyi.net" => ["gongyichuangyi.net"],
    "googleads-cn.com" => ["googleads-cn.com"],
    "googleadservices-cn.com" => ["googleadservices-cn.com"],
    "googleadsserving.cn" => ["googleadsserving.cn"],
    "google-analytics-cn.com" => ["google-analytics-cn.com"],
    "googleflights-cn.net" => ["googleflights-cn.net"],
    "googleminiapps.cn" => ["googleminiapps.cn"],
    "googleoptimize-cn.com" => ["googleoptimize-cn.com"],
    "googlers-cn.com" => ["googlers-cn.com"],
    "googlesandbox-cn.com" => ["googlesandbox-cn.com"],
    "googlesyndication-cn.com" => ["googlesyndication-cn.com"],
    "googletagmanager-cn.com" => ["googletagmanager-cn.com"],
    "googletagservices-cn.com" => ["googletagservices-cn.com"],
    "googlevads-cn.com" => ["googlevads-cn.com"],

    // 批量添加域名
    "0202.com.tw" => ["0202.com.tw", "www.0202.com.tw"],
    "0757kd.cn" => ["0757kd.cn", "www.0757kd.cn"],
    "07634.com" => ["07634.com", "www.07634.com"],
    "0pengl.com" => ["0pengl.com", "www.0pengl.com"],
    "1001movies.com" => ["1001movies.com", "www.1001movies.com"],
    "1008691.com" => ["1008691.com", "www.1008691.com"],
    "123counters.com" => ["123counters.com", "www.123counters.com"],
    "166f.com" => ["166f.com", "www.166f.com"],
    "17chezhan.com" => ["17chezhan.com", "www.17chezhan.com"],
    "17youzi.com" => ["17youzi.com", "www.17youzi.com"],
    "91756.cn" => ["91756.cn", "www.91756.cn"],
    "adups.cn" => ["adups.cn", "www.adups.cn"],

    // 一批运营商劫持域名
    "17gouwuba.com" => ["17gouwuba.com", "www.17gouwuba.com"],
    "189zj.cn" => ["189zj.cn", "www.189zj.cn"],
    "285680.com" => ["285680.com", "www.285680.com"],
    "51chumoping.com" => ["51chumoping.com", "www.51chumoping.com"],
    "51mld.cn" => ["51mld.cn", "www.51mld.cn"],
    "51mypc.cn" => ["51mypc.cn", "www.51mypc.cn"],
    "58mingtian.cn" => ["58mingtian.cn", "www.58mingtian.cn"],
    "6d63d3.com" => ["6d63d3.com", "www.6d63d3.com"],
    "q1qfc323.com" => ["q1qfc323.com", "www.q1qfc323.com"],
    "91veg.com" => ["91veg.com", "www.91veg.com"],
    "9s6q.cn" => ["9s6q.cn", "www.9s6q.cn"],
    "adsensor.org" => ["adsensor.org", "www.adsensor.org"],
    "appcpi.net" => ["appcpi.net", "www.appcpi.net"],
    "baiwanchuangyi.com" => ["baiwanchuangyi.com", "www.baiwanchuangyi.com"],
    "beilamusi.com" => ["beilamusi.com", "www.beilamusi.com"],
    "biteti.com" => ["biteti.com", "www.biteti.com"],
    "bulldogcpi.com" => ["bulldogcpi.com", "www.bulldogcpi.com"],
    "cishantao.com" => ["cishantao.com", "www.cishantao.com"],
    "clotfun.mobi" => ["clotfun.mobi", "www.clotfun.mobi"],
    "clotfun.online" => ["clotfun.online", "www.clotfun.online"],
    "cszlks.com" => ["cszlks.com", "www.cszlks.com"],
    "cudaojia.com" => ["cudaojia.com", "www.cudaojia.com"],
    "dugesheying.com" => ["dugesheying.com", "www.dugesheying.com"],
    "fan-yong.com" => ["fan-yong.com", "www.fan-yong.com"],
    "feih.com.cn" => ["feih.com.cn", "www.feih.com.cn"],
    "fkku194.com" => ["fkku194.com", "www.fkku194.com"],
    "freedrive.cn" => ["freedrive.cn", "www.freedrive.cn"],
    "go2cloud.org" => ["go2cloud.org", "www.go2cloud.org"],
    "gouwubang.com" => ["gouwubang.com", "www.gouwubang.com"],
    "gzxnlk.com" => ["gzxnlk.com", "www.gzxnlk.com"],
    "haloapps.com" => ["haloapps.com", "www.haloapps.com"],
    "haoshengtoys.com" => ["haoshengtoys.com", "www.haoshengtoys.com"],
    "hyunke.com" => ["hyunke.com", "www.hyunke.com"],
    "ichaosheng.com" => ["ichaosheng.com", "www.ichaosheng.com"],
    "idealads.net" => ["idealads.net", "www.idealads.net"],
    "ishop789.com" => ["ishop789.com", "www.ishop789.com"],
    "jsncke.com" => ["jsncke.com", "www.jsncke.com"],
    "jwg365.cn" => ["jwg365.cn", "www.jwg365.cn"],
    "kawo77.com" => ["kawo77.com", "www.kawo77.com"],
    "kumihua.com" => ["kumihua.com", "www.kumihua.com"],
    "maipinshangmao.com" => ["maipinshangmao.com", "www.maipinshangmao.com"],
    "mdfull.com" => ["mdfull.com", "www.mdfull.com"],
    "mlnbike.com" => ["mlnbike.com", "www.mlnbike.com"],
    "mobjump.com" => ["mobjump.com", "www.mobjump.com"],
    "newapi.com" => ["newapi.com", "www.newapi.com"],
    "outbrain.com" => ["outbrain.com", "www.outbrain.com"],
    "pinzhitmall.com" => ["pinzhitmall.com", "www.pinzhitmall.com"],
    "qichexin.com" => ["qichexin.com", "www.qichexin.com"],
    "qutaobi.com" => ["qutaobi.com", "www.qutaobi.com"],
    "sdkclick.com" => ["sdkclick.com", "www.sdkclick.com"],
    "smgru.net" => ["smgru.net", "www.smgru.net"],
    "taoggou.com" => ["taoggou.com", "www.taoggou.com"],
    "tcxshop.com" => ["tcxshop.com", "www.tcxshop.com"],
    "tiaolianbao.com" => ["tiaolianbao.com", "www.tiaolianbao.com"],
    "topitme.com" => ["topitme.com", "www.topitme.com"],
    "tuipenguin.com" => ["tuipenguin.com", "www.tuipenguin.com"],
    "tuitiger.com" => ["tuitiger.com", "www.tuitiger.com"],
    "websd8.com" => ["websd8.com", "www.websd8.com"],
    "wx16999.com" => ["wx16999.com", "www.wx16999.com"],
    "xchmai.com" => ["xchmai.com", "www.xchmai.com"],
    "ygyzx.cn" => ["ygyzx.cn", "www.ygyzx.cn"],
    "yinmong.com" => ["yinmong.com", "www.yinmong.com"],
    "yitaopt.com" => ["yitaopt.com", "www.yitaopt.com"],
    "yjqiqi.com" => ["yjqiqi.com", "www.yjqiqi.com"],
    "yukhj.com" => ["yukhj.com", "www.yukhj.com"],
    "yumimobi.com" => ["yumimobi.com", "www.yumimobi.com"],
    "zlne800.com" => ["zlne800.com", "www.zlne800.com"],
    "zzd6.com" => ["zzd6.com", "www.zzd6.com"],

    // 一批广告公司和大数据公司域名 #223
    "appadhoc.com" => ["appadhoc.com", "www.appadhoc.com"],
    "appadhoc.net" => ["appadhoc.net", "www.appadhoc.net"],
    "dratio.com" => ["dratio.com", "www.dratio.com"],
    "um0.cn" => ["um0.cn", "www.um0.cn"],
    "um1.cn" => ["um1.cn", "www.um1.cn"],
    "umsns.com" => ["umsns.com", "www.umsns.com"],
    "umtrack.com" => ["umtrack.com", "www.umtrack.com"],
    "umtrack0.com" => ["umtrack0.com", "www.umtrack0.com"],
    "umtrack1.com" => ["umtrack1.com", "www.umtrack1.com"],
    "umtrack2.com" => ["umtrack2.com", "www.umtrack2.com"],
    "umv0.com" => ["umv0.com", "www.umv0.com"],
    "umv5.com" => ["umv5.com", "www.umv5.com"],
    "cnadid.cn" => ["cnadid.cn", "www.cnadid.cn"],
    "cnadid.com" => ["cnadid.com", "www.cnadid.com"],
    "digitalunion.cn" => ["digitalunion.cn", "www.digitalunion.cn"],
    "kxid.cn" => ["kxid.cn", "www.kxid.cn"],
    "mobid.cn" => ["mobid.cn", "www.mobid.cn"],
    "shuzhundsj.cn" => ["shuzhundsj.cn", "www.shuzhundsj.cn"],
    "shuzilm.cn" => ["shuzilm.cn", "www.shuzilm.cn"],
    "shuzilm.com" => ["shuzilm.com", "www.shuzilm.com"],
    "3edc.cn" => ["3edc.cn", "www.3edc.cn"],
    "appcpa.net" => ["appcpa.net", "www.appcpa.net"],
    "cpatrk.net" => ["cpatrk.net", "www.cpatrk.net"],
    "doudouknot.com" => ["doudouknot.com", "www.doudouknot.com"],
    "edutalkingdata.cn" => ["edutalkingdata.cn", "www.edutalkingdata.cn"],
    "edutalkingdata.com" => ["edutalkingdata.com", "www.edutalkingdata.com"],
    "jielou.net" => ["jielou.net", "www.jielou.net"],
    "lnk0.com" => ["lnk0.com", "www.lnk0.com"],
    "lnk8.cn" => ["lnk8.cn", "www.lnk8.cn"],
    "mpush.cn" => ["mpush.cn", "www.mpush.cn"],
    "myzhongguojie.cn" => ["myzhongguojie.cn", "www.myzhongguojie.cn"],
    "talkingdata.cn" => ["talkingdata.cn", "www.talkingdata.cn"],
    "talkingdata.com" => ["talkingdata.com", "www.talkingdata.com"],
    "talkingdata.com.cn" => ["talkingdata.com.cn", "www.talkingdata.com.cn"],
    "talkinggame.com" => ["talkinggame.com", "www.talkinggame.com"],
    "talkingnews.net" => ["talkingnews.net", "www.talkingnews.net"],
    "tddmp.com" => ["tddmp.com", "www.tddmp.com"],
    "tendcloud.cn" => ["tendcloud.cn", "www.tendcloud.cn"],
    "tendcloud.com" => ["tendcloud.com", "www.tendcloud.com"],
    "tenddata.cn" => ["tenddata.cn", "www.tenddata.cn"],
    "tenddata.com" => ["tenddata.com", "www.tenddata.com"],
    "tenddata.com.cn" => ["tenddata.com.cn", "www.tenddata.com.cn"],
    "tenddata.net" => ["tenddata.net", "www.tenddata.net"],
    "tengyuncloud.cn" => ["tengyuncloud.cn", "www.tengyuncloud.cn"],
    "tendata.cn" => ["tendata.cn", "www.tendata.cn"],
    "tendata.net" => ["tendata.net", "www.tendata.net"],
    "tendata.com" => ["tendata.com", "www.tendata.com"],
    "talkingdata.net" => ["talkingdata.net", "www.talkingdata.net"],
    "appcpa.co" => ["appcpa.co", "www.appcpa.co"],

    "udrig.com" => ["udrig.com", "www.udrig.com"],
    "xdrig.com" => ["xdrig.com", "www.xdrig.com"],
    "xuefenxi.com" => ["xuefenxi.com", "www.xuefenxi.com"],
    "datayi.cn" => ["datayi.cn", "www.datayi.cn"],
    "gio.ren" => ["gio.ren", "www.gio.ren"],
    "giocdn.com" => ["giocdn.com", "www.giocdn.com"],
    "growin.cn" => ["growin.cn", "www.growin.cn"],
    "growingio.cn" => ["growingio.cn", "www.growingio.cn"],
    "growingio.com" => ["growingio.com", "www.growingio.com"],
    "gz51la.com" => ["gz51la.com", "www.gz51la.com"],
    "appgo.cn" => ["appgo.cn", "www.appgo.cn"],
    "sharesdk.cn" => ["sharesdk.cn", "www.sharesdk.cn"],
    "42r.cn" => ["42r.cn", "www.42r.cn"],
    "47r.cn" => ["47r.cn", "www.47r.cn"],
    "5566ua.com" => ["5566ua.com", "www.5566ua.com"],
    "a0x.cn" => ["a0x.cn", "www.a0x.cn"],
    "aurorapush.cn" => ["aurorapush.cn", "www.aurorapush.cn"],
    "aurorapush.com" => ["aurorapush.com", "www.aurorapush.com"],
    "ausaas.cn" => ["ausaas.cn", "www.ausaas.cn"],
    "e0n.cn" => ["e0n.cn", "www.e0n.cn"],
    "japps.cn" => ["japps.cn", "www.japps.cn"],
    "jglinks.cn" => ["jglinks.cn", "www.jglinks.cn"],
    "jgmlink.cn" => ["jgmlink.cn", "www.jgmlink.cn"],
    "jgshare.cn" => ["jgshare.cn", "www.jgshare.cn"],
    "jmlinks.cn" => ["jmlinks.cn", "www.jmlinks.cn"],
    "jmlk.co" => ["jmlk.co", "www.jmlk.co"],
    "jpushoa.com" => ["jpushoa.com", "www.jpushoa.com"],
    "jsurvey.cn" => ["jsurvey.cn", "www.jsurvey.cn"],
    "jvoice.cn" => ["jvoice.cn", "www.jvoice.cn"],
    "kc9.cn" => ["kc9.cn", "www.kc9.cn"],
    "linkjg.cn" => ["linkjg.cn", "www.linkjg.cn"],
    "linksjg.cn" => ["linksjg.cn", "www.linksjg.cn"],
    "mlinkj.cn" => ["mlinkj.cn", "www.mlinkj.cn"],
    "mlinkjg.cn" => ["mlinkjg.cn", "www.mlinkjg.cn"],
    "n0q.cn" => ["n0q.cn", "www.n0q.cn"],
    "pushcfg.com" => ["pushcfg.com", "www.pushcfg.com"],
    "s0n.cn" => ["s0n.cn", "www.s0n.cn"],
    "thering.cn" => ["thering.cn", "www.thering.cn"],
    "xuanhk.com" => ["xuanhk.com", "www.xuanhk.com"],
    "12322app.com" => ["12322app.com", "www.12322app.com"],
    "abeacon.cn" => ["abeacon.cn", "www.abeacon.cn"],
    "abeacon.com" => ["abeacon.com", "www.abeacon.com"],
    "acloud.com" => ["acloud.com", "www.acloud.com"],
    "applk.cn" => ["applk.cn", "www.applk.cn"],
    "baywest.ac" => ["baywest.ac", "www.baywest.ac"],
    "cooltui.com" => ["cooltui.com", "www.cooltui.com"],
    "fangyi.cn" => ["fangyi.cn", "www.fangyi.cn"],
    "ge.cn" => ["ge.cn", "www.ge.cn"],
    "geatmap.com" => ["geatmap.com", "www.geatmap.com"],
    "geindex.com" => ["geindex.com", "www.geindex.com"],
    "gl.ink" => ["gl.ink", "www.gl.ink"],
    "huadan.in" => ["huadan.in", "www.huadan.in"],
    "igehuo.com" => ["igehuo.com", "www.igehuo.com"],
    "igetui.com" => ["igetui.com", "www.igetui.com"],
    "pusure.com" => ["pusure.com", "www.pusure.com"],
    "viyouhui.com" => ["viyouhui.com", "www.viyouhui.com"],

    //一些电视盒子相关的屏蔽列表
    "tuiapple.com" => ["activity.tuiapple.com"],
    "tudou.com" => ["ad.api.3g.tudou.com"],
    "youku.com" => [
        "ad.api.3g.youku.com",
        "ad.api.mobile.youku.com",
        "pcapp-data-collect.youku.com", // #884
        "valo.atm.youku.com", // #914
    ],
    "sohu.com" => ["agn.aty.sohu.com"],
    "gitv.tv" => ["api.cupid.ptqy.gitv.tv"],
    "tatagou.com.cn" => ["api.tatagou.com.cn"],
    "shandjj.com" => ["app.shandjj.com"],
    "koudaitong.com" => ["tj.koudaitong.com"],

    "011211.cn" => ["011211.cn"],
    "013572.cn" => ["013572.cn"],
    "020wujin.cn" => ["020wujin.cn"],
    "0512pifa.com.cn" => ["0512pifa.com.cn"],
    "0591jiajiao.com.cn" => ["0591jiajiao.com.cn"],
    "1357902.cn" => ["1357902.cn"],
    "1haows.cn" => ["1haows.cn"],
    "4008813318.com.cn" => ["4008813318.com.cn"],
    "431.red" => ["431.red"],
    "43gw.cn" => ["43gw.cn"],
    "467.red" => ["467.red"],
    "51juejinjie.com.cn" => ["51juejinjie.com.cn"],
    "555vps.cn" => ["555vps.cn"],
    "58xiao.cn" => ["58xiao.cn"],
    "77av.cn" => ["77av.cn"],
    "77tianxu.cn" => ["77tianxu.cn"],
    "77vip.wang" => ["77vip.wang"],
    "7ssw.cn" => ["7ssw.cn"],
    "7x-star.info" => ["7x-star.info"],
    "8020home.com.cn" => ["8020home.com.cn"],
    "805.red" => ["805.red"],
    "815ss.cn" => ["815ss.cn"],
    "8pay.wang" => ["8pay.wang"],
    "964ka.cn" => ["964ka.cn"],
    "98hx.cn" => ["98hx.cn"],
    "aaayc.cn" => ["aaayc.cn"],
    "abtao.wang" => ["abtao.wang"],
    "ahksqc.com.cn" => ["ahksqc.com.cn"],
    "ahxhny.cn" => ["ahxhny.cn"],
    "aibantian.cn" => ["aibantian.cn"],
    "aiia.xin" => ["aiia.xin"],
    "aiks.wang" => ["aiks.wang"],
    "aipu.mobi" => ["aipu.mobi"],
    "aivento.cn" => ["aivento.cn"],
    "aiwenyisheng.mobi" => ["aiwenyisheng.mobi"],
    "aixintou.com.cn" => ["aixintou.com.cn"],
    "amao.mobi" => ["amao.mobi"],
    "aup.mobi" => ["aup.mobi"],
    "baichuanbi.wang" => ["baichuanbi.wang"],
    "barrister.org.cn" => ["barrister.org.cn"],
    "baseniao.com.cn" => ["baseniao.com.cn"],
    "baxt.mobi" => ["baxt.mobi"],
    "beiyu.xin" => ["beiyu.xin"],
    "benniuluntai.cn" => ["benniuluntai.cn"],
    "bjhjw.com.cn" => ["bjhjw.com.cn"],
    "blood23.cn" => ["blood23.cn"],
    "bsmakeup.com.cn" => ["bsmakeup.com.cn"],
    "bzcjy.cn" => ["bzcjy.cn"],
    "calarm.info" => ["calarm.info"],
    "callmewx.cn" => ["callmewx.cn"],
    "cangshu.info" => ["cangshu.info"],
    "canwi.mobi" => ["canwi.mobi"],
    "cdshusen.cn" => ["cdshusen.cn"],
    "cdxjt.mobi" => ["cdxjt.mobi"],
    "chaoxianleather.ltd" => ["chaoxianleather.ltd"],
    "chengjie168.com.cn" => ["chengjie168.com.cn"],
    "chenyayun.com.cn" => ["chenyayun.com.cn"],
    "china-oxygen.cn" => ["china-oxygen.cn"],
    "china99315.cn" => ["china99315.cn"],
    "chinae.mobi" => ["chinae.mobi"],
    "chinapsj.com.cn" => ["chinapsj.com.cn"],
    "chinapulverizer.com.cn" => ["chinapulverizer.com.cn"],
    "chinaqirun.cn" => ["chinaqirun.cn"],
    "chinaso.red" => ["chinaso.red"],
    "chinaxiedu.cn" => ["chinaxiedu.cn"],
    "chuanmen.mobi" => ["chuanmen.mobi"],
    "codetips.wang" => ["codetips.wang"],
    "cqmjjx.cn" => ["cqmjjx.cn"],
    "crystalmart.cn" => ["crystalmart.cn"],
    "cs-bailing.com.cn" => ["cs-bailing.com.cn"],
    "cstmedia.com.cn" => ["cstmedia.com.cn"],
    "curtainsky.wang" => ["curtainsky.wang"],
    "cxlm.net.cn" => ["cxlm.net.cn"],
    "cyp889.cn" => ["cyp889.cn"],
    "cz4444.cn" => ["cz4444.cn"],
    "dashantechan.cn" => ["dashantechan.cn"],
    "dat.red" => ["dat.red"],
    "dhouse.mobi" => ["dhouse.mobi"],
    "diaoguoshi.mobi" => ["diaoguoshi.mobi"],
    "dinuojixie.com.cn" => ["dinuojixie.com.cn"],
    "dnjj.mobi" => ["dnjj.mobi"],
    "dspack.com.cn" => ["dspack.com.cn"],
    "dzhss.cn" => ["dzhss.cn"],
    "edmontonlife.info" => ["edmontonlife.info"],
    "eduace.com.cn" => ["eduace.com.cn"],
    "eyewand.cn" => ["eyewand.cn"],
    "fadian.xin" => ["fadian.xin"],
    "fanjis.cn" => ["fanjis.cn"],
    "fashion-hat.cn" => ["fashion-hat.cn"],
    "fdkjt.cn" => ["fdkjt.cn"],
    "feiyun.info" => ["feiyun.info"],
    "fhfg.net.cn" => ["fhfg.net.cn"],
    "fjs043.cn" => ["fjs043.cn"],
    "fjs056.cn" => ["fjs056.cn"],
    "forgot.mobi" => ["forgot.mobi"],
    "freestudio.info" => ["freestudio.info"],
    "fy6x8o.cn" => ["fy6x8o.cn"],
    "fzojq.info" => ["fzojq.info"],
    "getmos.cn" => ["getmos.cn"],
    "gjh111.cn" => ["gjh111.cn"],
    "glnvdc.cn" => ["glnvdc.cn"],
    "gpscard.cn" => ["gpscard.cn"],
    "greenprints.org.cn" => ["greenprints.org.cn"],
    "gsgqwl.wang" => ["gsgqwl.wang"],
    "gtlp.net.cn" => ["gtlp.net.cn"],
    "gzjtfzs.cn" => ["gzjtfzs.cn"],
    "gzmcjt.cn" => ["gzmcjt.cn"],
    "gzqczl.cn" => ["gzqczl.cn"],
    "gzsadlmy.cn" => ["gzsadlmy.cn"],
    "hanhooo.cn" => ["hanhooo.cn"],
    "haoduoyi1688.cn" => ["haoduoyi1688.cn"],
    "haoeat.info" => ["haoeat.info"],
    "haoyangmao.ltd" => ["haoyangmao.ltd"],
    "haoyoushuo.cn" => ["haoyoushuo.cn"],
    "hbyinzhibao.cn" => ["hbyinzhibao.cn"],
    "hccwwz.cn" => ["hccwwz.cn"],
    "heimi.red" => ["heimi.red"],
    "helove.xyz" => ["helove.xyz"],
    "hihufu.cn" => ["hihufu.cn"],
    "hktedu.site" => ["hktedu.site"],
    "hnwlyy.com.cn" => ["hnwlyy.com.cn"],
    "hongze.info" => ["hongze.info"],
    "hot-stories.cn" => ["hot-stories.cn"],
    "hskj88.cn" => ["hskj88.cn"],
    "htnote.info" => ["htnote.info"],
    "huanbao110.com.cn" => ["huanbao110.com.cn"],
    "huanbaoxiangmu.xyz" => ["huanbaoxiangmu.xyz"],
    "huangdao.info" => ["huangdao.info"],
    "huaqikonggu.com.cn" => ["huaqikonggu.com.cn"],
    "huaqiss.cn" => ["huaqiss.cn"],
    "huayiav.cn" => ["huayiav.cn"],
    "huha.ink" => ["huha.ink"],
    "huilian.info" => ["huilian.info"],
    "hundun.mobi" => ["hundun.mobi"],
    "hupuzhibo.cn" => ["hupuzhibo.cn"],
    "hygqtz.cn" => ["hygqtz.cn"],
    "hzdhr.cn" => ["hzdhr.cn"],
    "ib00.cn" => ["ib00.cn"],
    "imzhide.net.cn" => ["imzhide.net.cn"],
    "iqyewu.cn" => ["iqyewu.cn"],
    "iyumiao.com.cn" => ["iyumiao.com.cn"],
    "japheth.com.cn" => ["japheth.com.cn"],
    "jbcbio.cn" => ["jbcbio.cn"],
    "jhbsq.cn" => ["jhbsq.cn"],
    "jiaxinkang.cn" => ["jiaxinkang.cn"],
    "jingyixueyuan.cn" => ["jingyixueyuan.cn"],
    "jinlanqiangyi.cn" => ["jinlanqiangyi.cn"],
    "jiuaixianzhi.mobi" => ["jiuaixianzhi.mobi"],
    "jmait.cn" => ["jmait.cn"],
    "jmogo.cn" => ["jmogo.cn"],
    "jnykjgs.cn" => ["jnykjgs.cn"],
    "jpuv.cn" => ["jpuv.cn"],
    "jqki.cn" => ["jqki.cn"],
    "jsjs.pro" => ["jsjs.pro"],
    "judantech.site" => ["judantech.site"],
    "jxqfu.cn" => ["jxqfu.cn"],
    "jxss88.mobi" => ["jxss88.mobi"],
    "jyzmsy.com.cn" => ["jyzmsy.com.cn"],
    "kcvc.com.cn" => ["kcvc.com.cn"],
    "kedeng.xin" => ["kedeng.xin"],
    "king-oak.cn" => ["king-oak.cn"],
    "kocom.mobi" => ["kocom.mobi"],
    "kuaica.info" => ["kuaica.info"],
    "kuaidifeng.cn" => ["kuaidifeng.cn"],
    "l520.ltd" => ["l520.ltd"],
    "lafontainedessenterue.cn" => ["lafontainedessenterue.cn"],
    "lcr.kim" => ["lcr.kim"],
    "lcyt.info" => ["lcyt.info"],
    "ledian.pro" => ["ledian.pro"],
    "lightblue.red" => ["lightblue.red"],
    "lilangdianqi.cn" => ["lilangdianqi.cn"],
    "limkokwing-edu.cn" => ["limkokwing-edu.cn"],
    "lindawei.cn" => ["lindawei.cn"],
    "littlebee.site" => ["littlebee.site"],
    "liuguoyu.wang" => ["liuguoyu.wang"],
    "lixincxy.cn" => ["lixincxy.cn"],
    "llanotextiles.cn" => ["llanotextiles.cn"],
    "lningcity.com.cn" => ["lningcity.com.cn"],
    "lnjseq.info" => ["lnjseq.info"],
    "lnsbhzy.cn" => ["lnsbhzy.cn"],
    "lovecar.net.cn" => ["lovecar.net.cn"],
    "lulumao.com.cn" => ["lulumao.com.cn"],
    "lumeo.cn" => ["lumeo.cn"],
    "luomanzhubao.cn" => ["luomanzhubao.cn"],
    "lvxingxian.cn" => ["lvxingxian.cn"],
    "lwfw88.cn" => ["lwfw88.cn"],
    "lygnasa.cn" => ["lygnasa.cn"],
    "lytrjx.cn" => ["lytrjx.cn"],
    "lyzon.com.cn" => ["lyzon.com.cn"],
    "meigeer.com.cn" => ["meigeer.com.cn"],
    "menghuanzhilv.cn" => ["menghuanzhilv.cn"],
    "mifun.mobi" => ["mifun.mobi"],
    "murroliving.com.cn" => ["murroliving.com.cn"],
    "myzhuanghe.cn" => ["myzhuanghe.cn"],
    "nankuan.xin" => ["nankuan.xin"],
    "newweb.top" => ["newweb.top"],
    "newwiesdom.com.cn" => ["newwiesdom.com.cn"],
    "newzheng.cn" => ["newzheng.cn"],
    "ngtraveler.com.cn" => ["ngtraveler.com.cn"],
    "opai.red" => ["opai.red"],
    "opto-22.com.cn" => ["opto-22.com.cn"],
    "oxi23.cn" => ["oxi23.cn"],
    "pdiinfo.com.cn" => ["pdiinfo.com.cn"],
    "pdsxp.cn" => ["pdsxp.cn"],
    "penglei.info" => ["penglei.info"],
    "phjml.cn" => ["phjml.cn"],
    "pilipala.info" => ["pilipala.info"],
    "pszs388.cn" => ["pszs388.cn"],
    "qhsyg.top" => ["qhsyg.top"],
    "qianwei.wang" => ["qianwei.wang"],
    "qianyilamian.cn" => ["qianyilamian.cn"],
    "qichacha.ink" => ["qichacha.ink"],
    "qincai.info" => ["qincai.info"],
    "qishituan.top" => ["qishituan.top"],
    "qiyeit.com.cn" => ["qiyeit.com.cn"],
    "qkxlyg.cn" => ["qkxlyg.cn"],
    "qmin.xin" => ["qmin.xin"],
    "qnvljz.info" => ["qnvljz.info"],
    "qqwlfm.cn" => ["qqwlfm.cn"],
    "qrtjwa.cn" => ["qrtjwa.cn"],
    "samevay.com.cn" => ["samevay.com.cn"],
    "sapwells.info" => ["sapwells.info"],
    "scdcd333.cn" => ["scdcd333.cn"],
    "scfans.cn" => ["scfans.cn"],
    "scfw.wang" => ["scfw.wang"],
    "scifc.mobi" => ["scifc.mobi"],
    "sdlzmm.cn" => ["sdlzmm.cn"],
    "sdyongyan.com.cn" => ["sdyongyan.com.cn"],
    "shanyi.info" => ["shanyi.info"],
    "shinedaily.cn" => ["shinedaily.cn"],
    "shkunjia.com.cn" => ["shkunjia.com.cn"],
    "shoujiawang.cn" => ["shoujiawang.cn"],
    "shouyili.mobi" => ["shouyili.mobi"],
    "sjdjcn.cn" => ["sjdjcn.cn"],
    "smart-way2.com.cn" => ["smart-way2.com.cn"],
    "smmx3.cn" => ["smmx3.cn"],
    "sobin.wang" => ["sobin.wang"],
    "spreadable.com.cn" => ["spreadable.com.cn"],
    "sscjchina.com.cn" => ["sscjchina.com.cn"],
    "steeltrader.com.cn" => ["steeltrader.com.cn"],
    "sunderport.com.cn" => ["sunderport.com.cn"],
    "suntechauto.com.cn" => ["suntechauto.com.cn"],
    "sxjcjdc.cn" => ["sxjcjdc.cn"],
    "sxltfj.cn" => ["sxltfj.cn"],
    "szmpc.cn" => ["szmpc.cn"],
    "taihe2002.cn" => ["taihe2002.cn"],
    "tanzhen.info" => ["tanzhen.info"],
    "taogou.site" => ["taogou.site"],
    "tastevision.cn" => ["tastevision.cn"],
    "techkey.com.cn" => ["techkey.com.cn"],
    "tianhuicun.com.cn" => ["tianhuicun.com.cn"],
    "titan-solar.cn" => ["titan-solar.cn"],
    "tkmly.cn" => ["tkmly.cn"],
    "todayjiaxiang.cn" => ["todayjiaxiang.cn"],
    "tradesoul.cn" => ["tradesoul.cn"],
    "tuoens.cn" => ["tuoens.cn"],
    "txtxz.org.cn" => ["txtxz.org.cn"],
    "udr26c.cn" => ["udr26c.cn"],
    "uk8866.cn" => ["uk8866.cn"],
    "vaniok.cn" => ["vaniok.cn"],
    "vpkq.cn" => ["vpkq.cn"],
    "wangjinhu.wang" => ["wangjinhu.wang"],
    "wangzhichao.info" => ["wangzhichao.info"],
    "weilang.site" => ["weilang.site"],
    "wimaxnetworks.cn" => ["wimaxnetworks.cn"],
    "wojiacanting.info" => ["wojiacanting.info"],
    "wpe.red" => ["wpe.red"],
    "wtorain.red" => ["wtorain.red"],
    "wucheng.info" => ["wucheng.info"],
    "wzfjsh.cn" => ["wzfjsh.cn"],
    "wzhagc.cn" => ["wzhagc.cn"],
    "x1ka.cn" => ["x1ka.cn"],
    "xcvf.info" => ["xcvf.info"],
    "xiaocai-rookie.info" => ["xiaocai-rookie.info"],
    "xiaomeihq.info" => ["xiaomeihq.info"],
    "xinshengchuanmei.cn" => ["xinshengchuanmei.cn"],
    "xinyikeji.red" => ["xinyikeji.red"],
    "xmglass.cn" => ["xmglass.cn"],
    "xuexingkeji.cn" => ["xuexingkeji.cn"],
    "xxdlg.cn" => ["xxdlg.cn"],
    "xz518.cn" => ["xz518.cn"],
    "xztyzs.cn" => ["xztyzs.cn"],
    "yanhao.red" => ["yanhao.red"],
    "yaxujiancai.cn" => ["yaxujiancai.cn"],
    "ych168.cn" => ["ych168.cn"],
    "ycreateam.cn" => ["ycreateam.cn"],
    "ycx.kim" => ["ycx.kim"],
    "yglhcn.cn" => ["yglhcn.cn"],
    "ygpd.wang" => ["ygpd.wang"],
    "yimingxiang.com.cn" => ["yimingxiang.com.cn"],
    "yiqifaxian.wang" => ["yiqifaxian.wang"],
    "yiqiu.mobi" => ["yiqiu.mobi"],
    "yisheng120.info" => ["yisheng120.info"],
    "yizhongyi.info" => ["yizhongyi.info"],
    "ynyfcz.cn" => ["ynyfcz.cn"],
    "yppw666.cn" => ["yppw666.cn"],
    "yucefa.cn" => ["yucefa.cn"],
    "yw78.cn" => ["yw78.cn"],
    "yybeast.mobi" => ["yybeast.mobi"],
    "zghs.net.cn" => ["zghs.net.cn"],
    "zgjckgys.com.cn" => ["zgjckgys.com.cn"],
    "zhaowaibao.mobi" => ["zhaowaibao.mobi"],
    "zhougong.info" => ["zhougong.info"],
    "zhuren.site" => ["zhuren.site"],
    "zioe.com.cn" => ["zioe.com.cn"],
    "ziyouxiaoyuan.cn" => ["ziyouxiaoyuan.cn"],
    "zq-hk.cn" => ["zq-hk.cn"],
    "zsdzcpw.mobi" => ["zsdzcpw.mobi"],
    "zswhcsfww.mobi" => ["zswhcsfww.mobi"],
    "zszgjiejuw.mobi" => ["zszgjiejuw.mobi"],
    "zzasj.cn" => ["zzasj.cn"],
    "zzhssy.cn" => ["zzhssy.cn"],
    "158aq.com" => ["158aq.com"],
    "166br.com" => ["166br.com"],
    "2yt.cn" => ["2yt.cn"],
    "322927.com" => ["322927.com"],
    "559gp.com" => ["559gp.com"],
    "adszui.com" => ["adszui.com"],
    "baimuyuan.com.cn" => ["baimuyuan.com.cn"],
    "bibi100.com" => ["bibi100.com"],
    "bjsncykyjctsbjxzx.cn" => ["bjsncykyjctsbjxzx.cn"],
    "bontech-zh.com" => ["bontech-zh.com"],
    "bxg68.com" => ["bxg68.com"],
    "d9ad.com" => ["d9ad.com"],
    "dapaogg.xyz" => ["dapaogg.xyz"],
    "dreamine.com" => ["dreamine.com"],
    "duoduo.net" => ["duoduo.net"],
    "eeeqi.cn" => ["eeeqi.cn"],
    "fxsqsng.com" => ["fxsqsng.com"],
    "lee789.com" => ["lee789.com"],
    "loupan99.com" => ["loupan99.com"],
    "lrswl.com" => ["lrswl.com"],
    "myhard.com" => ["myhard.com"],
    "pagechoice.com" => ["pagechoice.com"],
    "pee.cn" => ["pee.cn"],
    "tenoad.com" => ["tenoad.com"],
    "itruni.com" => ["itruni.com"],
    "ucoz.com" => ["ucoz.com"],
    "union001.com" => ["union001.com"],
    "xiankandy.com" => ["xiankandy.com"],
    "xifatime.com" => ["xifatime.com"],
    "yjkyj.cn" => ["yjkyj.cn"],
    "zamar.cn" => ["zamar.cn"],

    "actonservice.com" => [
        #精简域名
        "actonservice.com",
    ],
    "daraz.com" => [
        # 精简域名，太长了，似乎是个电商平台
        "daraz.com",
    ],
    "llnw.net" => [
        # 精简域名，这是个cdn服务商，可能误杀
        "llnw.net",
    ],
    "windows.com" => [
        #精简域名，这个是windows推送服务？
        "hk2.wns.windows.com", // 不能直接屏蔽wns.windows.com #532
    ],
    "uc.cn" => [
        // dns日志提取
        "coral-task.uc.cn",
        "applogios.uc.cn", // uc log
        "gjapplog.uc.cn", // #442
        "applog.ucdns.uc.cn", // #442
        "applog-perf.uc.cn", // #1026
        "adashx.ut.uc.cn", // #1026
        "h-adashx.ut.uc.cn", // #1026
        "s-adashx.ut.uc.cn", // #1026
    ],
    "sm.cn" => [
        // dns日志提取
        "huichuan-mc.sm.cn",
        "huichuan.sm.cn",
    ],
    "alibaba.com" => [
        // dns日志提取
        "fourier.alibaba.com",
    ],
    "jj.cn" => [
        // dns日志提取
        "stat.m.jj.cn",
    ],
];
