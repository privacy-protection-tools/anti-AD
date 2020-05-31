# anti-AD

#### anti-AD是目前中文区命中率最高的广告过滤列表，实现了精确的广告屏蔽和隐私保护。现已支持AdGuardHome，dnsmasq， Surge，Pi-Hole，SmartDNS等网络组件。anti-AD的多种输出格式，完全满足常见的广告屏蔽工具、广告过滤工具的要求，我们始终坚持尽可能的保障每种输出格式的广告过滤效果一致。

使用anti-AD能够屏蔽广告域名，能屏蔽电视盒子广告，屏蔽app内置广告，同时屏蔽了一些日志收集、大数据统计等涉及个人隐私信息的站点，能够保护个人隐私不被偷偷上传。

本工具是通过域名解析层来屏蔽广告和保护隐私的，其将各大著名的hosts，ad filter lists，adblock list等的列表进行合并去重，再进行一系列的抽象化，例如主动剔除失效域名、easylist优化模糊匹配、增强的黑白名单机制等措施，最终生成期望的高命中率列表。

## 快速使用(可尝试gitee地址的加速效果)

| 文件 	| raw 	| gitee 	| 操作参考 	| 适用于 	|
| --------------------------------	|:------------------:	| -------- | -------------------------------------------------------------------------------------------------------------------------------------------	|---------------------------------------------	|
| `adblock-for-dnsmasq.conf` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/adblock-for-dnsmasq.conf) 	| [加速🚀](https://gitee.com/privacy-protection-tools/anti-ad/raw/master/anti-ad-for-dnsmasq.conf) 	| 1. 下载过滤列表文件后, 保存到你的dnsmasq配置的正确目录下；<br>2. 重启dnsmasq服务；<br>3. 已经生效了，enjoy it。 	| [dnsmasq](http://www.thekelleys.org.uk/dnsmasq/doc.html)及其衍生版本 	|
| `anti-ad-easylist.txt` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-easylist.txt) 	| [加速🚀](https://gitee.com/privacy-protection-tools/anti-ad/raw/master/easylist.txt) 	| 1. 进入AdGuardHome过滤器页面；<br>2. 选择添加过滤器输入名称 anti-AD，url地址填raw链接或者gitee；<br>3. 点击确认后即生效 	| [AdGuardHome](https://github.com/AdguardTeam/AdGuardHome) 	|
| `anti-ad-domains.txt` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-domains.txt) 	| [加速🚀](https://gitee.com/privacy-protection-tools/anti-ad/raw/master/domains.txt) 	| 以Pi-Hole为例<br>1. 进入pi-hole设置界面<br>2. 添加本domains列表链接到pi-hole的过滤器列表中<br>3. 点击save & update<br>4. 更新成功后即可生效 	| [Pi-Hole](https://github.com/pi-hole/pi-hole)以及任何支持域名过滤列表的工具。 	|
| `anti-ad-surge.txt` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-surge.txt) 	| [加速🚀](https://gitee.com/privacy-protection-tools/anti-ad/raw/master/surge.txt) 	| 直接订阅本条链接，保存后生效 	| Surge或任何支持解析该格式的广告过滤工具。 	|
| `anti-ad-smartdns.conf` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-smartdns.conf) 	| [加速🚀](https://gitee.com/privacy-protection-tools/anti-ad/raw/master/anti-ad-for-smartdns.conf) 	| 1. 下载本过滤文件，放置在合适位置; <br>2. 在smartdns.conf中配置`conf-file`来关联;<br> 3. 重启smartdns服务，生效 	| [SmartDNS](https://github.com/pymumu/smartdns) 	|

## 版本历史


#### v4.3 (2020.02.04)
- 引入无效域名、无效hosts剔除机制，大幅提升各过滤列表命中率
- 为了更好的支持pi-hole，加入一个新的全域名列表 - `anti-ad-domains.txt`
- 根据网友 [@xlighting2017](https://github.com/privacy-protection-tools/anti-AD/issues/29) 建议，更新surge的格式
- 引入数个新的配置参数，对输出结果精确控制
- 若干bug和逻辑修复

#### v4.2.2 (2020.02.02)

- 传统白名单增强模式，支持根域名单独加白而不影响其子域名
- 开始支持自动同步到另一个repo，自动发布更新
- 开始引入官网，逐步建设完善
- 修复一些逻辑bug

#### [更多版本演进历史>>>](https://github.com/privacy-protection-tools/anti-AD/blob/master/changelog.md)

## 一些补充的话

anti-AD在自我认知上始终是一个非主流的小众项目，受众群体较为狭窄。项目一直坚持每一行代码面向全球互联网完全开源！anti-AD过滤列表的所有规则均来自上游列表和网友提交的issues，欢迎各界朋友审阅。在没有阅读代码或没有完全理解代码意图之前，本项目以及作者不再接受任何无端的质疑、猜忌，作者也不打算再浪费时间作出任何解释。

## 欢迎提issue

对于anti-AD，大家伙儿有任何建议，或者存在误杀，bug，其他错误，各种意见 [请开issue](https://github.com/privacy-protection-tools/anti-AD/issues/new/choose)

加入QQ群更实时的交流：716981535 <br>
![716981535](https://user-images.githubusercontent.com/1243610/73809320-de535780-480d-11ea-82f5-15d4c3ccb0c0.png)

## Special Thanks to

- [notracking/hosts-blocklists-scripts](https://github.com/notracking/hosts-blocklists-scripts) - 提供无效域名和无效hosts列表
- [Adblock Plus](https://adblockplus.org/) - 畅游清爽洁净的网络！
- [neoFelhz/neohosts](https://github.com/neoFelhz/neohosts) - 自由·负责·克制 去广告 Hosts 项目
- [vokins/yhosts](https://github.com/vokins/yhosts) - yhosts
- [cjx82630/cjxlist](https://github.com/cjx82630/cjxlist) - Adblock Plus EasyList Lite与CJX's Annoyance List
- _[@rufengsuixing](https://github.com/rufengsuixing) 提出的jsDelivr加速过滤列表下载的建议_
- _[@xlighting2017](https://github.com/xlighting2017) 提供的[surge格式建议](https://github.com/privacy-protection-tools/anti-AD/issues/29)_
- [ACL4SSR/ACL4SSR](https://github.com/ACL4SSR/ACL4SSR) - 一些常见APP的广告 @[wchqybs](https://github.com/wchqybs) in [#79](https://github.com/privacy-protection-tools/anti-AD/issues/79)
- [ADgk.txt](https://gitee.com/banbendalao/adguard/raw/master/ADgk.txt)
- [malwaredomainlist](https://www.malwaredomainlist.com/hostslist/hosts.txt)
- [hoshsadiq/adblock-nocoin-list](https://github.com/hoshsadiq/adblock-nocoin-list)
- [easylist.to](https://easylist.to/)
