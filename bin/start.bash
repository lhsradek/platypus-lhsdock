#!/usr/bin/bash

echo == lhsdock start ==

docker start platypus-lhsdock
bin/ls.bash | grep lhsdock
mkdir -p ~/volume/lhsdock/certs
mkdir -p ~/volume/lhsdock/content
mkdir -p ~/volume/lhsdock/content/projekt1
mkdir -p ~/volume/lhsdock/content/projekt1/lhsdock
cp -ur context/html/* ~/volume/lhsdock/content
cp -u readme.md ~/volume/lhsdock/content/projekt1/lhsdock/readme.txt
cp -u context/root/bin/READme.html ~/volume/lhsdock/content/projekt1/lhsdock
cp -u dockerfiles/Dockerfile ~/volume/lhsdock/content/projekt1/lhsdock/Dockerfile.txt
cp -u lhsdock:v3.img ~/volume/lhsdock/content/projekt1/lhsdock/
chmod a+r ~/volume/lhsdock/content/projekt1/lhsdock/lhsdock:v3.img
chmod a-w ~/volume/lhsdock/content
echo Run terminal with:
echo "./bin/exec.bash"
