<?php
/**
 * easylist extend
 *
 * @file easylist-extend.php
 * @date 2021-05-01 23:14:30
 * @author gently
 *
 */
set_time_limit(0);

error_reporting(7);
date_default_timezone_set('Asia/Shanghai');
define('START_TIME', microtime(true));
define('ROOT_DIR', dirname(__DIR__) . '/');
const LIB_DIR = ROOT_DIR . 'lib/';

$black_domain_list = require_once LIB_DIR . 'black_domain_list.php';
require_once LIB_DIR . 'addressMaker.class.php';
const WILDCARD_SRC = ROOT_DIR . 'origin-files/wildcard-src-easylist.txt';
const WHITERULE_SRC = ROOT_DIR . 'origin-files/whiterule-src-easylist.txt';

$ARR_MERGED_WILD_LIST = array(
    'ad*.udn.com$dnstype=A|CNAME' => null,
    '*.mgr.consensu.org' => null,
    'vs*.gzcu.u3.ucweb.com' => null,
    'ad*.goforandroid.com' => null,
    'bs*.9669.cn' => null,
    '*serror*.wo.com.cn' => ['m' => '$dnstype=A|CNAME'],
    '*mistat*.xiaomi.com' => null,
    'affrh20*.com' => null,
    'assoc-amazon.*' => null,
    'clkservice*.youdao.com' => null,
    'dsp*.youdao.com' => null,
    'pussl*.com' => null,
    'putrr*.com' => null,
    't*.a.market.xiaomi.com' => null,
    'ad*.bigmir.net' => null,
    'log*.molitv.cn' => null,
    'adm*.autoimg.cn' => null,
    'cloudservice*.kingsoft-office-service.com' => null,
    'gg*.51cto.com' => null,
    'log.*.hunantv.com' => null,
    'iflyad.*.openstorage.cn' => null,
    '*customstat*.51togic.com' => null,
//    'appcloud*.zhihu.com' => null, // #344
    'ad*.molitv.cn' => null,
    'ads*-adnow.com' => null,
    'aeros*.tk' => null,
    'analyzer*.fc2.com' => null,
    'admicro*.vcmedia.vn' => null,
    'xn--xhq9mt12cf5v.*' => null,
    'freecontent.*' => null,
    'hostingcloud.*' => null,
    'jshosting.*' => null,
    'flightzy.*' => null,
    'sunnimiq*.cf' => null,
    'admob.*' => null,
    '*log.droid4x.cn' => null,
    '*tsdk.vivo.com.cn' => null,
    '*.mmstat.com' => null,
//    'sf*-ttcdn-tos.pstatp.com' => null,
    'f-log*.grammarly.io' => null,
    '24log.*' => null,
    '24smi.*' => null,
    'ad-*.wikawika.xyz' => null,
    'ablen*.tk' => null,
    'darking*.tk' => null,
    'doubleclick*.xyz' => null,
    'thepiratebay.*' => null,
    'adserver.*' => null,
    'clientlog*.music.163.com' => null,
    'brucelead*.com' => null,
    'gostats.*' => null,
    'gralfusnzpo*.top' => null,
    'oiwjcsh*.top' => null,
    '*-analytics*.huami.com' => null,
    'count*.pconline.com.cn' => null,
    'qchannel*.cn' => null,
    'sda*.xyz' => null,
    'ad-*.com' => null,
    'ad-*.net' => null,
    'webads.*' => null,
    'web-stat.*' => null,
    'waframedia*.*' => null,
    'wafmedia*.*' => null,
    'voluumtrk*.com' => null,
    'vmm-satellite*.com' => null,
    'vente-unique.*' => null,
    'vegaoo*.*' => null,
    'umtrack*.com' => null,
    'grjs0*.com' => null,
    'imglnk*.com' => null,
    'admarvel*.*' => null,
    'admaster*.*' => null,
    'adsage*.*' => null,
    'adsensor*.*' => null,
    'adservice*.*' => null,
    'adsh*.*' => null,
    'adsmogo*.*' => null,
    'adsrvmedia*.*' => null,
    'adsserving*.*' => null,
    'adsystem*.*' => null,
    'adwords*.*' => null,
    'analysis*.*' => null,
    'applovin*.*' => null,
    'appsflyer*.*' => null,
    'domob*.*' => null,
    'duomeng*.*' => null,
    'dwtrack*.*' => null,
    'guanggao*.*' => null,
    'lianmeng*.*' => null,
    //'monitor*.*' => null,
    'omgmta*.*' => null,
    'omniture*.*' => null,
    'openx*.*' => null,
    'partnerad*.*' => null,
    'pingfore*.*' => null,
    'socdm*.*' => null,
    'supersonicads*.*' => null,
    'tracking*.*' => null,
    'usage*.*' => null,
    'wlmonitor*.*' => null,
    'zjtoolbar*.*' => null,
    'engage.3m*' => null,
    '*.actonservice.com' => null,
    '*-cor0*.api.p001.1drv.com' => null,
    '*33*-*.1drv.com' => null,
    '2cnjuh34j*.com' => null,
    'ssc.southpark*' => null,
    'tr.*.espmp-*fr.net' => null,
    'tdep.vacansoleil.*' => null,
    'da.hornbach.*' => null,
    '*us*watcab*.blob.core.windows.net' => null,
    'xn--wxtr9fwyxk9c.*' => null,
);

