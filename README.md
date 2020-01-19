# anti-AD v4

##### anti-AD是综合著名广告过滤列表的高效广告屏蔽、隐私保护工具。能主动探测域名，支持国内外广告分开屏蔽，现已支持AdGuardHome，dnsmasq， Surge，Pi-Hole等优秀的网络组件。

使用anti-AD能够屏蔽广告域名，能屏蔽电视盒子广告，屏蔽app内置广告，同时屏蔽了一些日志收集、大数据统计等涉及个人隐私信息的站点，能够保护个人隐私不被偷偷上传。

本工具是将各大著名的hosts，ad filter lists，adblock list等的列表进行合并去重，再进行一系列的抽象化，例如主动剔除失效域名、easylist优化模糊匹配、增强的黑白名单机制等措施，最终生成期望的高命中率列表。

#### v4.2.1 (2020.01.19)

- 增加对恶意挖矿域名列表的屏蔽
- 引入严格模式，对恶意挖矿程序屏蔽时，默认屏蔽其主域名，例如www.baidu.com,严格模式启用时屏蔽baidu.com及其所有子域名
- 修复.cn域名匹配中发现的bug
- 一些正则表达式规则的进一步提取优化


#### v4.2 (2020.01.16)

- easylist支持正则表达式语法
- easylist白名单机制增强

#### v4.1 (2019.12.24)

- easylist支持通配符匹配域名
- easylist引入白名单赦免机制

#### v4.0 (2019.12.14)

- 开始支持主动探测无效域名，进一步降低最终生成文件（位于dist目录）的体积，提升命中率
- 开始支持dnsmasq，easylist，surge等多种格式
- 分离出国内域名的精简配置(`dist/*-basic.*`)和优化后的完整配置(`dist/*-full.*`)，可以根据需求选择屏蔽等级
- 代码重构，工程化，分离class，分离工具，逻辑更清晰

## 快速使用

### 1. dnsmasq
1. 下载[adblock-for-dnsmasq.conf](https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/adblock-for-dnsmasq.conf) ([jsDelivr加速](https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD@master/adblock-for-dnsmasq.conf)), 保存到你的dnsmasq配置的正确目录下；
2. 重启dnsmasq服务；
3. 已经生效了，enjoy it！

### 2. AdGuardHome
1. 进入AdGuardHome过滤器页面，选择添加过滤器
2. 输入名称 `anti-AD`，url地址：`https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-easylist.txt`([jsDelivr加速](https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD@master/anti-ad-easylist.txt))
3. 点击确认后即生效

### 3. Pi-Hole
1. 进入Pi-Hole的配置界面
2. 添加 `https://raw.githubusercontent.com/privacy-protection-tools/anti-AD/master/anti-ad-easylist.txt`([jsDelivr加速](https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD@master/anti-ad-easylist.txt)) 作为新的过滤器
3. 保存后生效

## jsDelivr镜像加速

_感谢 [@rufengsuixing](https://github.com/rufengsuixing) 提出的优化建议_
1. `adblock-for-dnsmasq.conf`: [https://cdn.jsdelivr.net/.../adblock-for-dnsmasq.conf](https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD@master/adblock-for-dnsmasq.conf)
2. `anti-ad-easylist.txt`: [https://cdn.jsdelivr.net/.../anti-ad-easylist.txt](https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD@master/anti-ad-easylist.txt)
3. `anti-ad-surge.txt`: [https://cdn.jsdelivr.net/.../anti-ad-surge.txt](https://cdn.jsdelivr.net/gh/privacy-protection-tools/anti-AD@master/anti-ad-surge.txt)

## 欢迎提意见

对于本工具，大家伙儿有任何建议，或者存在误杀，bug，其他错误，各种意见  [请开issue](https://github.com/gentlyxu/anti-AD/issues/new)


## 特别感谢

- [Adblock Plus](https://adblockplus.org/) - 畅游清爽洁净的网络！
- [neoFelhz/neohosts](https://github.com/neoFelhz/neohosts) - 自由·负责·克制 去广告 Hosts 项目
- [vokins/yhosts](https://github.com/vokins/yhosts) - yhosts
- [cjx82630/cjxlist](https://github.com/cjx82630/cjxlist) - Adblock Plus EasyList Lite与CJX's Annoyance List
