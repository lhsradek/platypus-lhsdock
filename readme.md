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

| REPOSITORY       |  TAG       | SIZE
| ---------------- | ---------- | -----------------
| lhsradek/lhsdock | v3         | 25 .. 63.4MB ;-)
| php              | fpm-alpine | 73.4MB
| nginx            | alpine     | 23.5MB

| IMAGES              | PORTS           | NAMES
| ------------------- | --------------- | ------------
| lhsradek/lhsdock:v3 | 80/tcp, 443/tcp | lhsdock
| php:fpm-alpine      | 9000/tcp        | lhsdock-php

example:
| TCP Connections (Source Host:Port)    |      Packets    |    Bytes  |  Flag   |  Iface        
| ------------------------------------- | --------------- | --------- | ------- | -------
|┌172.18.0.9:37000                      |    =       26   |     3036  |  CLOSE  |  eth0
|└172.18.0.3:443                        |    =       24   |    29881  |  CLOSE  |  eth0
|┌172.18.0.3:40928                      |    =        5   |     1652  |  CLOSE  |  eth0
|└172.18.0.2:9000                       |    =        5   |     4388  |  CLOSE  |  eth0

