#!/usr/bin/bash

echo == lhsdock create ==

docker volume create lhsdock --driver local
docker container ls -a | grep platypus-lhsdock
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
ISIMG=1
if [ -f lhsdock:v3.img ]; then
  # docker load -i lhsdock:v3.img
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
docker run -it --name platypus-lhsdock -v lhsdock:/root/bin/lhsdock:rw lhsradek/lhsdock:v3 sh
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
