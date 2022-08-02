#!/usr/bin/bash

echo == lhsdock create ==

IMAGE=lhsdock
docker volume create $IMAGE --driver local
cp /root/platypus-$IMAGE/dockerfiles/Dockerfile /var/lib/docker/volumes/$IMAGE/_data/Dockerfile.txt
cp /root/platypus-$IMAGE/context/root/bin/READme.txt /var/lib/docker/volumes/$IMAGE/_data/
FILE=$IMAGE:v3
if [ ! -f $FILE ]; then
   echo "File $FILE does not exist."
   docker build --compress --no-cache -t $FILE -f dockerfiles/Dockerfile context
   docker save -o $FILE $IMAGE
fi
docker load -i $FILE
docker run -it --name platypus-$IMAGE --volume /root/platypus-$IMAGE/lhsvol:/root/bin/lhsvol $FILE sh
docker start platypus-$IMAGE
# docker exec -it platypus-$IMAGE sh
bin/ls.bash | grep $IMAGE
echo Run terminal with:
echo /root/platypus-$IMAGE/bin/exec.bash
