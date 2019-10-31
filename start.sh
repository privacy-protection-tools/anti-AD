#!/bin/bash

source /etc/profile

cd $(cd "$(dirname "$0")";pwd)
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

echo '开始下载 easylist3...'
wget -O fanboy-annoyance.txt --timeout 30 https://easylist.to/easylist/fanboy-annoyance.txt

if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi


echo '开始下载 hosts1...'
wget -O hosts1 --timeout 30 https://hosts.nfz.moe/full/hosts

if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

echo '开始下载 hosts2...'
wget -O hosts2 --timeout 60 https://raw.githubusercontent.com/vokins/yhosts/master/hosts

if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

echo '开始下载 hosts3...'
wget -O hosts3 --timeout 60 https://raw.githubusercontent.com/jdlingyu/ad-wars/master/hosts

if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi


PHP_RET=$(/usr/local/php/bin/php make-addr.php)

git add -A adblock-for-dnsmasq.conf hosts1 hosts2 host3 *.txt
git commit -am "auto commit. script output--- $PHP_RET"
git push --force
