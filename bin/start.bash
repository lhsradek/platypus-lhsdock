#!/usr/bin/bash

echo == lhsdock start ==

cp -u readme.md ~/lhsdock/readme.txt
cp -u context/root/bin/READme.txt ~/lhsdock/
cp -u context/html/* ~/lhsdock/
cp -u dockerfiles/Dockerfile ~/lhsdock/Dockerfile.txt
docker start platypus-lhsdock
bin/ls.bash | grep lhsdock
echo Run terminal with:
echo "bin/exec.bash"
