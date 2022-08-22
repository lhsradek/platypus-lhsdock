### platypus-lhsdock

https://hub.docker.com/repository/docker/lhsradek/lhsdock

#### Setup

1) create .env file ```cp .env.dist .env```
2) run lhsdock ```bin/start```
3) exec lhsdock ```bin/exec```

4) If used lhsradek/lhsdock * to run use:

```/ # perl /root/bin/platypus.pl```

``` # ls /root/bin```

```READme.txt   add.sh       lhsdock      lhsvol       platypus.pl```

5) exec lhsdock ```bin/restart```

```================= STOP =================
Stopping lhsdock-php ... done
Stopping lhsdock     ... done
Removing lhsdock-php ... done
Removing lhsdock     ... done
Removing network nginx.local
Network platypus-dev.local is external, skipping
================= START =================
Pulling weblhs     ... done
Pulling weblhs-php ... done
Creating network "nginx.local" with the default driver
Creating lhsdock     ... done
Creating lhsdock-php ... done
```


6) exec lhsdock ```bin/stop```

## Setup

| OPTIONAL | REPOSITORY         |  TAG       | SIZE             | FROM
| -------- | ------------------ | ---------- | ---------------- | -------------
|          | nginx:alpine       | latest     | 23               |              
| *        | lhsradek/lhsdock   | v3         | 25 .. 63.4MB ;-) | nginx:alpine 
|          | php                | fpm-alpine | 73.4MB           |

| IMAGES              | PORTS           | NAMES       | HOSTNAMES
| ------------------- | --------------- | ----------- | ----------------------
| lhsradek/lhsdock:v3 | 80/tcp, 443/tcp | lhsdock     | www.nginx.local
| php:fpm-alpine      | 9000/tcp        | lhsdock-php | weblhs-php.nginx.local


| NETWORK                    | DRIVER | SCOPE
| -------------------------- | ------ | -----
| platypus-dev.local         | bridge | local
| nginx.local                | bridge | local


HOSTNAME=www.nginx.local

| State       | Local Address:Port | Process 
| ----------- | ------------------ | ----------------------------
| LISTEN      |      0.0.0.0:80    | users:(("nginx",pid=1,fd=8))       
| LISTEN      |   127.0.0.11:36947 |                                    

HOSTNAME='weblhs-php.nginx.local'

| State       | Local Address:Port | Process 
| ----------- | ------------------ | -------------------------------
| LISTEN      |   127.0.0.11:45811 |                         
| LISTEN      |            *:9000  | users:(("php-fpm",pid=1,fd=7))


| TCP Connections (Source Host:Port)                 |      Packets    |    Bytes  |  Flag   |  Iface        
| -------------------------------------------------- | --------------- | --------- | ------- | ------
|┌platypus-box_traefik_1.platypus-dev.local:36236    |    =        8   |     2025  |  --A-   |  eth1
|└www.nginx.local:80                                 |    =       24   |    29881  |  CLOSE  |  eth1
|┌www.nginx.local:59090                              |    =        5   |     1660  |  CLOSE  |  eth0
|└weblhs-php.nginx.local:9000                        |    =        5   |     4508  |  CLOSE  |  eth0

