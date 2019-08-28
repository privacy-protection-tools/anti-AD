# anti-AD

要特别感谢[neoFelhz/neohosts](https://github.com/neoFelhz/neohosts) - 自由·负责·克制 去广告 Hosts 项目

## 基于dnsmasq的尽可能满足个人需求的广告屏蔽、隐私保护工具

我被五花八门的广告（闪图、视频、牛皮癣……）弄的很是郁闷，包含隐私窃取的各种统计（大数据收集？）让我感觉被侵犯，于是乎在某一天突然就想在路由器上屏蔽掉他们……

既然是dnsmasq为主角，那么url中部分含有广告的path是无能为力的。
* * *

### 尽力保障屏蔽列表的通用性。[下载adblock-for-dnsmasq.conf](https://raw.githubusercontent.com/gentlyx/anti-AD/master/adblock-for-dnsmasq.conf) 这个文件可直接使用。
* * *

以下是多余的啰嗦：

dnsmasq的配置我就不赘述，建议是配置一个include dnsmasq.d 这样的一个目录下面所有的\*.conf文件

#### 生成最新广告屏蔽列表的方法：

运行start.sh,会去下载easylist,koolproxy以及github上其他大神维护的address或者hosts列表，然后整理合并成一个文件。拿着这个文件放入到例如/etc/dnsmasq.d/的目录下，然后重启dnsmasq进程就能加载。更新依赖于其他大神的内容更新了。

make-addr.php 是php脚本的主文件，将下载的诸多源easylist，hosts，dnsconf文件合并成一个最终的广告屏蔽列表文件

[adblock-for-dnsmasq.conf](https://raw.githubusercontent.com/gentlyx/anti-AD/master/adblock-for-dnsmasq.conf) 这个是最终生成的配置文件，大约每月更新4次,所以，如果你打算直接下载我维护的这个文件，不需要太高的pull频率

`black_domain_list.php` 是用来配置黑名单的

`white_domain_list.php` 白名单

`block_domains.root.conf` 这个文件是用来配置无论别人怎么更新，你都要保留的配置的，我的配置不一定适合你，请酌情修改,最大的个性化内容在这里了
