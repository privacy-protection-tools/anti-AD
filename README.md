# anti-AD v3.0

## 基于dnsmasq的尽可能满足个人需求的(网页广告|APP广告|盒子广告|视频广告)屏蔽工具、隐私保护工具

### 3.0 changlog

- 严格匹配域名，增强生成列表的有效性
- 黑名单逻辑优化
- 重复域名剔除算法优化，进一步精简列表
- 代码bug修复



## 快速使用

1. 下载[adblock-for-dnsmasq.conf](https://raw.githubusercontent.com/gentlyx/anti-AD/master/adblock-for-dnsmasq.conf) , 保存到你的dnsmasq配置的正确目录下；
2. 重启dnsmasq服务；
3. 已经生效了，enjoy it！

## 个性化


运行start.sh,会去下载easylist,yhosts,neohosts,cjxlist等其他大神维护的屏蔽列表，然后整理合并成一个文件。拿着这个文件放入到例如/etc/dnsmasq.d/的目录下，然后重启dnsmasq进程就能加载。更新依赖于其他大神的内容更新了。

* `adblock-for-dnsmasq.conf` - 这个是最终生成的配置文件，大约每月更新4次,所以，如果你打算直接下载我维护的这个文件，不需要太高的pull频率

* `make-addr.php` - 是php脚本的主文件,执行php make-addr.php将更新配置文件

* `black_domain_list.php` - 是用来配置域名黑名单，这个威力巨大，谨慎使用

* `white_domain_list.php` - 白名单，优先级低于黑名单，即一个域名同时出现在黑白名单中时，将采用黑名单规则

* `block_domains.root.conf` - 这个文件是用来配置无论别人怎么更新，你都要保留的配置的，满足个性化需求，随心所欲。


## 背景故事

2011年iPad2发布的时候，我买了人生的第一台iPad，我会经常拿它玩一些小游戏和看网页，渐渐的，游戏里的广告、网页中的各种牛皮癣广告、视频app里的插播广告，变得肆无忌惮，长驱直入。我在使用的ddwrt，刚好有dnsmasq服务，于是搞了个脚本维护一个屏蔽列表，慢慢的手动抓包，然后再一条一条的填进去完全不科学了，继续写了个php脚本来更新它，放到github上，然后路由器中定期拉取，就实现了自动更新。
这些年来，各个视频网站的vip买了不少，各种app也大量的付费，赞助了，买服务了，买会员了，但抓包发现，仍然会有很多app偷偷上传各种统计数据，作为一个技术人员，明显感到被侵犯了的，在家庭网络这个环境，我要坚决维护自己一点点小偏执！这个项目放出来，除了屏蔽广告，希望对大家在个人保护隐私方面，也有所启发。

## 特别感谢

- [Adblock Plus](https://adblockplus.org/) - 畅游清爽洁净的网络！
- [neoFelhz/neohosts](https://github.com/neoFelhz/neohosts) - 自由·负责·克制 去广告 Hosts 项目
- [vokins/yhosts](https://github.com/vokins/yhosts) - yhosts
- [cjx82630/cjxlist](https://github.com/cjx82630/cjxlist) - Adblock Plus EasyList Lite与CJX's Annoyance List
