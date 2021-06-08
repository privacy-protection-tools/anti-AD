# anti-AD change log

#### v4.5.1 (2021.05.31)
- 移动构建脚本到[另一个分支](https://github.com/privacy-protection-tools/anti-AD/tree/adlist-maker)，让默认分支看起来更干净
- github Actions的针对性优化，优化自动构建逻辑
- anti-AD仍然是一个完全开源的项目
- 没有了

#### v4.5.0 (2021.05.02)
- 重构工具`easylist-extend.php`，优化提升3倍执行效率
- 修复一部分小bug
- 开始支持[AdGuardHome新的modifiers](https://github.com/AdguardTeam/AdGuardHome/wiki/Hosts-Blocklists#modifiers)语法(目前测试阶段，adgh本身解析还有bug)

#### v4.3 (2020.02.04)
- 引入无效域名、无效hosts剔除机制，大幅提升各过滤列表命中率
- 为了更好的支持pi-hole，加入一个新的全域名列表 - `anti-ad-domains.txt`
- 根据网友 @xlighting2017 建议，更新surge的格式
- 引入数个新的配置参数，对输出结果精确控制
- 若干bug和逻辑修复

#### v4.2.2 (2020.02.02)

- 传统白名单增强模式，支持根域名单独加白而不影响其子域名
- 开始支持自动同步到另一个repo，自动发布更新
- 开始引入官网，逐步建设完善
- 修复一些逻辑bug

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


#### v3.0 (2019.10.19)

- 严格匹配域名，增强生成列表的有效性
- 黑名单逻辑优化
- 重复域名剔除算法优化，进一步精简列表
- 代码bug修复


#### 3.0之前(2017年某日开始)

单个文件生成列表，主要做了更新各种靠谱来源的收集
