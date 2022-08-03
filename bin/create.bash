#!/usr/bin/bash

echo == lhsdock create ==

docker volume create lhsdock --driver local
docker container ls -a | grep platypus-lhsdock
mkdir -p ./context/lhsvol
mkdir -p ./context/lhsvol/certs
mkdir -p ./lhsvol
mkdir -p ./lhsvol/certs
cp -u readme.md ~/lhsdock/readme.txt
cp -u context/root/bin/READme.html ~/lhsdock/
cp -u context/html/* ~/lhsdock/
cp -u dockerfiles/Dockerfile ~/lhsdock/Dockerfile.txt
cp -u lhsdock:v3.img  ~/lhsdock/
ISIMG=1
if [ -f lhsdock:v3.img ]; then
  docker load -i lhsdock:v3.img
  echo "An image is loaded from lhsdock:v3.img"
else
  ISIMG=0   
  echo "File lhsdock:v3.img not exists."
  docker build --compress --no-cache -t lhsdock:v3 -f ./dockerfiles/Dockerfile context
  docker save -o lhsdock:v3.img lhsdock
fi
echo "is img:$ISIMG"
docker images lhsdock:v3
docker run -it --name platypus-lhsdock -v lhsdock:/root/bin/lhsdock:ro lhsdock:v3 sh
# docker run -it --name platypus-lhsdock --volume lhsdock:/root/bin/lhsdock --network platypus-local-dev-network lhsdock:v3 sh
docker container ls -a | grep platypus-lhsdock
if [ $ISIMG -eq 0 ]; then
  docker container prune -f
  docker image rm lhsdock:v3
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
