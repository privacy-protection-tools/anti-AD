# anti-AD

## 基于dnsmasq的尽可能满足个人需求的广告屏蔽、隐私保护工具
（*哈哈，故意这么高大上的～*）

我被五花八门的广告（闪图、视频、牛皮癣……）弄的很是郁闷，包含隐私窃取的各种统计（大数据收集？）让我感觉被侵犯，于是乎在某一天突然就想在路由器上屏蔽掉他们……

既然是dnsmasq为主角，那么url中部分含有广告的path是无能为力的。
* * *

### 我尽量保持广告屏蔽列表的通用性。最简单的，只要[下载adblock-for-dnsmasq.conf](https://raw.githubusercontent.com/gentlyx/anti-AD/master/adblock-for-dnsmasq.conf) 这个文件即可。

但如果你刚好看到这里，那我就说一下：

dnsmasq的配置我就不赘述，建议是配置一个include dnsmasq.d 这样的一个目录下面所有的\*.conf文件

运行start.sh,会去下载easylist,koolproxy以及github上其他大神维护的address或者hosts列表，然后整理合并成一个文件。拿着这个文件放入到例如/etc/dnsmasq.d/的目录下，然后重启dnsmasq进程就能加载。更新依赖于其他大神的内容更新了。

[adblock-for-dnsmasq.conf](https://raw.githubusercontent.com/gentlyx/anti-AD/master/adblock-for-dnsmasq.conf) 这个是最终生成的配置文件，我会保持一定频率的更新，大约每月2次,所以，如果你打算直接下载我维护的这个文件，那可能不需要太高的频率

black_domain_list.php 是用来配置黑名单的

block_domains.root.conf 这个文件是用来配置无论别人怎么更新，你都要保留的配置的，我的配置不一定适合你，请酌情修改,最大的个性化内容在这里了
