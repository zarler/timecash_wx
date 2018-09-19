#!/bin/bash
#短信队列:高频,每5秒执行一次

name="wechat";
log_dir="/alidata1/www/timecash22/wx/shell/production/logs/$name";
minion="/alidata1/www/timecash22/wx/modules/minion/minion";

while [ 1 ]
do
php "$minion" --task=Wechat_TokenFlush >> "$log_dir"/token_flash_"$(date +'%Y-%m-%d')".log
sleep 300
done
