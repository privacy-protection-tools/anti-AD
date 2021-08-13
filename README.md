# anti-AD

#### 致力于成为中文区命中率最高的广告过滤列表，实现精确的广告屏蔽和隐私保护。anti-AD现已支持AdGuardHome，dnsmasq， Surge，Pi-Hole，smartdns等网络组件。完全兼容常见的广告过滤工具所支持的各种广告过滤列表格式

使用anti-AD能够屏蔽广告域名，能屏蔽电视盒子广告，屏蔽app内置广告，同时屏蔽了一些日志收集、大数据统计等涉及个人隐私信息的站点，能够保护个人隐私不被偷偷上传。

本工具是通过域名解析层来屏蔽广告和保护隐私的，其将各大著名的hosts，ad filter lists，adblock list等的列表进行合并去重，再进行一系列的抽象化，例如主动剔除失效域名、easylist优化模糊匹配、增强的黑白名单机制等措施，最终生成期望的高命中率列表。

## 快速使用(使用官网地址，速度更稳定)

| 文件 	| raw 	| 官网地址 	| 适用于 	|
| --------------------------------	|:------------------:	| ----------------	|---------------------------------------------	|
| `adblock-for-dnsmasq.conf` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/adblock-for-dnsmasq.conf) 	| [官网地址，更稳定](https://anti-ad.net/anti-ad-for-dnsmasq.conf) 	| dnsmasq及其衍生版本 	|
| `anti-ad-easylist.txt` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-easylist.txt) 	| [官网地址，更稳定](https://anti-ad.net/easylist.txt)	| AdGuardHome（DNS过滤） 	|
| `anti-ad-adguard.txt` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-adguard.txt) 	| [官网地址，更稳定](https://anti-ad.net/adguard.txt)	| AdGuard（匹配整个URL的域名部分） 	|
| `anti-ad-domains.txt` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-domains.txt) 	| [官网地址，更稳定](https://anti-ad.net/domains.txt)	| Pi-Hole或其他。 	|
| `anti-ad-surge.txt` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-surge.txt) 	| [官网地址，更稳定](https://anti-ad.net/surge.txt)	| Surge或其他工具。 	|
| `anti-ad-surge2.txt` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-surge2.txt) 	| [官网地址，更稳定](https://anti-ad.net/surge2.txt)	| Surge或其他工具，DOMAIN-SET 格式性能更好。 	|
| `anti-ad-clash.yaml` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-clash.yaml) 	| [官网地址，更稳定](https://anti-ad.net/clash.yaml)	| Clash Premium。 	|
| `anti-ad-smartdns.conf` 	| [link](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-smartdns.conf) 	| [官网地址，更稳定](https://anti-ad.net/anti-ad-for-smartdns.conf) | SmartDNS 	|

## 版本历史

#### v4.5.1 (2021.05.31)
- 移动构建脚本到[另一个分支](https://github.com/privacy-protection-tools/anti-AD/tree/adlist-maker)，让默认分支看起来更干净
- github Actions的针对性优化，优化自动构建逻辑
- anti-AD仍然是一个完全开源的项目
- 没有了

#### v4.5.0 (2021.05.02)
- 重构工具`easylist-extend.php`，优化提升3倍执行效率
- 修复一部分小bug
- 开始支持[AdGuardHome新的modifiers](https://github.com/AdguardTeam/AdGuardHome/wiki/Hosts-Blocklists#modifiers)语法(目前测试阶段，adgh本身解析还有bug)

#### [更多版本演进历史>>>](https://github.com/privacy-protection-tools/anti-AD/blob/master/changelog.md)

## 一些补充的话

anti-AD在自我认知上始终是一个非主流的小众项目。此项目一直坚持每一行代码开源！anti-AD过滤列表的所有规则均来自上游列表和网友提交的issues，欢迎各界朋友审阅。在没有阅读代码或没有完全理解代码意图之前，本项目以及作者不再接受任何无端的质疑、猜忌，作者也不打算再浪费时间作出任何解释。

## 欢迎提issue

对于anti-AD，大家伙儿有任何建议，或者存在误杀，bug，其他错误，各种意见 [请开issue](https://github.com/privacy-protection-tools/anti-AD/issues/new/choose)

加入QQ群更实时的交流：716981535 <br>
![716981535](https://user-images.githubusercontent.com/1243610/73809320-de535780-480d-11ea-82f5-15d4c3ccb0c0.png)

## Special Thanks To

- [fanboy-annoyance](https://easylist.to/easylist/fanboy-annoyance.txt) - 优秀的easylist列表
- [notracking/hosts-blocklists-scripts](https://github.com/notracking/hosts-blocklists-scripts) - 提供无效域名和无效hosts列表
- [Adblock Plus](https://adblockplus.org/) - 畅游清爽洁净的网络！
- [neoFelhz/neohosts](https://github.com/neoFelhz/neohosts) - 自由·负责·克制 去广告 Hosts 项目
- [vokins/yhosts](https://github.com/vokins/yhosts) - yhosts（该源已停止维护）
- [cjx82630/cjxlist](https://github.com/cjx82630/cjxlist) - Adblock Plus EasyList Lite与CJX's Annoyance List
- _[@rufengsuixing](https://github.com/rufengsuixing) 提出的jsDelivr加速过滤列表下载的建议_
- _[@xlighting2017](https://github.com/xlighting2017) 提供的[surge格式建议](https://github.com/privacy-protection-tools/anti-AD/issues/29)_
- [ACL4SSR/ACL4SSR](https://github.com/ACL4SSR/ACL4SSR) - 一些常见APP的广告 @[wchqybs](https://github.com/wchqybs) in [#79](https://github.com/privacy-protection-tools/anti-AD/issues/79)
- [ADgk.txt](https://github.com/banbendalao/ADgk) - 鸣谢 坂本dalao
- [jdlingyu/ad-wars](https://github.com/jdlingyu/ad-wars) - 只是 ad-wars 的帮助文档
- [hoshsadiq/adblock-nocoin-list](https://github.com/hoshsadiq/adblock-nocoin-list) - 恶意挖矿屏蔽列表
- [easylist.to](https://easylist.to/) - 感谢提供出色的easylist
- [ZeroDot1/CoinBlockerLists](https://gitlab.com/ZeroDot1/CoinBlockerLists) - 屏蔽恶意劫持挖矿
- [crazy-max/WindowsSpyBlocker](https://github.com/crazy-max/WindowsSpyBlocker/) - to block spying and tracking on Windows systems.

## 本项目使用PHPStorm开发，特此感谢

[![phpstorm](./others/icon-phpstorm.png)](https://www.jetbrains.com/zh-cn/opensource/)