$ARR_REGEX_LIST = array(
    '/^(\S+\.)?9377[a-z0-9]{2}\.com$/' => ['m' => '$dnstype=A'],
    '/^(\S+\.)?ad(s?[\d]+|m|s)?\./' => null,
    '/^(\S+\.)?advert/' => ['m' => '$denyallow=alibabacorp.com|alibabadns.com|sm.cn|tanx.com|alibaba-inc.com'],
    '/^(\S+\.)?affiliat(es?[0-9a-z]*?|ion[0-9\-a-z]*?|ly[0-9a-z\-]*?)\./' => null, // fixed #406
    '/^(\S+\.)?s?metrics\./' => null, // TODO 覆盖面很大
    '/^(\S+\.)?afgr[\d]{1,2}\.com$/' => null,
    '/^(\S+\.)?analytics(\-|\.)/' => null,
    '/^(\S+\.)?counter(\-|\.)/' => null,
    '/^(\S+\.)?pixels?\./' => null,
    '/^(\S+\.)?syma[a-z]\.cn$/' => null,
    '/^(\S+\.)?widgets?\./' => null,
    '/^(\S+\.)?(webstats?|swebstats?|mywebstats?)\./' => null,
    // '/^(\S+\.)?stat\..+?\.(com|cn|ru|it|de|cz|net|kr|ai|pl|th|fi|fr|jp|hu|bz|sk|se)$/' => null,
    '/^(\S+\.)?track(ing)?\./' => null,
    '/^(\S+\.)?tongji\./' => null,
    '/^(\S+\.)?toolbar\./' => null,
    '/^(\S+\.)?adservice\.google\./' => null,
    '/^(\S+\.)?d[\d]+\.sina(img)?(\.com)?\.cn/' => null,
    '/^(\S+\.)?sax[\dns]?\.sina\.com\.cn/' => null,
    '/^(\S+\.)?delivery([\d]{2}|dom|modo).com$/' => null,
    '/^(\S+\.)?[c-s]ads(abs|abz|ans|anz|ats|atz|del|ecs|ecz|ims|imz|ips|ipz|kis|kiz|oks|okz|one|pms|pmz)\.com/' => null,
    '/^(\S+\.)?[0-9a-z\-]{26,}\.(com|net|cn)(\.cn)?$/' => null, //超长域名
    '/^(\S+\.)?11599[\da-z]{2,20}\.com$/' => null, //"澳门新葡京"系列
    '/^(\S+\.)?61677[\da-z]{0,20}\.com$/' => null, //"澳门新葡京"系列
    '/^(\S+\.)?[0-9a-f]{15,}\.com$/' => null, //15个字符以上的16进制域名
    '/^(\S+\.)?[0-9a-z]{16,}\.xyz$/' => null, //16个字符以上的.xyz域名
    '/^(\S+\.)?6699[0-9]\.top$/' => null, //连号
    '/^(\S+\.)?abie[0-9]+\.top$/' => null, //连号
    '/^(\S+\.)?ad[0-9]{3,}m.com$/' => null, //连号
    '/^(\S+\.)?aj[0-9]{4,}.online$/' => null, //连号
    '/^(\S+\.)?xpj[0-9]\.net$/' => null, //连号
    '/^(\S+\.)?ylx-[0-9].com$/' => null, //连号
    '/^(\S+\.)?ali2[a-z]\.xyz$/' => null, //连号
    '/^(\S+\.)?777\-?partners?\.(net|com)$/' => null, //组合
    '/^(\S+\.)?voyage-prive\.[a-z]+(\.uk)?$/' => null, //组合
    '/^(\S+\.)?e7[0-9]{2,4}\.(net|com)?$/' => null, //组合
    '/^(\S+\.)?g[1-4][0-9]{8,9}\.com?$/' => null, //批量组合
    '/^(\S+\.)?hg[0-9]{4,5}\.com?$/' => null, //批量组合
    '/^(\S+\.)?333[1-9]{2}[0-9]{2}\.com?$/' => null, //批量组合
    '/^(\S+\.)?5551[0-9]{3}\.com?$/' => null, //批量组合

    // '/^(\S+\.)?(?=.*[a-f].*\.com$)(?=.*\d.*\.com$)[a-f0-9]{15,}\.com$/' => null,
);

