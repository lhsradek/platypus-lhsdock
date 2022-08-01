#!/usr/bin/bash

echo == lhsdock create ==

docker volume create lhsdock --driver local
cp /root/platypus-lhsdock/dockerfiles/Dockerfile /var/lib/docker/volumes/lhsdock/_data/Dockerfile.txt
cp /root/platypus-lhsdock/context/root/bin/READme.txt /var/lib/docker/volumes/lhsdock/_data/
FILE=lhsdock:v3
if [ ! -f $FILE ]; then
   echo "File $FILE does not exist."
   docker build --compress --no-cache -t lhsdock:v3 -f dockerfiles/Dockerfile context
   docker save -o lhsdock:v3 lhsdock
fi
docker load -i lhsdock:v3
docker run -it --name platypus-lhsdock --volume /root/platypus-lhsdock/lhsvol:/root/bin/lhsvol lhsdock:v3 sh
docker start platypus-lhsdock
# docker exec -it platypus-lhsdock sh
bin/ls.bash | grep lhsdock
echo Run terminal with:
echo /root/platypus-lhsdock/bin/exec.bash
