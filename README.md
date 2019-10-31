# anti-AD v3.0

### 基于dnsmasq服务的广告封杀、恶意网站屏蔽、隐私保护工具

#### 3.0 changlog

- 严格匹配域名，增强生成列表的有效性
- 黑名单逻辑优化
- 重复域名剔除算法优化，进一步精简列表
- 代码bug修复



## 快速使用

1. 下载[adblock-for-dnsmasq.conf](https://raw.githubusercontent.com/gentlyxu/anti-AD/master/adblock-for-dnsmasq.conf) ([国内加速](https://anti-ad.oss-cn-shanghai.aliyuncs.com/adblock-for-dnsmasq.conf)), 保存到你的dnsmasq配置的正确目录下；
2. 重启dnsmasq服务；
3. 已经生效了，enjoy it！

## 个性化


运行start.sh,会去下载easylist,yhosts,neohosts,cjxlist等其他大神维护的屏蔽列表，然后整理合并成一个文件。拿着这个文件放入到例如/etc/dnsmasq.d/的目录下，然后重启dnsmasq进程就能加载。更新依赖于其他大神的内容更新了。

* `adblock-for-dnsmasq.conf` - 这个是最终生成的配置文件，大约每月更新4次,所以，如果你打算直接下载我维护的这个文件，不需要太高的pull频率

* `make-addr.php` - 是php脚本的主文件,执行php make-addr.php将更新配置文件

* `black_domain_list.php` - 是用来配置域名黑名单，这个威力巨大，谨慎使用

* `white_domain_list.php` - 白名单，优先级低于黑名单，即一个域名同时出现在黑白名单中时，将采用黑名单规则

* `block_domains.root.conf` - 这个文件是用来配置无论别人怎么更新，你都要保留的配置的，满足个性化需求，随心所欲。

## 欢迎提意见

对于本工具，大家伙儿有任何建议，或者存在误杀，bug，其他错误，各种意见  [请开issue](https://github.com/gentlyxu/anti-AD/issues/new)


## 特别感谢

- [Adblock Plus](https://adblockplus.org/) - 畅游清爽洁净的网络！
- [neoFelhz/neohosts](https://github.com/neoFelhz/neohosts) - 自由·负责·克制 去广告 Hosts 项目
- [vokins/yhosts](https://github.com/vokins/yhosts) - yhosts
- [cjx82630/cjxlist](https://github.com/cjx82630/cjxlist) - Adblock Plus EasyList Lite与CJX's Annoyance List
