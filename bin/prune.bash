#!/usr/bin/bash

echo == docker prune ==

docker network prune -f
docker container prune -f
docker image prune -f
docker volume prune -f
