#!/usr/bin/bash

echo == lhsdock start ==

cp /root/platypus-lhsdock/dockerfiles/Dockerfile /var/lib/docker/volumes/lhsdock/_data/Dockerfile.txt
cp /root/platypus-lhsdock/context/root/bin/READme.txt /var/lib/docker/volumes/lhsdock/_data/
cp /root/platypus-lhsdock/context/root/bin/platypus.pl.html /var/lib/docker/volumes/lhsdock/_data/
docker start platypus-lhsdock
