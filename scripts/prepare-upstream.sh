#!/bin/bash

source /etc/profile
set -o errexit

cd "$(cd "$(dirname "$0")"; pwd)"
[ -e './raw-sources' ] && rm -r ./raw-sources
mkdir ./raw-sources

# 1. get source lists
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

curl --connect-timeout 60 -s -o - 'https://raw.githubusercontent.com/ACL4SSR/ACL4SSR/master/Clash/BanProgramAD.list' |
	grep -E '^DOMAIN-SUFFIX,' | sed -r 's/^DOMAIN-SUFFIX,(\S+)$/127.0.0.1 \1/' >./raw-sources/hosts-ACL4SSR-BanProgramAD.txt
curl --connect-timeout 60 -s -o - 'https://raw.githubusercontent.com/ACL4SSR/ACL4SSR/master/Clash/BanAD.list' |
	grep -E '^DOMAIN-SUFFIX,' | sed -r 's/^DOMAIN-SUFFIX,(\S+)$/127.0.0.1 \1/' >./raw-sources/hosts-ACL4SSR-BanAD.txt

wget -qO ./raw-sources/geodata.tar.gz 'https://github.com/v2fly/domain-list-community/archive/master.tar.gz'
tar -xzf ./raw-sources/geodata.tar.gz -C ./raw-sources
cat ./raw-sources/domain-list-community-master/data/*-ads | grep -E '^(full:)?([^#:]+)( @ads)?$' |
	sed -r 's/^(full:)?([^@]+)( @ads)?$/127.0.0.1 \2/' >./raw-sources/hosts-v2fly-dlcads.txt
rm -rf ./raw-sources/geodata.tar.gz ./raw-sources/domain-list-community-master

cp ./origin-files/anti-ad-origin-block.txt ./raw-sources/hosts-origin-block.txt
cp ./origin-files/yhosts-latest.txt ./raw-sources/hosts-yhosts.txt
cp ./origin-files/some-else.txt ./raw-sources/dead-hosts-some-else.txt

for i in "${!easylist[@]}"; do
	echo "Start to download easylist${i}..."
	curl -o "./raw-sources/easylist-${i}.txt" --connect-timeout 60 -s "${easylist[$i]}"
done

for i in "${!hosts[@]}"; do
	echo "Start to download hosts${i}..."
	curl -o "./raw-sources/hosts-${i}.txt" --connect-timeout 60 -s "${hosts[$i]}"
done

for i in "${!strict_hosts[@]}"; do
	echo "Start to download strict-hosts${i}..."
	curl -o "./raw-sources/strict-hosts-${i}.txt" --connect-timeout 60 -s "${strict_hosts[$i]}"
done

for i in "${!dead_hosts[@]}"; do
	echo "Start to download dead-hosts-${i}..."
	curl -o "./raw-sources/dead-hosts-${i}.txt" --connect-timeout 60 -s "${dead_hosts[$i]}"
done

# 2. mix source lists
# - help to find out where a specific rule comes from
# - handle '\r\n'
upstreamHead="# Generated on $(date)"
echo "$upstreamHead" >./origin-files/upstream-hosts.txt
echo "$upstreamHead" >./origin-files/upstream-strict-hosts.txt
echo "$upstreamHead" >./origin-files/upstream-dead-hosts.txt
echo "$upstreamHead" >./origin-files/upstream-easylist.txt
echo "$upstreamHead" >./origin-files/upstream-wildcard-src-easylist.txt
echo "$upstreamHead" >./origin-files/upstream-whiterule-src-easylist.txt

for listfile in ./raw-sources/hosts*; do
	echo "# $listfile" >>./origin-files/upstream-hosts.txt
	tr -d '\r' <"$listfile" | grep -v -E "^((#.*)|(\s*))$" | grep -v -E "^[0-9\.:]+\s+(ip6\-)?(localhost|loopback)$" |
		sed -e 's/0.0.0.0/127.0.0.1/g' -e 's/::/127.0.0.1/g' | sort -u >>./origin-files/upstream-hosts.txt
done

for listfile in ./raw-sources/strict-hosts*; do
	echo "# $listfile" >>./origin-files/upstream-strict-hosts.txt
	tr -d '\r' <"$listfile" | grep -v -E "^((#.*)|(\s*))$" | grep -v -E "^[0-9\.:]+\s+(ip6\-)?(localhost|loopback)$" |
		sed -e 's/0.0.0.0/127.0.0.1/g' -e 's/::/127.0.0.1/g' | sort -u >>./origin-files/upstream-strict-hosts.txt
done

for listfile in ./raw-sources/dead-hosts*; do
	echo "# $listfile" >>./origin-files/upstream-dead-hosts.txt
	tr -d '\r' <"$listfile" | grep -v -E "^(#|\!)" | sort -u >>./origin-files/upstream-dead-hosts.txt
done

for listfile in ./raw-sources/easylist*; do
	echo "# $listfile" >>./origin-files/upstream-easylist.txt
	tr -d '\r' <"$listfile" | grep -E "^\|\|[^\*\^]+?\^" | sort -u >>./origin-files/upstream-easylist.txt

	echo "# $listfile" >>./origin-files/upstream-wildcard-src-easylist.txt
	tr -d '\r' <"$listfile" | grep -E "^\|\|?([^\^=\/:]+)?\*([^\^=\/:]+)?\^" | sort -u >>./origin-files/upstream-wildcard-src-easylist.txt

	echo "# $listfile" >>./origin-files/upstream-whiterule-src-easylist.txt
	tr -d '\r' <"$listfile" | grep -E "^@@\|\|?[^\^=\/:]+?\^([^\/=\*]+)?$" | sort -u >>./origin-files/upstream-whiterule-src-easylist.txt
done
rm -r ./raw-sources

# 3. unique rules for next process
sed '/^#/d' ./origin-files/upstream-hosts.txt | sort -u >./origin-files/base-src-hosts.txt
sed '/^#/d' ./origin-files/upstream-strict-hosts.txt | sort -u >./origin-files/base-src-strict-hosts.txt
sed '/^#/d' ./origin-files/upstream-dead-hosts.txt | sort -u >./origin-files/base-dead-hosts.txt
sed '/^#/d' ./origin-files/upstream-easylist.txt | sort -u >./origin-files/base-src-easylist.txt
sed '/^#/d' ./origin-files/upstream-wildcard-src-easylist.txt | sort -u >./origin-files/wildcard-src-easylist.txt
sed '/^#/d' ./origin-files/upstream-whiterule-src-easylist.txt | sort -u >./origin-files/whiterule-src-easylist.txt

cd ../
