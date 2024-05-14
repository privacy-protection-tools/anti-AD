#!/bin/bash

source /etc/profile

cd $(cd "$(dirname "$0")";pwd)

easylist=(
  "https://easylist-downloads.adblockplus.org/easylist.txt"
  "https://filters.adtidy.org/windows/filters/224_optimized.txt"
  "https://raw.githubusercontent.com/cjx82630/cjxlist/master/cjx-annoyance.txt"
  "https://easylist.to/easylist/fanboy-annoyance.txt"
  "https://easylist.to/easylist/easyprivacy.txt"
  "https://raw.githubusercontent.com/banbendalao/ADgk/master/ADgk.txt"
  "https://raw.githubusercontent.com/TG-Twilight/AWAvenue-Ads-Rule/main/AWAvenue-Ads-Rule.txt"
)

hosts=(
  "https://malware-filter.gitlab.io/malware-filter/urlhaus-filter-hosts-online.txt"
  "https://raw.githubusercontent.com/jdlingyu/ad-wars/master/hosts"
  "https://raw.githubusercontent.com/crazy-max/WindowsSpyBlocker/master/data/hosts/spy.txt"
)

strict_hosts=(
  "https://raw.githubusercontent.com/hoshsadiq/adblock-nocoin-list/master/hosts.txt"
  "https://zerodot1.gitlab.io/CoinBlockerLists/hosts_browser"
)

dead_hosts=(
  "https://raw.githubusercontent.com/notracking/hosts-blocklists-scripts/master/domains.dead.txt"
  "https://raw.githubusercontent.com/notracking/hosts-blocklists-scripts/master/hostnames.dead.txt"
)

rm -f ./origin-files/easylist*
rm -f ./origin-files/hosts*
rm -f ./origin-files/strict-hosts*
rm -f ./origin-files/dead-hosts*

cp ./origin-files/yhosts-latest.txt ./origin-files/hosts1000.txt
cp ./origin-files/some-else.txt ./origin-files/dead-hosts444.txt
cp ./origin-files/anti-ad-origin-block.txt ./origin-files/hosts007.txt

curl --connect-timeout 60 -s -o - https://raw.githubusercontent.com/ACL4SSR/ACL4SSR/master/Clash/BanProgramAD.list \
 | grep -F 'DOMAIN-SUFFIX,' | sed 's/DOMAIN-SUFFIX,/127.0.0.1 /g' >./origin-files/hosts999.txt
curl --connect-timeout 60 -s -o - https://raw.githubusercontent.com/ACL4SSR/ACL4SSR/master/Clash/BanAD.list \
 | grep -F 'DOMAIN-SUFFIX,' | sed 's/DOMAIN-SUFFIX,/127.0.0.1 /g' >./origin-files/hosts998.txt

wget -qO /tmp/geodata.tar.gz 'https://github.com/v2fly/domain-list-community/archive/master.tar.gz'
# shellcheck disable=SC2181
if [ $? -ne 0 ]; then
  echo '下载失败，请重试'
  exit 1
fi
tar xzf /tmp/geodata.tar.gz -C /tmp
cat /tmp/domain-list-community-master/data/*-ads | grep -E '^(full:)?([^#:]+)( @ads)?$' \
| sed -e 's/^full://g' -e 's/ @ads$//g' -e 's/^/127.0.0.1 /g' >./origin-files/hosts997.txt
rm -rf /tmp/geodata.tar.gz /tmp/domain-list-community-master

for i in "${!easylist[@]}"
do
  echo "开始下载 easylist${i}..."
  curl -o "./origin-files/easylist${i}.txt" --connect-timeout 60 -s "${easylist[$i]}"
  # shellcheck disable=SC2181
  if [ $? -ne 0 ];then
    echo '下载失败，请重试'
    exit 1
  fi
done

for i in "${!hosts[@]}"
do
  echo "开始下载 hosts${i}..."
  curl -o "./origin-files/hosts${i}.txt" --connect-timeout 60 -s "${hosts[$i]}"
  # shellcheck disable=SC2181
  if [ $? -ne 0 ];then
    echo '下载失败，请重试'
    exit 1
  fi
done

for i in "${!strict_hosts[@]}"
do
  echo "开始下载 strict-hosts${i}..."
  curl -o "./origin-files/strict-hosts${i}.txt" --connect-timeout 60 -s "${strict_hosts[$i]}"
  # shellcheck disable=SC2181
  if [ $? -ne 0 ];then
    echo '下载失败，请重试'
    exit 1
  fi
done

for i in "${!dead_hosts[@]}"
do
  echo "开始下载 dead-hosts${i}..."
  curl -o "./origin-files/dead-hosts${i}.txt" --connect-timeout 60 -s "${dead_hosts[$i]}"
  # shellcheck disable=SC2181
  if [ $? -ne 0 ];then
    echo '下载失败，请重试'
    exit 1
  fi
done


cd origin-files

cat hosts*.txt | grep -v -E "^((#.*)|(\s*))$" \
 | grep -v -E "^[0-9\.:]+\s+(ip6\-)?(localhost|loopback)$" \
 | sed s/0.0.0.0/127.0.0.1/g | sed s/::/127.0.0.1/g | sort \
 | uniq >base-src-hosts.txt

cat strict-hosts*.txt | grep -v -E "^((#.*)|(\s*))$" \
 | grep -v -E "^[0-9\.:]+\s+(ip6\-)?(localhost|loopback)$" \
 | sed s/0.0.0.0/127.0.0.1/g | sed s/::/127.0.0.1/g | sort \
 | uniq >base-src-strict-hosts.txt

cat dead-hosts*.txt | grep -v -E "^(#|\!)" \
 | sort \
 | uniq >base-dead-hosts.txt


cat easylist*.txt | grep -E "^\|\|[-0-9a-zA-Z\.:]+\^" | sort | uniq >base-src-easylist.txt
cat easylist*.txt | grep -E "^\|\|?([^\^=\/:]+)?\*([^\^=\/:]+)?\^" | sort | uniq >wildcard-src-easylist.txt
cat easylist*.txt | grep -E "^@@\|\|?[^\^=\/:]+?\^([^\/=\*]+)?$" | sort | uniq >whiterule-src-easylist.txt

cd ../