//对通配符匹配或正则匹配增加的额外赦免规则
$ARR_WHITE_RULE_LIST = array(
    '@@||tongji.*kuwo.cn^' => 0,
    '@@||tracking.epicgames.com^' => 0,
    '@@||tracker.eu.org^' => 1, //强制加白，BT tracker，有形如2.tracker.eu.org的域
    '@@||stats.uptimerobot.com^' => 1, //uptimerobot监测相关 #38
    '@@||track.sendcloud.org^' => 0, //邮件退订域名
    '@@||log.mmstat.com^' => 0, //修复优酷视频显示禁用了cookie
    '@@||adm.10jqka.com.cn^' => 0, //同花顺
    '@@||center-h5api.m.taobao.com^' => 1, //h5页面
    '@@||app.adjust.com^' => 1, //https://github.com/AdguardTeam/AdGuardSDNSFilter/pull/186
    '@@||widget.weibo.com^' => 0, //微博外链
    '@@||uland.taobao.com^' => 1, //淘宝coupon #83
    '@@||advertisement.taobao.com^' => 1, //CNAME 被杀，导致s.click.taobao.com等服务异常
    '@@||baozhang.baidu.com^' => 1, //CNAME e.shifen.com
    '@@||tongji.edu.cn^' => 1, // 同济大学
    '@@||tongji.cn^' => 1, // 同济大学 #281
    '@@||ad.siemens.com.cn^' => 1, // 西门子下载中心
    '@@||sdkapi.sms.mob.com^' => 1, // 短信验证码 #127
    '@@||stats.gov.cn^' => 1, // 国家统计局 #144
    '@@||tj.gov.cn^' => 1,
    '@@||sax.sina.com.cn^' => 1, // #155
    '@@||api.ad-gone.com^' => 1, // #207
    '@@||news-app.abumedia.yql.yahoo.com^' => 1, // #206
    '@@||meizu.coapi.moji.com^' => 1, // #217
    '@@||track.cpau.info^' => 1, // #251
    '@@||passport.bobo.com^' => 1, // #265
    '@@||stat.jseea.cn^' => 1, // #279
    '@@||widget.intercom.io^' => 1, // #280
    '@@||track.toggl.com^' => 1, // #307
    '@@||www.msftconnecttest.com^' => 1, // #327
    '@@||storage.live.com^' => 1, // #333
    '@@||skyapi.onedrive.live.com^' => 1, // #333
    '@@||counter-strike.net^' => 1, // #332
    '@@||ftp.bmp.ovh^' => 1, // #353
    '@@||profile*.se.360.cn^' => 1, // #381
    '@@||pic.iask.cn^' => 1, // #397
    '@@||ad.jp^' => 1, // #399
    '@@||ad.azure.com^' => 1, // #399
    '@@||ad.cityu.edu.hk^' => 1, // #398
    '@@||edge-enterprise.activity.windows.com^' => 1, // #401
    '@@||edge.activity.windows.com^' => 1, // #401
    '@@||tracking-protection.cdn.mozilla.net^' => 1, // #407
    '@@||skydrivesync.policies.live.net^' => 1, // #409
    '@@||dxcloud.episerver.net^' => 1, // #418
);

