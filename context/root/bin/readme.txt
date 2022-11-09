### platypus-lhsdock

with Elasticsearch, Logstash and Kibana ([ELK](https://www.elastic.co/))

[![Docker Pulls](https://img.shields.io/docker/pulls/lhsradek/lhsdock)](https://hub.docker.com/repository/docker/lhsradek/lhsdock)
[![Docker Pulls](https://img.shields.io/docker/pulls/lhsradek/fpm)](https://hub.docker.com/repository/docker/lhsradek/fpm) from [platypus-lhsfpm](https://github.com/lhsradek/platypus-lhsfpm)

#### setup
create .env file

```# cp .env.dist .env```

See https://github.com/lhsradek/platypus-lhsdock/tree/main/extras/dokuwiki/config/dokuwiki/data/pages

#### run lhsdock
```# bin/start```

#### exec lhsdock
```# bin/exec```

#### restart lhsdock
```# bin/restart```

```
================= STOP =================
Stopping lhsdock-eps       ... done
Stopping lhsdock-fleet     ... done
Stopping lhsdock-cerebro   ... done
Stopping lhsdock-kibana    ... done
Stopping lhsdock-heartbeat ... done
Stopping lhsdock-logstash  ... done
Stopping lhsdock-es03      ... done
Stopping lhsdock-es02      ... done
Stopping lhsdock-wiki      ... done
Stopping lhsdock-web       ... done
Stopping lhsdock-php       ... done
Stopping lhsdock-es01      ... done
Removing lhsdock-eps       ... done
Removing lhsdock-fleet     ... done
Removing lhsdock-cerebro   ... done
Removing lhsdock-kibana    ... done
Removing lhsdock-heartbeat ... done
Removing lhsdock-logstash  ... done
Removing lhsdock-es03      ... done
Removing lhsdock-es02      ... done
Removing lhsdock-wiki      ... done
Removing lhsdock-web       ... done
Removing lhsdock-php       ... done
Removing lhsdock-es01      ... done
Removing lhsdock-setup     ... done
Removing network nginx.local
Network traefik.local is external, skipping
================= START ================
Pulling setup       ... done
Pulling weblhs-php  ... done
Pulling weblhs      ... done
Pulling weblhs-wiki ... done
Pulling es01        ... done
Pulling es02        ... done
Pulling cerebro     ... done
Pulling heartbeat   ... done
Pulling kibana      ... done
Pulling logstash    ... done
Pulling fleet       ... done
Pulling eps         ... done
Pulling es03        ... done
Creating network "nginx.local" with driver "bridge"
Creating lhsdock-setup ... done
Creating lhsdock-php   ... done
Creating lhsdock-web   ... done
Creating lhsdock-es01  ... done
Creating lhsdock-wiki  ... done
Creating lhsdock-es02  ... done
Creating lhsdock-kibana    ... done
Creating lhsdock-es03      ... done
Creating lhsdock-cerebro   ... done
Creating lhsdock-logstash  ... done
Creating lhsdock-heartbeat ... done
Creating lhsdock-fleet     ... done
Creating lhsdock-eps       ... done
```

#### stop lhsdock
```# bin/stop```


#### Reposirories

| REPOSITORY                                            |  TAG       | SIZE        | OPTIONAL
| ----------------------------------------------------- | ---------- | ----------- | ----------------
| nginx:alpine                                          | latest     | 23.5MB      | lhsradek/lhsdock
| lhsradek/lhsdock                                      | v3         | 25 - 61MB   | nginx:alpine
| php                                                   | fpm-alpine | 73.4MB      |
| docker.elastic.co/elasticsearch/elasticsearch         | 8.5.0      | 1.29GB      |
| docker.elastic.co/kibana/kibana                       | 8.5.0      | 715MB       |
| docker.elastic.co/enterprise-search/enterprise-search | 8.5.0      | 1.45GB      |
| logstash                                              | 8.5.0      | 753MB       |
| docker.elastic.co/beats/elastic-agent                 | 8.5.0      | 2.07GB      | 
| docker.elastic.co/beats/elastic-agent-complete for [Elastic Synthetics](https://www.elastic.co/guide/en/observability/current/monitor-uptime-synthetics.html#monitoring-synthetics) | 8.5.0      | 3.59GB      |
| docker.elastic.co/apm/apm-server                      | 8.5.0      | 230MB       |
| docker.elastic.co/beats/metricbeat                    | 8.5.0      | 496MB       |
| docker.elastic.co/beats/heartbeat                     | 8.5.0      | 2.1GB       |
| docker.elastic.co/beats/filebeat                      | 8.5.0      | 406MB       |
| lmenezes/cerebro                                      | 0.9.4      | 284MB       |
| lscr.io/linuxserver/dokuwiki                          | latest     | 209MB       |

With [lhsradek/lhsdock](https://hub.docker.com/repository/docker/lhsradek/lhsdock/) You can use the program [platypus.pl](https://github.com/lhsradek/platypus-lhsdock/blob/main/context/root/bin/platypus.pl) for certificates,
which I don't use much anymore, the Elastic Certificate Tool is used by webservice 'setup'.

```# perl /root/bin/platypus.pl```

-----

| IMAGES               | PORTS                  | NAMES              | HOSTNAMES                            | OPTIONAL  
| -------------------- | ---------------------- | ------------------ | ------------------------------------ | --------
| lhsradek/lhsdock:v3  | 80/tcp, 443/tcp        | lhsdock            | <code>www.nginx.local</code>         |
| php:fpm-alpine       | 9000/tcp               | lhsdock-php        | <code>weblhs-php.nginx.local</code>  | 
| elasticsearch        |                        | lhsdock-setup      | <code>setup.www.nginx.local</code>   | *
| elasticsearch        | 9200/tcp, 9300/tcp     | lhsdock-es01       | <code>es01.www.nginx.local</code>    |
| elasticsearch        | 9201/tcp, 9301/tcp     | lhsdock-es02       | <code>es02.www.nginx.local</code>    | 
| elasticsearch        | 9202/tcp, 9302/tcp     | lhsdock-es03       | <code>es03.www.nginx.local</code>    |
| kibana               | 5601/tcp               | lhsdock-kibana     | <code>kibana.www.nginx.local</code>  |
| apm-server           | 5066/tcp, 8200/tcp     | lhsdock-apm        | <code>apm.nginx.local</code>         | *
| metricbeat           | 5066/tcp               | lhsdock-metricbeat | <code>metricbeat.nginx.local</code>  | * 
| filebeat             | 5066/tcp               | lhsdock-filebeat   | <code>filebeat.nginx.local</code>    | *
| heartbeat            | 5066/tcp               | lhsdock-heartbeat  | <code>heartbeat.nginx.local</code>   | *
| enterprise-search    | 3002/tcp               | lhsdock-eps        | <code>eps.nginx.local</code>         | *
| elastic-agent        | 8200/tcp, 8220/tcp ..  | lhsdock-fleet      | <code>fleet.nginx.local</code>       | *
| logstash             | 5044/tcp, 9600/tcp     | lhsdock-logstash   | <code>logstash.nginx.local</code>    | *
| cerebro              | 9000/tcp               | lhsdock-cerebro    | <code>cerebro.www.nginx.local</code> | *
| dokuwiki:latest      | 80/tcp, 443/tcp        | lhsdock-wiki       | <code>wiki.www.nginx.local</code>    | *

-----

#### Example of connection for php

| NETWORK                    | DRIVER | SCOPE
| -------------------------- | ------ | -----
| platypus-dev.local         | bridge | local
| nginx.local                | bridge | local


HOSTNAME='www.nginx.local'

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
|┌traefik.platypus-dev.local:36236                   |    =        8   |     2025  |  --A-   |  eth1
|└www.nginx.local:80                                 |    =       24   |    29881  |  CLOSE  |  eth1
|┌www.nginx.local:59090                              |    =        5   |     1660  |  CLOSE  |  eth0
|└weblhs-php.nginx.local:9000                        |    =        5   |     4508  |  CLOSE  |  eth0

-----

* https://www.facebook.com/radek.kadner/
* https://www.linkedin.com/in/radekkadner/
* mailto:radek.kadner@gmail.com
