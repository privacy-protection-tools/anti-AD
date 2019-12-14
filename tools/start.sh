#!/bin/bash

source /etc/profile
cd $(cd "$(dirname "$0")";pwd)

cd ../origin-files

rm -f split-tmp-list_*

split -l 5000 ../adblock-for-dnsmasq.conf split-tmp-list_

cd ../tools

# shellcheck disable=SC2045
for f in $(ls ../origin-files/split-tmp-list_*)
do
  nohup php valid-addr.php $(basename "$f") >> ./std-$(basename "$f").out &
done