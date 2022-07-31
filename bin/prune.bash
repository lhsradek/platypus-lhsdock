#!/usr/bin/bash

echo == docker prune ==

docker container prune ; docker image prune ; docker volume prune
# docker image rm lhsdock:v3
