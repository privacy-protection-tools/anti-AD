# anti-AD v4

##### anti-AD是综合著名广告过滤列表的高效广告屏蔽、隐私保护工具。能主动探测域名，支持国内外广告分开屏蔽，现已支持AdGuardHome，dnsmasq， Surge，Pi-Hole等

## 快速使用

### 1. dnsmasq
1. 下载[adblock-for-dnsmasq.conf](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/adblock-for-dnsmasq.conf) ([国内加速](https://anti-ad.oss-cn-shanghai.aliyuncs.com/adblock-for-dnsmasq.conf)), 保存到你的dnsmasq配置的正确目录下；
2. 重启dnsmasq服务；
3. 已经生效了，enjoy it！

### 2. AdGuardHome
1. 进入AdGuardHome过滤器页面，选择添加过滤器
2. 输入名称 `anti-AD`，url地址：`https://anti-ad.oss-cn-shanghai.aliyuncs.com/anti-ad-easylist.txt`
3. 点击确认后即生效

### 3. Pi-Hole
1. 进入Pi-Hole的配置界面
2. 添加 `https://anti-ad.oss-cn-shanghai.aliyuncs.com/anti-ad-easylist.txt` 作为新的过滤器
3. 保存后生效

## Changelog

#### v4.0 (2019.12.14)

- 开始支持检查无效域名，进一步降低最终生成文件的体积
- 分离出国内域名的精简配置(`dist/anti-ad-basic.conf`)和优化后的完整配置(`dist/anti-ad-full.conf`)，可以选择不同等级了
- 代码重构，工程化，分离class，分离工具，逻辑更清晰


## 个性化


运行start.sh,会去下载easylist,yhosts,neohosts,cjxlist等其他大神维护的屏蔽列表，然后整理合并成一个文件。拿着这个文件放入到例如/etc/dnsmasq.d/的目录下，然后重启dnsmasq进程就能加载。更新依赖于其他大神的内容更新了。

* `adblock-for-dnsmasq.conf` - 这个是最终生成的支持dnsmasq的广告屏蔽列表
* `anti-ad-easylist.txt` - 这个是最终生成的easylist格式，同时支持Pi-Hole，AdGuardHome的广告屏蔽列表
* `anti-ad-surge.txt` - 这个是最终生成的支持Surge格式的广告屏蔽列表
* `make-addr.php` - 是php脚本的主文件,执行php make-addr.php将更新屏蔽列表

## 欢迎提意见

对于本工具，大家伙儿有任何建议，或者存在误杀，bug，其他错误，各种意见  [请开issue](https://github.com/gentlyxu/anti-AD/issues/new)


## 特别感谢

- [Adblock Plus](https://adblockplus.org/) - 畅游清爽洁净的网络！
- [neoFelhz/neohosts](https://github.com/neoFelhz/neohosts) - 自由·负责·克制 去广告 Hosts 项目
- [vokins/yhosts](https://github.com/vokins/yhosts) - yhosts
- [cjx82630/cjxlist](https://github.com/cjx82630/cjxlist) - Adblock Plus EasyList Lite与CJX's Annoyance List
