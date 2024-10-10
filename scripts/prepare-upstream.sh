#!/bin/bash

source /etc/profile
set -o errexit

cd "$(cd "$(dirname "$0")"; pwd)"
[ -e './raw-sources' ] && rm -rf ./raw-sources
mkdir ./raw-sources
rm -rf ./origin-files/upstream-*.txt

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
ACL4SSR_BanAD_URL='https://raw.githubusercontent.com/ACL4SSR/ACL4SSR/master/Clash/BanAD.list'
ACL4SSR_BanProgramAD_URL='https://raw.githubusercontent.com/ACL4SSR/ACL4SSR/master/Clash/BanProgramAD.list'
V2Fly_DLC_URL='https://github.com/v2fly/domain-list-community/archive/master.tar.gz'

for i in "${!easylist[@]}"; do
	echo "Start to download easylist${i}..."
	tMark="$(date +'%Y-%m-%d %H:%M:%S %Z')"
	curl -o "./raw-sources/easylist-${i}.txt" --connect-timeout 60 -s "${easylist[$i]}"
	echo -e "! easylist-${i} $tMark\n! ${easylist[$i]}" >>./origin-files/upstream-easylist.txt
	tr -d '\r' <"./raw-sources/easylist-${i}.txt" |
		grep -E "(^\|\|[^\*\^]+?\^)|(^\|\|?([^\^=\/:]+)?\*([^\^=\/:]+)?\^)|(^@@\|\|?[^\^=\/:]+?\^([^\/=\*]+)?$)" |
		sed -e "/\^\$elemhide$/d" -e "/\^\$generichide$/d" | sort -u >>./origin-files/upstream-easylist.txt
done

Hosts-Processer() {
	grep -v -E "^((#.*)|(\s*))$" | grep -v -E "^[0-9\.:]+\s+(ip6\-)?(broadcasthost|localhost|loopback)$" |
		sed -e 's/0.0.0.0/127.0.0.1/g' -e 's/::/127.0.0.1/g' | sort -u
}

for i in "${!hosts[@]}"; do
	echo "Start to download hosts${i}..."
	tMark="$(date +'%Y-%m-%d %H:%M:%S %Z')"
	curl -o "./raw-sources/hosts-${i}.txt" --connect-timeout 60 -s "${hosts[$i]}"
	echo -e "# hosts-${i} $tMark\n# ${hosts[$i]}" >>./origin-files/upstream-hosts.txt
	tr -d '\r' <"./raw-sources/hosts-${i}.txt" | Hosts-Processer >>./origin-files/upstream-hosts.txt
done

echo "Start to download $ACL4SSR_BanAD_URL"
tMark="$(date +'%Y-%m-%d %H:%M:%S %Z')"
curl --connect-timeout 60 -s -o - "$ACL4SSR_BanAD_URL" | tr -d '\r' |
	grep -E '^DOMAIN-SUFFIX,' | sed -r 's/^DOMAIN-SUFFIX,(\S+)$/127.0.0.1 \1/' >./raw-sources/hosts-ACL4SSR-BanAD.txt
echo -e "# hosts-ACL4SSR-BanAD $tMark\n# $ACL4SSR_BanAD_URL" >>./origin-files/upstream-hosts.txt
sort -u ./raw-sources/hosts-ACL4SSR-BanAD.txt >>./origin-files/upstream-hosts.txt

echo "Start to download $ACL4SSR_BanProgramAD_URL"
tMark="$(date +'%Y-%m-%d %H:%M:%S %Z')"
curl --connect-timeout 60 -s -o - "$ACL4SSR_BanProgramAD_URL" | tr -d '\r' |
	grep -E '^DOMAIN-SUFFIX,' | sed -r 's/^DOMAIN-SUFFIX,(\S+)$/127.0.0.1 \1/' >./raw-sources/hosts-ACL4SSR-BanProgramAD.txt
echo -e "# hosts-ACL4SSR-BanProgramAD $tMark\n# $ACL4SSR_BanProgramAD_URL" >>./origin-files/upstream-hosts.txt
sort -u ./raw-sources/hosts-ACL4SSR-BanProgramAD.txt >>./origin-files/upstream-hosts.txt

