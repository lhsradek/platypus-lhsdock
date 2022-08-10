#!/bin/sh

# lhs
ssh-keygen -A
exec /usr/sbin/sshd -D -e "$@"
