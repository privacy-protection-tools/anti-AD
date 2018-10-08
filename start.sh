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

php make-addr.php