#!/bin/bash
#每周运行一次

source /etc/profile
cd $(cd "$(dirname "$0")";pwd)

nohup php research-addr.php >> ./std-research.out
cd ../dist/
sed -E 's/address=\/(.+)?\//||\1^/g' anti-ad-dnsmasq-full.conf > anti-ad-easylist-full.conf
sed -E 's/address=\/(.+)?\//||\1^/g' anti-ad-dnsmasq-basic.conf > anti-ad-easylist-basic.conf
sed -E 's/address=\/(.+)?\//DOMAIN-SUFFIX,\1,REJECT/g' anti-ad-dnsmasq-basic.conf >anti-ad-surge-basic.txt
sed -E 's/address=\/(.+)?\//DOMAIN-SUFFIX,\1,REJECT/g' anti-ad-dnsmasq-full.conf >anti-ad-surge-full.txt
sed -i '3 i [RULE]' anti-ad-surge-basic.txt
sed -i '3 i [RULE]' anti-ad-surge-full.txt