//针对上游赦免规则anti-AD不予赦免的规则，即赦免名单的黑名单
$ARR_WHITE_RULE_BLK_LIST = array(
    '@@||github.com^' => null,
    '@@||github.io^' => null,
    '@@||ads.nipr.ac.jp^' => null,
    '@@||10010.com^' => null,
    '@@||10086.cn^' => null,
    '@@||17173im.allyes.com^' => null,
    '@@||199it.com^' => null,
    '@@||1point3acres.com^' => null,
    '@@||3dpchip.com^' => null,
    '@@||4horlover.com^' => null,
    '@@||51job.com^' => null,
    '@@||520call.me^' => null,
    '@@||5278.cool^' => null,
    '@@||58b.tv^' => null,
    '@@||5qidgde.com^' => null,
    '@@||85po.com^' => null,
    '@@||85porn.net^' => null,
    '@@||99wbwc.com^' => null,
    '@@||99ybcc.com^' => null,
    '@@||9zvip.net^' => null,
    '@@||abril.com.br^' => null,
    '@@||ad.10010.com^' => null,
    '@@||ad.abchina.com^' => null,
    '@@||ad.alimama.com^' => null,
    '@@||ad.kazakinfo.com^' => null,
    '@@||ad.ourgame.com^' => null,
    '@@||ad2.uoocuniversity.com^' => null,
    '@@||adf.ly^' => null,
    '@@||adfox.ru^' => null,
    '@@||adjs.8591.com.tw^' => null,
    '@@||admin.mgid.com^' => null,
    '@@||ads.askgamblers.com^' => null,
    '@@||ads.com^' => null,
    '@@||adsense.woso.cn^' => null,
    '@@||adv.blogupp.com^' => null,
    '@@||adv.cr^' => null,
    '@@||adv.gg^' => null,
    '@@||adv.welaika.com^' => null,
    '@@||advert.kf5.com^' => null,
    '@@||aetv.com^' => null,
    '@@||affyun.com^' => null,
    '@@||ak77now.pixnet.net^' => null,
    '@@||analytics.amplitude.com^' => null,
    '@@||annhe.net^' => null,
    '@@||anyknew.com^' => null,
    '@@||api-merchants.skimlinks.com^' => null,
    '@@||api.ad-gone.com^' => null,
    '@@||api.ads.tvb.com^' => null,
    '@@||api.nyda.pro^' => null,
    '@@||api.recaptcha.net^' => null,
    '@@||apk.tw^' => null,
    '@@||app-advertise.zhihuishu.com^' => null,
    '@@||app.adroll.com^' => null,
    '@@||archiveteam.org^' => null,
    '@@||arstechnica.com^' => null,
    '@@||aternos.org^' => null,
    '@@||bde4.cc^' => null,
    '@@||beta.bugly.qq.com^' => null,
    '@@||bingfeng.tw^' => null,
    '@@||blackmod.net^' => null,
    '@@||blog.ztjal.info^' => null,
    '@@||brighteon.com^' => null,
    '@@||browser.cloud.ucweb.com^' => null,
    '@@||btsax.info^' => null,
    '@@||buyad.bi-xenon.cn^' => null,
    '@@||captcha.su.baidu.com^' => null,
    '@@||ccllaa.com^' => null,
    '@@||centro.co.il^' => null,
    '@@||changyou.com^' => null,
    '@@||chinamobile.com^' => null,
    '@@||chinatelecom.com.cn^' => null,
    '@@||chuangkit.com^' => null,
    '@@||cloud.mail.ru^' => null,
    '@@||club.tgfcer.com^' => null,
    '@@||cmechina.net^' => null,
    '@@||cnprint.org^' => null,
    '@@||cocomanhua.com^' => null,
    '@@||colatour.com.tw^' => null,
    '@@||consent-pref.trustarc.com^' => null,
    '@@||consent.trustarc.com^' => null,
    '@@||cookielawinfo.com^' => null,
    '@@||coolinet.com^' => null,
    '@@||cwtv.com^' => null,
    '@@||cy.com^' => null,
    '@@||d1-dm.com^' => null,
    '@@||dailymail.co.uk^' => null,
    '@@||dashboard.idealmedia.com^' => null,
    '@@||dashboard.lentainform.com^' => null,
    '@@||dashboard.marketgid.com^' => null,
    '@@||dashboard.mgid.com^' => null,
    '@@||dashboard.tovarro.com^' => null,
    '@@||destinationamerica.com^' => null,
    '@@||digit77.com^' => null,
    '@@||dilidili.one^' => null,
    '@@||displayad.naver.com^' => null,
    '@@||dizhi99.com^' => null,
    '@@||dlkoo.cc^' => null,
    '@@||dlkoo.com^' => null,
    '@@||dmhy.b168.net^' => null,
    '@@||doubibackup.com^' => null,
    '@@||download.jumpw.com^' => null,
    '@@||download.mokeedev.com^' => null,
    '@@||e9china.net^' => null,
    '@@||easylife.tw^' => null,
    '@@||ecitic.com^' => null,
    '@@||edmondpoon.com^' => null,
    '@@||elife-cloud.blogspot.com^' => null,
    '@@||eolinker.com^' => null,
    '@@||eucookiedirective.com^' => null,
    '@@||experienceleague.adobe.com^' => null,
    '@@||experienceleague.corp.adobe.com^' => null,
    '@@||ez3c.tw^' => null,
    '@@||fangcloud.com^' => null,
    '@@||feed.mix.sina.com.cn^' => null,
    '@@||fharr.com^' => null,
    '@@||flattr.com^' => null,
    '@@||fontawesome.com^' => null,
    '@@||front-go.lemall.com^' => null,
    '@@||fullmatchesandshows.com^' => null,
    '@@||game735.com^' => null,
    '@@||games.pch.com^' => null,
    '@@||gaus.ee^' => null,
    '@@||gaybeeg.info^' => null,
    '@@||gelbooru.com^' => null,
    '@@||getrelax.cc^' => null,
    '@@||ggg50.pw^' => null,
    '@@||golangnote.com^' => null,
    '@@||gooogle.how^' => null,
    '@@||hanjubaike.com^' => null,
    '@@||hanjuwang.com^' => null,
    '@@||hanjuwang.net^' => null,
    '@@||healthyadvertising.es^' => null,
    '@@||hh010.com^' => null,
    '@@||history.com^' => null,
    '@@||ibf.tw^' => null,
    '@@||identity.mparticle.com^' => null,
    '@@||img.ads.tvb.com^' => null,
    '@@||informer.com^' => null,
    '@@||inoreader.com^' => null,
    '@@||ipfs-lab.com^' => null,
    '@@||jetzt.de^' => null,
    '@@||jin10.com^' => null,
    '@@||jinyongci.com^' => null,
    '@@||jjkmn.com^' => null,
    '@@||jlthjy.com^' => null,
    '@@||joyk.com^' => null,
    '@@||jsfiddle.net^' => null,
    '@@||jsjiami.com^' => null,
    '@@||kissjav.com^' => null,
    '@@||kk665403.pixnet.net^' => null,
    '@@||laotiesao.vip^' => null,
    '@@||ldxinyong.com^' => null,
    '@@||league-funny.com^' => null,
    '@@||leagueofmovie.com^' => null,
    '@@||lemon.baidu.com^' => null,
    '@@||liumingye.cn^' => null,
    '@@||lnk2.cc^' => null,
    '@@||login.mos.ru^' => null,
    '@@||ltzn.9377.com^' => null,
    '@@||mcbar.cn^' => null,
    '@@||mccc11.com^' => null,
    '@@||mccm88.com^' => null,
    '@@||media-cache*.pinimg.com^' => null,
    '@@||megaup.net^' => null,
    '@@||metrics.torproject.org^' => null,
    '@@||mi.cn^' => null,
    '@@||milfzr.com^' => null,
    '@@||minigame.qq.com^' => null,
    '@@||mmaa99.xyz^' => null,
    '@@||mmee04.com^' => null,
    '@@||mmff30.com^' => null,
    '@@||mmgd.xyz^' => null,
    '@@||mmuu22.link^' => null,
    '@@||mnighthk.net^' => null,
    '@@||monnsutogatya.com^' => null,
    '@@||moviesunusa.net^' => null,
    '@@||ms332.com^' => null,
    '@@||msn.com^' => null,
    '@@||msn.wrating.com^' => null,
    '@@||muzlan.top^' => null,
    '@@||myqqjd.com^' => null,
    '@@||namechk.com^' => null,
    '@@||netflav.com^' => null,
    '@@||newad.mail.wo.cn^' => null,
    '@@||niotv.com^' => null,
    '@@||nobugin.com^' => null,
    '@@||nodkey.xyz^' => null,
    '@@||oiihk.com^' => null,
    '@@||olgame.tw^' => null,
    '@@||ondemand.sas.com^' => null,
    '@@||optout.networkadvertising.org^' => null,
    '@@||panjiachen.github.io^' => null,
    '@@||pass.1688.com^' => null,
    '@@||passets-cdn.pinterest.com^' => null,
    '@@||passiontimes.hk^' => null,
    '@@||payload.cargocollective.com^' => null,
    '@@||pg-wuming.com^' => null,
    '@@||phs.tanx.com^' => null,
    '@@||pingjs.qq.com^' => null,
    '@@||pixelexperience.org^' => null,
    '@@||player.sundaysky.com^' => null,
    '@@||plugins.matomo.org^' => null,
    '@@||poedb.tw^' => null,
    '@@||pornbraze.com^' => null,
    '@@||premiumleecher.com^' => null,
    '@@||profile.getyounity.com^' => null,
    '@@||publisher.adservice.com^' => null,
    '@@||qqdie.com^' => null,
    '@@||r3sub.com^' => null,
    '@@||receive-a-sms.com^' => null,
    '@@||redditarchive.com^' => null,
    '@@||restream.io^' => null,
    '@@||reuters.com^' => null,
    '@@||rojadirecta.me^' => null,
    '@@||rule34hentai.net^' => null,
//    '@@||s-media*.pinimg.com^' => null,
    '@@||sakai-hk.com^' => null,
    '@@||sc2casts.com^' => null,
    '@@||sciencechannel.com^' => null,
    '@@||scyts.com^' => null,
    '@@||sdc.pingan.com^' => null,
    '@@||searchad.naver.com^' => null,
    '@@||seedingup.com^' => null,
    '@@||seedingup.de^' => null,
    '@@||seedingup.es^' => null,
    '@@||seedingup.fr^' => null,
    '@@||seedingup.it^' => null,
    '@@||serve.netsh.org^' => null,
    '@@||services.pornhub.com^' => null,
    '@@||seselah.com^' => null,
    '@@||sexylove.club^' => null,
    '@@||seyise8.com^' => null,
    '@@||seyy66.space^' => null,
    '@@||share1223.com^' => null,
    '@@||shopback.com.tw^' => null,
    '@@||slack.com^' => null,
    '@@||smallseotools.com^' => null,
    '@@||smtcaw.com^' => null,
    '@@||social.krunker.io^' => null,
    '@@||socialmedia.by^' => null,
    '@@||softwarebrother.com^' => null,
    '@@||sourcepoint.telegraph.co.uk^' => null,
    '@@||spanishdict.com^' => null,
    '@@||speedtest.net^' => null,
    '@@||spiegel.de^' => null,
    '@@||sssbozh.com^' => null,
    '@@||stream4free.live^' => null,
    '@@||swiso.org^' => null,
    '@@||switching.software^' => null,
    '@@||swjoy.com^' => null,
    '@@||szhr.com.cn^' => null,
    '@@||szhr.com^' => null,
    '@@||technews.tw^' => null,
    '@@||television-envivo.com^' => null,
    '@@||teliad.com^' => null,
    '@@||teliad.de^' => null,
    '@@||teliad.es^' => null,
    '@@||teliad.fr^' => null,
    '@@||teliad.it^' => null,
    '@@||th-sjy.com^' => null,
    '@@||thefreedictionary.com^' => null,
    '@@||thimble.mozilla.org^' => null,
    '@@||thisav.com^' => null,
    '@@||tiktok.com^' => null,
    '@@||tlc.com^' => null,
    '@@||tomshardware.co.uk^' => null,
    '@@||tomshardware.com^' => null,
    '@@||transferwise.com^' => null,
    '@@||trip.cmbchina.com^' => null,
    '@@||ttkdex.com^' => null,
    '@@||tuhu.cn^' => null,
    '@@||tui.click^' => null,
    '@@||tweaktown.com^' => null,
    '@@||twofactorauth.org^' => null,
    '@@||udp2p.com^' => null,
    '@@||upload.tube8.com^' => null,
    '@@||uptostream.com^' => null,
    '@@||upxin.net^' => null,
    '@@||urlgalleries.net^' => null,
    '@@||v2rayssr.com^' => null,
    '@@||vd.l.qq.com^' => null,
    '@@||viu.tv^' => null,
    '@@||ware.shop.jd.com^' => null,
    '@@||wavebox.io^' => null,
    '@@||web.archive.org^' => null,
    '@@||websetnet.com^' => null,
    '@@||weithenn.org^' => null,
    '@@||wenxuecity.com^' => null,
    '@@||wgun.net^' => null,
    '@@||wholehk.com^' => null,
    '@@||widget.myrentacar.me^' => null,
    '@@||wikia.nocookie.net^' => null,
    '@@||wikibooks.org^' => null,
    '@@||wikidata.org^' => null,
    '@@||wikinews.org^' => null,
    '@@||wikipedia.org^' => null,
    '@@||wikiquote.org^' => null,
    '@@||wikiversity.org^' => null,
    '@@||wiktionary.org^' => null,
    '@@||ws.webcaster.pro^' => null,
    '@@||www.gsxt.gov.cn^' => null,
    '@@||xia1ge.com^' => null,
    '@@||xianzhenyuan.cn^' => null,
    '@@||xidian.edu.cn^' => null,
    '@@||xilinjie.com^' => null,
    '@@||xiuren.org^' => null,
    '@@||xmpp-chat.pornhub.com^' => null,
    '@@||xmxing.net^' => null,
    '@@||yellowbridge.com^' => null,
    '@@||yesiget.i234.me^' => null,
    '@@||yibada.com^' => null,
    '@@||ymso.cc^' => null,
    '@@||yygsz.com^' => null,
    '@@||zbj.com^' => null,
    '@@||zeplin.io^' => null,
    '@@||zippyshare.com^' => null,
);

