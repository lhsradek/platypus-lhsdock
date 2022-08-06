#!/bin/sh

echo == alpine ==

apk add tzdata
cp /usr/share/zoneinfo/Europe/Prague /etc/localtime
echo "Europe/Prague" >  /etc/timezone
date
apk del tzdata
