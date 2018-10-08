#!/bin/sh

source /etc/profile

cd $(cd "$(dirname "$0")";pwd)
echo pwd is: `pwd`

echo '开始下载 easylist1...'
wget -O easylistchina+easylist.txt https://easylist-downloads.adblockplus.org/easylistchina+easylist.txt

if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

echo '开始下载 easylist2...'
wget -O koolproxy.txt https://kprule.com/koolproxy.txt

if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

/usr/local/php/bin/php make-addr.php

git pull
git commit -a -m "auto commit"
git push https://gentlyx:3d5431cc8f2586effaee94efb7d39904db3a3a0c@github.com/gentlyx/anti-AD.git
