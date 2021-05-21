#!/bin/bash

source /etc/profile

cd $(cd "$(dirname "$0")";pwd)

php make-addr.php
echo
cp ../anti-ad-easylist.txt ../anti-ad-adguard.txt
php ./tools/adguard-extend.php ../anti-ad-adguard.txt
echo 
php ./tools/easylist-extend.php ../anti-ad-easylist.txt