//针对上游通配符规则中anti-AD不予采信的规则，即通配符黑名单
$ARR_WILD_BLK_LIST = array(
    'cnt*rambler.ru' => null,
    'um*.com' => null,
);

if(PHP_SAPI != 'cli'){
    die('nothing.');
}

$src_file = '';
try{
    $file = $argv[1];
    $src_file = ROOT_DIR . $file;
}catch(Exception $e){
    echo "get args failed.", $e->getMessage(), "\n";
    die(0);
}

if(empty($src_file) || !is_file($src_file)){
    echo 'src_file:', $src_file, ' is not found.';
    die(0);
}

if(!is_file(WILDCARD_SRC) || !is_file(WHITERULE_SRC)){
    echo 'key file is not found.';
    die(0);
}

$wild_fp = fopen(WILDCARD_SRC, 'r');
$arr_wild_src = array();

while(!feof($wild_fp)){
    $wild_row = fgets($wild_fp, 512);
    if(empty($wild_row)){
        continue;
    }
    if(!preg_match('/^\|\|?([\w\-\.\*]+?)\^(\$([^=]+?,)?(image|third-party|script)(,[^=]+)?)?$/', $wild_row, $matches)){
        continue;
    }

    if(array_key_exists($matches[1], $ARR_WILD_BLK_LIST)){
        continue;
    }

    $matched = false;
    // TODO 此处匹配似乎还不够完美，需再次斟酌
    foreach($ARR_REGEX_LIST as $regex_str => $regex_row){
        if(preg_match($regex_str, str_replace('*', '', $matches[1]))){
            $matched = true;
            break;
        }
    }
    if($matched){
        continue;
    }
    $arr_wild_src[$matches[1]] = [];
}
fclose($wild_fp);

