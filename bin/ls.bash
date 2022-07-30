#!/usr/bin/bash

echo == docker ls ==

docker service ls ; docker network ls ; docker image ls -a ; docker container ls -a ; docker volume ls