echo "Start to download $V2Fly_DLC_URL"
tMark="$(date +'%Y-%m-%d %H:%M:%S %Z')"
wget -qO ./raw-sources/geodata.tar.gz "$V2Fly_DLC_URL"
tar -xzf ./raw-sources/geodata.tar.gz -C ./raw-sources
cat ./raw-sources/domain-list-community-master/data/*-ads | tr -d '\r' | grep -E '^(full:)?([^#:@]+)( @ads)?$' |
	sed -r 's/^(full:)?([^@]+)( @ads)?$/127.0.0.1 \2/' >./raw-sources/hosts-v2fly-dlcads.txt
rm -rf ./raw-sources/geodata.tar.gz ./raw-sources/domain-list-community-master
echo -e "# hosts-v2fly-dlcads $tMark\n# $V2Fly_DLC_URL" >>./origin-files/upstream-hosts.txt
sort -u ./raw-sources/hosts-v2fly-dlcads.txt >>./origin-files/upstream-hosts.txt

tr -d '\r' <./origin-files/anti-ad-origin-block.txt >./raw-sources/hosts-origin-block.txt
echo -e "# hosts-origin-block $tMark\n# ./scripts/origin-files/anti-ad-origin-block.txt @adlist-maker" >>./origin-files/upstream-hosts.txt
Hosts-Processer <./raw-sources/hosts-origin-block.txt >>./origin-files/upstream-hosts.txt

tr -d '\r' <./origin-files/yhosts-latest.txt >./raw-sources/hosts-yhosts.txt
echo -e "# hosts-yhosts-latest $tMark\n# ./scripts/origin-files/yhosts-latest.txt @adlist-maker" >>./origin-files/upstream-hosts.txt
Hosts-Processer <./raw-sources/hosts-yhosts.txt >>./origin-files/upstream-hosts.txt

for i in "${!strict_hosts[@]}"; do
	echo "Start to download strict-hosts${i}..."
	tMark="$(date +'%Y-%m-%d %H:%M:%S %Z')"
	curl -o "./raw-sources/strict-hosts-${i}.txt" --connect-timeout 60 -s "${strict_hosts[$i]}"
	echo -e "# strict_hosts-${i} $tMark\n# ${strict_hosts[$i]}" >>./origin-files/upstream-strict-hosts.txt
	tr -d '\r' <"./raw-sources/strict-hosts-${i}.txt" | Hosts-Processer >>./origin-files/upstream-strict-hosts.txt
done

for i in "${!dead_hosts[@]}"; do
	echo "Start to download dead-hosts-${i}..."
	tMark="$(date +'%Y-%m-%d %H:%M:%S %Z')"
	curl -o "./raw-sources/dead-hosts-${i}.txt" --connect-timeout 60 -s "${dead_hosts[$i]}"
	echo -e "# dead_hosts-${i} $tMark\n# ${dead_hosts[$i]}" >>./origin-files/upstream-dead-hosts.txt
	tr -d '\r' <"./raw-sources/dead-hosts-${i}.txt" | grep -v -E "^(#|\!)" | sort -u >>./origin-files/upstream-dead-hosts.txt
done

tr -d '\r' <./origin-files/some-else.txt >./raw-sources/dead-hosts-some-else.txt
echo -e "# dead_hosts-some-else $tMark\n# ./scripts/origin-files/some-else.txt @adlist-maker" >>./origin-files/upstream-dead-hosts.txt
grep -v -E "^(#|\!)" ./raw-sources/dead-hosts-some-else.txt | sort -u >>./origin-files/upstream-dead-hosts.txt

# Comment next line to track raw sources lists
rm -rf ./raw-sources/

sed '/^!/d' ./origin-files/upstream-easylist.txt | grep -E "^\|\|[^\*\^]+?\^" | sort -u >./origin-files/base-src-easylist.txt
sed '/^!/d' ./origin-files/upstream-easylist.txt | grep -E "^\|\|?([^\^=\/:]+)?\*([^\^=\/:]+)?\^" | sort -u >./origin-files/wildcard-src-easylist.txt
sed '/^!/d' ./origin-files/upstream-easylist.txt | grep -E "^@@\|\|?[^\^=\/:]+?\^([^\/=\*]+)?$" | sort -u >./origin-files/whiterule-src-easylist.txt
sed '/^#/d' ./origin-files/upstream-hosts.txt | sort -u >./origin-files/base-src-hosts.txt
sed '/^#/d' ./origin-files/upstream-strict-hosts.txt | sort -u >./origin-files/base-src-strict-hosts.txt
sed '/^#/d' ./origin-files/upstream-dead-hosts.txt | sort -u >./origin-files/base-dead-hosts.txt

cd ../
