#!/usr/bin/bash

echo == lhsdock create ==

docker volume create lhsdock --driver local
cp /root/platypus-lhsdock/dockerfiles/Dockerfile /var/lib/docker/volumes/lhsdock/_data/Dockerfile.txt
cp /root/platypus-lhsdock/context/root/bin/READme.txt /var/lib/docker/volumes/lhsdock/_data/
docker build --compress --no-cache -t lhsdock:v3 -f dockerfiles/Dockerfile context
docker run -it --name platypus-lhsdock --mount source=lhsdock,destination=/usr/share/nginx/html,readonly,target=/root/bin/lhsdock --volume /root/platypus-lhsdock/lhsvol:/root/bin/lhsvol lhsdock:v3 sh
