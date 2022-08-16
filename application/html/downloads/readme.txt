### platypus-lhsdock

https://github.com/lhsradek/platypus-lhsdock

#### Setup

1) create .env file ```cp .env.dist .env```
2) run lhsdock ```bin/start```
3) exec lhsdock ```bin/exec```

4) To run use:

```/ # perl /root/bin/platypus.pl```

``` # ls /root/bin```

```READme.txt   add.sh       lhsdock      lhsvol       platypus.pl```

## Setup

| REPOSITORY       |  TAG       | SIZE             | FROM
| ---------------- | ---------- | ---------------- |-------------
| lhsradek/lhsdock | v3         | 25 .. 63.4MB ;-) | nginx:alpine
| php              | fpm-alpine | 73.4MB           |
| nginx            | alpine     | 23.5MB           |

| IMAGES              | PORTS           | NAMES
| ------------------- | --------------- | -----------
| lhsradek/lhsdock:v3 | 80/tcp, 443/tcp | lhsdock
| php:fpm-alpine      | 9000/tcp        | lhsdock-php


| NETWORK                    | DRIVER | SCOPE
| -------------------------- | ------ | -----
| platypus-local-dev-network | bridge | local
| nginx.local                | bridge | local


HOSTNAME=docker.nginx.local

| State       | Local Address:Port | Peer Address:Port | Process 
| ----------- | ------------------ | ----------------- | ----------------------------
| LISTEN      |      0.0.0.0:80    | 0.0.0.0:*         | users:(("nginx",pid=1,fd=8))       
| LISTEN      |   127.0.0.11:36947 | 0.0.0.0:*                                              

HOSTNAME='lhsdock-php.nginx.local'
| State       | Local Address:Port | Peer Address:Port | Process 
| ----------- | ------------------ | ----------------- | -------------------------------
| LISTEN      |   127.0.0.11:45811 | 0.0.0.0:*         |                         
| LISTEN      |            *:9000  | \*:\*               |  users:(("php-fpm",pid=1,fd=7))


| TCP Connections (Source Host:Port)                 |      Packets    |    Bytes  |  Flag   |  Iface        
| -------------------------------------------------- | --------------- | --------- | ------- | ------
|┌platypus-box_traefik_1.platypus-local-dev-n:36236  |    =        8   |     2025     --A-   |  eth1
|└docker.nginx.local:80                              |    =       24   |    29881  |  CLOSE  |  eth1
|┌docker.nginx.local:59090                           |    =        5   |     1660  |  CLOSE  |  eth0
|└lhsdock-php.nginx.local:9000                       |    =        5   |     4508  |  CLOS E |  eth0

| TCP Connections (Source Host:Port)                 |      Packets    |    Bytes  |  Flag   |  Iface        
| -------------------------------------------------- | --------------- | --------- | ------- | ------
|┌lhsdock.nginx.local:59090                          |    =        5   |     1660  |  CLOSE  |  eth0
|└lhsdock-php.nginx.local:9000                       |    =        5   |     4508  |  CLOSE  |  eth0

