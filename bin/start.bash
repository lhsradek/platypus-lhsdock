#!/usr/bin/bash

echo == lhsdock start ==

IMAGE=lhsdock
cp /root/platypus-$IMAGE/dockerfiles/Dockerfile /var/lib/docker/volumes/$IMAGE/_data/Dockerfile.txt
cp /root/platypus-$IMAGE/context/root/bin/READme.txt /var/lib/docker/volumes/$IMAGE/_data/
docker start platypus-$IMAGE
bin/ls.bash | grep $IMAGE
echo Run terminal with:
echo /root/platypus-$IMAGE/bin/exec.bash
