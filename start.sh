#!/bin/bash

source /etc/profile

cd $(cd "$(dirname "$0")";pwd)
echo pwd is: `pwd`
git pull

echo '开始下载 easylist1...'
wget -O easylistchina+easylist.txt --timeout 30 https://easylist-downloads.adblockplus.org/easylistchina+easylist.txt

if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

echo '开始下载 easylist2...'
wget -O cjx-annoyance.txt --timeout 30 https://raw.githubusercontent.com/cjx82630/cjxlist/master/cjx-annoyance.txt

if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

/usr/local/php/bin/php make-addr.php

git add adblock-for-dnsmasq.conf
git commit -am "auto commit"
git push --force

