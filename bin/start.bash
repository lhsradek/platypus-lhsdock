#!/usr/bin/bash

echo == lhsdock start ==

mkdir -p ~/lhsdock/certs
mkdir -p ~/lhsdock/content
mkdir -p ~/lhsdock/content/projekt1
mkdir -p ~/lhsdock/content/projekt1/lhsdock
cp -ur context/html/* ~/lhsdock/content
cp -u readme.md ~/lhsdock/content/projekt1/lhsdock/readme.txt
cp -u context/root/bin/READme.html ~/lhsdock/content/projekt1/lhsdock
cp -u dockerfiles/Dockerfile ~/lhsdock/content/projekt1/lhsdock/Dockerfile.txt
cp -u lhsdock:v3.img ~/lhsdock/content/projekt1/lhsdock/
chmod a+r ~/lhsdock/content/projekt1/lhsdock/lhsdock:v3.img
chmod a-w ~/lhsdock/content
docker start platypus-lhsdock
bin/ls.bash | grep lhsdock
echo Run terminal with:
echo "./bin/exec.bash"
