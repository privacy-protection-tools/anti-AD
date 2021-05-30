#!/bin/bash

source /etc/profile

cd $(cd "$(dirname "$0")";pwd)

php make-addr.php
echo
echo "!Title: anti-AD for AdGuard" > ../anti-ad-adguard.txt
echo "!Version: 20210530181117" >> ../anti-ad-adguard.txt
echo "!Homepage: https://anti-ad.net/" >> ../anti-ad-adguard.txt
echo "!!!note! If you are using \"AdGuard Home\", please load https://anti-ad.net/easylist.txt" >> ../anti-ad-adguard.txt
echo "!Total lines: 00000" >> ../anti-ad-adguard.txt
grep -vE '^!' ../anti-ad-easylist.txt >> ../anti-ad-adguard.txt
php ./tools/adguard-extend.php ../anti-ad-adguard.txt
php ./tools/easylist-extend.php ../anti-ad-easylist.txt
