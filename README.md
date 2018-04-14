# anti-AD

## 还是装模作样的写一个说明？

首先，这个东西是根据我自己的需求来写的，不一定具有普适性。但如果你刚好看到这里，那我就说一下：

dnsmasq的配置我就不赘述，运行php make-addr.php ,会去下载github上其他大神维护的address或者hosts列表，然后整理合并成一个文件。拿着这个文件放入到例如/etc/dnsmasq.d/的目录下，然后重启dnsmasq进程就能加载。更新依赖于其他大神的内容更新了。

black_domain_list.php 是用来配置黑名单的

block_domains.root.conf 这个文件是用来配置无论别人怎么更新，你都要保留的配置的，吼吼~~~


2017.12.31 20:25