$arr_wild_src = array_merge($arr_wild_src, $ARR_MERGED_WILD_LIST);

$written_size = $line_count = 0;

$src_content = file_get_contents($src_file);
$attached_content = '';
$tmp_replaced_content = '';

//按需写入白名单规则
$whiterule = file(WHITERULE_SRC, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
$whiterule = array_fill_keys($whiterule, 0);
$ARR_WHITE_RULE_LIST = array_merge($whiterule, $ARR_WHITE_RULE_LIST);
$wrote_whitelist = [];
$remained_white_rule = [];
foreach($ARR_WHITE_RULE_LIST as $row => $v){
    if(empty($row) || substr($row, 0, 1) !== '@' || substr($row, 1, 1) !== '@'){
        continue;
    }
    $matches = array();
    if(!preg_match('/^@@\|\|([0-9a-z\.\-\*]+?)\^/', $row, $matches)){
        continue;
    }

    if(array_key_exists("@@||${matches[1]}^", $ARR_WHITE_RULE_BLK_LIST)){
        continue;
    }

    if(array_key_exists($matches[1], $wrote_whitelist)){
        continue;
    }

    if($v === 1){
        $wrote_whitelist[$matches[1]] = null;
        $attached_content .= "@@||${matches[1]}^\n";
        $line_count++;
        continue;
    }

    $origin_white_rule = $matches[1];
    $wrote_whitelist[$origin_white_rule] = null;
    $matches[1] = str_replace('*', '.abc.', $matches[1]);
    $matches[1] = str_replace('..', '.', $matches[1]);
    $extract_domain = addressMaker::extract_main_domain($matches[1]);
    if(!$extract_domain){
        $extract_domain = $matches[1];
    }

    // TODO 3级或以上域名加白2级域名的情况未纳入
    if(strpos($src_content, '|' . $extract_domain) === false){
        $remained_white_rule[$origin_white_rule] = 1;
        continue;
    }

    $attached_content .= "@@||${origin_white_rule}^\n";
    $line_count++;
}

unset($wrote_whitelist);

// 清洗正则表达式匹配
foreach($ARR_REGEX_LIST as $regex_str => $regex_row){
    $php_regex = str_replace(array('/^', '$/'), array('/^\|\|', '\^'), $regex_str);
    $php_regex = preg_replace('/(.+?[^$])\/$/', '\1.*\^', $php_regex);
    $php_regex .= "\n/m";

    $tmp_replaced_content = preg_replace($php_regex, '', $src_content);
    if($tmp_replaced_content === $src_content){
        continue;
    }
    $src_content = $tmp_replaced_content;
    $tmp_replaced_content = '';
    $attached_content .= $regex_str;
    if($regex_row && is_array($regex_row) && $regex_row['m']){
        $attached_content .= $regex_row['m'];
    }
    $attached_content .= "\n";
    $line_count++;

    foreach($remained_white_rule as $rmk => $rmv){
        if(preg_match($php_regex, '||' . str_replace('*', '123', $rmk) . "^\n\n")){
            $attached_content .= '@@||' . $rmk . "^\n";
            $line_count++;
            unset($remained_white_rule[$rmk]);
        }
    }
}

// 清洗*号模糊匹配
$wrote_wild_list = array();
foreach($arr_wild_src as $wild_rule => $wild_value){

    if(array_key_exists($wild_rule, $wrote_wild_list)){
        continue;
    }

    $php_regex = '/^\|\|(\S+\.)?' . str_replace(array('.', '*', '-'), array('\\.', '.*', '\\-'), $wild_rule) . "\^\n/m";
    $tmp_replaced_content = preg_replace($php_regex, '', $src_content);
    if($tmp_replaced_content == $src_content){
        continue;
    }

    $wrote_wild_list[$wild_rule] = 1;

    $src_content = $tmp_replaced_content;
    $tmp_replaced_content = '';
    $attached_content .= '||' . $wild_rule;
    if($wild_value && is_array($wild_value) && $wild_value['m']){
        $attached_content .= '^' . $wild_value['m'] . "\n";
    }else{
        $attached_content .= "^\n";
    }

    $line_count++;

    foreach($remained_white_rule as $rmk => $rmv){
        if(preg_match($php_regex, '||' . str_replace('*', '123', $rmk) . "^\n\n")){
            $attached_content .= '@@||' . $rmk . "^\n";
            $line_count++;
            unset($remained_white_rule[$rmk]);
        }
    }
}

$line_count += substr_count($src_content, "\n");
$src_content = str_replace("!Total lines: 00000\n", '!Total lines: ' . ($line_count - 4) . "\n" . $attached_content, $src_content);

file_put_contents($src_file, $src_content);
file_put_contents($src_file . '.md5', md5_file($src_file));
echo 'Time cost:', microtime(true) - START_TIME, "s, at ", date('m-d H:i:s'), "\n";
