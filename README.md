# anti-AD

## 基于dnsmasq的尽可能满足个人需求的广告屏蔽、隐私保护工具
（*哈哈，故意这么高大上的～*）

我被五花八门的广告（闪图、视频、牛皮癣……）弄的很郁闷，包含隐私窃取的各种统计（大数据收集？）让我胆寒，于是乎在某一天突然就想在路由器上屏蔽掉他们……

* * *

**`这里特别注意，这个东西是根据我自己的需求来写的，不一定具有普适性。`**

但如果你刚好看到这里，那我就说一下：

dnsmasq的配置我就不赘述，建议是配置一个include dnsmasq.d 这样的一个目录下面所有的*.conf文件

运行php make-addr.php ,会去下载github上其他大神维护的address或者hosts列表，然后整理合并成一个文件。拿着这个文件放入到例如/etc/dnsmasq.d/的目录下，然后重启dnsmasq进程就能加载。更新依赖于其他大神的内容更新了。

[adblock-for-dnsmasq.conf](https://raw.githubusercontent.com/gentlyx/anti-AD/master/adblock-for-dnsmasq.conf) 这个就是最终生成的配置文件，我会保持一定频率的更新，大约每月2次,所以，如果你打算直接下载我维护的这个文件，那可能不需要太高的频率

black_domain_list.php 是用来配置黑名单的

block_domains.root.conf 这个文件是用来配置无论别人怎么更新，你都要保留的配置的，我的配置不一定适合你，请酌情修改


2018.10.04 凌晨于深圳
