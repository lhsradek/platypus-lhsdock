### platypus-lhsdock with Elasticsearch and Kibana

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

```
================= STOP =================
Stopping lhsdock-eps      ... done
Stopping lhsdock-metric   ... done
Stopping lhsdock-file     ... done
Stopping lhsdock-logstash ... done
Stopping lhsdock-heart    ... done
Stopping lhsdock-kibana   ... done
Stopping lhsdock-cerebro  ... done
Stopping lhsdock-es01     ... done
Stopping lhsdock-php      ... done
Stopping lhsdock          ... done
Removing lhsdock-eps      ... done
Removing lhsdock-metric   ... done
Removing lhsdock-file     ... done
Removing lhsdock-logstash ... done
Removing lhsdock-heart    ... done
Removing lhsdock-kibana   ... done
Removing lhsdock-cerebro  ... done
Removing lhsdock-es01     ... done
Removing lhsdock-setup    ... done
Removing lhsdock-php      ... done
Removing lhsdock          ... done
Network platypus-local is external, skipping
Removing network nginx.local
================= START ================
Pulling weblhs     ... done
Pulling weblhs-php ... done
Pulling setup      ... done
Pulling es01       ... done
Pulling kibana     ... done
Pulling logstash   ... done
Pulling metricbeat ... done
Pulling heartbeat  ... done
Pulling filebeat   ... done
Pulling eps        ... done
Pulling cerebro    ... done
Creating network "nginx.local" with the default driver
Creating lhsdock       ... done
Creating lhsdock-php   ... done
Creating lhsdock-setup ... done
Creating lhsdock-es01  ... done
Creating lhsdock-kibana  ... done
Creating lhsdock-cerebro ... done
Creating lhsdock-logstash ... done
Creating lhsdock-metric   ... done
Creating lhsdock-eps      ... done
Creating lhsdock-heart    ... done
Creating lhsdock-file     ... done
```

6) exec lhsdock ```bin/stop```

## Setup

| OPTIONAL | REPOSITORY                                            |  TAG       | SIZE            
| -------- | ----------------------------------------------------- | ---------- | ----------------
|          | nginx:alpine                                          | latest     | 23.5MB
| *        | lhsradek/lhsdock                                      | v3         | 25 .. 63.5MB ;-)
|          | php                                                   | fpm-alpine | 73.4MB
|          | docker.elastic.co/elasticsearch/elasticsearch         | 8.4.1      | 1.26GB
|          | docker.elastic.co/kibana/kibana                       | 8.4.1      | 799MB
|          | docker.elastic.co/enterprise-search/enterprise-search | 8.4.1      | 1.45GB
|          | logstash                                              | 8.4.1      | 735MB
|          | <strike>docker.elastic.co/beats/elastic-agent</strike>                 | <strike>8.4.1</strike>      | <strike>2.16GB</strike>
|          | <strike>docker.elastic.co/apm/apm-server</strike>                      | <strike>8.4.1</strike>      | <strike>229MB</strike>
|          | docker.elastic.co/beats/heartbeat                     | 8.4.1      | 2.08GB
|          | docker.elastic.co/beats/metricbeat                    | 8.4.1      | 496MB
|          | docker.elastic.co/beats/filebeat                      | 8.4.1      | 405MB
|          | lmenezes/cerebro                                      | 0.9.4      | 284MB



| IMAGES               | PORTS                    | NAMES           | HOSTNAMES
| -------------------- | ------------------------ | --------------- | -------------------------
| lhsradek/lhsdock:v3  | 80/tcp, 443/tcp          | lhsdock         | www.nginx.local
| php:fpm-alpine       | 9000/tcp                 | lhsdock-php     | weblhs-php.nginx.local
| elasticsearch        |                          | lhsdock-setup   | setup
| elasticsearch        | 9200/tcp, 9300/tcp       | lhsdock-es01    | es01.www.nginx.local
| elasticsearch        | 9200/tcp, 9301->9300/tcp | lhsdock-es02    | es02.www.nginx.local
| kibana               | 5601/tcp (8200, 8220)    | lhsdock-kibana  | kibana.www.nginx.local
| enterprise-search    | 3002/tcp                 | lhsdock-eps     | eps.nginx.local 
| <strike>elastic-agent</strike>        | <strike>8220/tcp</strike>                 | <strike>lhsdock-fleet</strike>   | <strike>fleet.nginx.local</strike>
| <strike>apm-server</strike>           | <strike>8200/tcp</strike>                 | <strike>lhsdock-apm</strike>     | <strike>apm.nginx.local</strike>
| logstash             | 5044/tcp                 | lhsdock-log     | log.nginx.local
| heartbeat            |                          | lhsdock-heart   | heart.nginx.local
| metricbeat           |                          | lhsdock-metric  | metric.nginx.local
| filebeat             |                          | lhsdock-file    | file.nginx.local
| cerebro              | 9000/tcp                 | lhsdock-cerebro | cerebro.www.nginx.local



#### Sample for php

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

