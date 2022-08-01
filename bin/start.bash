#!/usr/bin/bash

echo == lhsdock start ==

cp /root/platypus-lhsdock/dockerfiles/Dockerfile /var/lib/docker/volumes/lhsdock/_data/Dockerfile.txt
cp /root/platypus-lhsdock/context/root/bin/READme.txt /var/lib/docker/volumes/lhsdock/_data/
docker start platypus-lhsdock
bin/ls.bash | grep lhsdock
echo Run terminal with:
echo /root/platypus-lhsdock/bin/exec.bash
