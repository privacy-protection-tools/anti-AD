# anti-AD v4.0

### 基于dnsmasq服务的广告封杀、恶意网站屏蔽、隐私保护工具

#### v4.0 (2019.12.14)

- 开始支持检查无效域名，进一步降低最终生成文件的体积
- 分离出国内域名的精简配置(`dist/anti-ad-basic.conf`)和优化后的完整配置(`dist/anti-ad-full.conf`)，可以选择不同等级了
- 代码重构，工程化，分离class，分离工具，逻辑更清晰


## 快速使用

### 1. dnsmasq
1. 下载[adblock-for-dnsmasq.conf](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/adblock-for-dnsmasq.conf) ([jsDelivr加速](https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD/adblock-for-dnsmasq.conf)), 保存到你的dnsmasq配置的正确目录下；
2. 重启dnsmasq服务；
3. 已经生效了，enjoy it！

### 2. AdGuardHome
1. 进入AdGuardHome过滤器页面，选择添加过滤器
2. 输入名称 `anti-AD`，url地址：`https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-easylist.txt`([jsDelivr加速](https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD/anti-ad-easylist.txt))
3. 点击确认后即生效
## jsDelivr镜像(测试加速效果不错)

### 3. Pi-Hole
1. 进入Pi-Hole的配置界面
2. 添加 `https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-easylist.txt`([jsDelivr加速](https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD/anti-ad-easylist.txt)) 作为新的过滤器
3. 保存后生效

## jsDelivr镜像(经测试加速效果不错)

感谢 [@rufengsuixing](https://github.com/rufengsuixing) 的建议
1. `adblock-for-dnsmasq.conf`: https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD/adblock-for-dnsmasq.conf
2. `anti-ad-easylist.txt`: https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD/anti-ad-easylist.txt
3. `anti-ad-surge.txt`: https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD/anti-ad-surge.txt


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
