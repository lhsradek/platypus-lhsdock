#!/usr/bin/bash

echo == docker prune ==

docker container prune -f
docker image prune -f
docker volume prune -f
