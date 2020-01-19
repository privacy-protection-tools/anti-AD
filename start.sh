#!/bin/bash

source /etc/profile

cd $(cd "$(dirname "$0")";pwd)
git pull

shopt -s expand_aliases
alias php='/usr/local/php/bin/php'
export PHP_RET=$(. ./start-ci.sh | tail -1)

git add -A adblock-for-dnsmasq.conf origin-files/*
git commit -am "auto commit. $PHP_RET"
git push --force
