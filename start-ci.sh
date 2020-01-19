#!/bin/bash

source /etc/profile

cd $(cd "$(dirname "$0")";pwd)

echo '开始下载 easylist1...'
curl -o ./origin-files/easylist1.txt --connect-timeout 60 \
 -s \
https://easylist-downloads.adblockplus.org/easylistchina+easylist.txt

# shellcheck disable=SC2181
if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

echo '开始下载 easylist2...'
curl -o ./origin-files/easylist2.txt --connect-timeout 60 \
 -s \
https://raw.githubusercontent.com/cjx82630/cjxlist/master/cjx-annoyance.txt

# shellcheck disable=SC2181
if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

echo '开始下载 easylist3...'
curl -o ./origin-files/easylist3.txt --connect-timeout 60 \
 -s \
https://easylist.to/easylist/fanboy-annoyance.txt

# shellcheck disable=SC2181
if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi


echo '开始下载 easylist4...'
curl -o ./origin-files/easylist4.txt --connect-timeout 60 \
 -s \
https://easylist.to/easylist/easyprivacy.txt

# shellcheck disable=SC2181
if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi


echo '开始下载 hosts1...'
curl -o ./origin-files/hosts1 --connect-timeout 60 \
 -s \
 https://raw.githubusercontent.com/neoFelhz/neohosts/gh-pages/full/hosts.txt

# shellcheck disable=SC2181
if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

echo '开始下载 hosts2...'
curl -o ./origin-files/hosts2 --connect-timeout 60 \
 -s \
 https://raw.githubusercontent.com/vokins/yhosts/master/hosts

# shellcheck disable=SC2181
if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

echo '开始下载 hosts3...'
curl -o ./origin-files/hosts3 --connect-timeout 60 \
 -s \
 https://raw.githubusercontent.com/jdlingyu/ad-wars/master/hosts

# shellcheck disable=SC2181
if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

echo '开始下载 strict-hosts1...'
curl -o ./origin-files/strict-hosts1 --connect-timeout 60 \
 -s \
 https://raw.githubusercontent.com/hoshsadiq/adblock-nocoin-list/master/hosts.txt

# shellcheck disable=SC2181
if [ $? -ne 0 ];then
	echo '下载失败，请重试'
	exit 1
fi

cd origin-files

cat hosts* | grep -v -E "^((#.*)|(\s*))$" \
 | grep -v -E "^[0-9\.:]+\s+(ip6\-)?(localhost|loopback)$" \
 | sed s/0.0.0.0/127.0.0.1/g | sed s/::/127.0.0.1/g | sort \
 | uniq >base-src-hosts.txt

cat strict-hosts* | grep -v -E "^((#.*)|(\s*))$" \
 | grep -v -E "^[0-9\.:]+\s+(ip6\-)?(localhost|loopback)$" \
 | sed s/0.0.0.0/127.0.0.1/g | sed s/::/127.0.0.1/g | sort \
 | uniq >base-src-strict-hosts.txt


cat easylist*.txt | grep -E "^\|\|[^\*\^]+?\^" | sort | uniq >base-src-easylist.txt
cat easylist*.txt | grep -E "^\|\|?[^\^=\/:]+?\*[^\^=\/:]+?\^" | sort | uniq >wildcard-src-easylist.txt
cat easylist*.txt | grep -E "^@@\|\|?[^\^=\/:]+?\^[^\/=\*]+?$" | sort | uniq >whiterule-src-easylist.txt

cd ../

php make-addr.php
php ./tools/easylist-extend.php anti-ad-easylist.txt
