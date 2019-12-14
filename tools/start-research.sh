#!/bin/bash
#每周运行一次

source /etc/profile
cd $(cd "$(dirname "$0")";pwd)

nohup php research-addr.php >> ./std-research.out &