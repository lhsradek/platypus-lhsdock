#!/usr/bin/bash

echo == lhsdock create ==

docker volume create lhsdock --driver local
docker container ls -a | grep platypus-lhsdock
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
ISIMG=1
if [ -f lhsdock:v3.img ]; then
  # docker load -i lhsdock:v3.img
  # docker push lhsradek/lhsdock:v3
  docker pull lhsradek/lhsdock:v3
  echo "An image is loaded from lhsdock:v3.img"
else
  ISIMG=0   
  echo "File lhsdock:v3.img not exists."
  docker build --compress --no-cache -t lhsradek/lhsdock:v3 -f ./dockerfiles/Dockerfile context
  # docker tag lhsradek/lhsdock:v3
  docker push lhsradek/lhsdock:v3
  docker save -o lhsdock:v3.img lhsradek/lhsdock
fi
echo "is img:$ISIMG"
docker images lhsradek/lhsdock:v3
docker run -it --name platypus-lhsdock -v lhsdock:/root/bin/volume/lhsdock:rw -v mysql-01:/root/bin/volume/mysql-01:ro -v postgres-01:/root/bin/volume/postgres-01:ro -v redis-01:/root/bin/volume/redis-01:ro lhsradek/lhsdock:v3 sh
# docker run -it --name platypus-lhsdock --volume lhsdock:/root/bin/lhsdock --network platypus-local-dev-network lhsdock:v3 sh
docker container ls -a | grep platypus-lhsdock
if [ $ISIMG -eq 0 ]; then
  docker container prune -f
  # docker image rm lhsradek/lhsdock:v3
  echo "run bin/create.bash"
  exit
else
  docker start platypus-lhsdock
  # docker container prune -f
fi
bin/ls.bash | grep lhsdock
echo Run terminal with:
echo "bin/exec.bash"
# docker exec -it platypus-lhsdock bash
# docker stop platypus-lhsdock
