### platypus-lhsdock with elasticsearch, logstash and kibana (ELK)

[![Docker Pulls](https://img.shields.io/docker/pulls/lhsradek/lhsdock)](https://hub.docker.com/repository/docker/lhsradek/lhsdock)

#### Setup

* create .env file ```cp .env.dist .env```
* run lhsdock ```bin/start```
* exec lhsdock ```bin/exec```

* If used lhsradek/lhsdock (*) to run use:

``` # perl /root/bin/platypus.pl```

* restart lhsdock ```bin/restart```

```
================= STOP =================
Stopping lhsdock-logstash ... done
Stopping lhsdock-eps      ... done
Stopping lhsdock-fleet    ... done
Stopping lhsdock-kibana   ... done
Stopping lhsdock-es03     ... done
Stopping lhsdock-cerebro  ... done
Stopping lhsdock-es02     ... done
Stopping lhsdock-es01     ... done
Stopping lhsdock-php      ... done
Stopping lhsdock          ... done
Removing lhsdock-logstash ... done
Removing lhsdock-eps      ... done
Removing lhsdock-fleet    ... done
Removing lhsdock-kibana   ... done
Removing lhsdock-es03     ... done
Removing lhsdock-cerebro  ... done
Removing lhsdock-es02     ... done
Removing lhsdock-es01     ... done
Removing lhsdock-php      ... done
Removing lhsdock          ... done
Network platypus-local is external, skipping
Removing network nginx.local
================= START ================
Pulling weblhs     ... done
Pulling weblhs-php ... done
Pulling setup      ... done
Pulling es01       ... done
Pulling es02       ... done
Pulling es03       ... done
Pulling kibana     ... done
Pulling fleet      ... done
Pulling logstash   ... done
Pulling eps        ... done
Pulling cerebro    ... done
Creating network "nginx.local" with the default driver
Creating lhsdock-php   ... done
Creating lhsdock-setup ... done
Creating lhsdock       ... done
Creating lhsdock-es01  ... done
Creating lhsdock-cerebro ... done
Creating lhsdock-es02    ... done
Creating lhsdock-es03    ... done
Creating lhsdock-kibana  ... done
Creating lhsdock-fleet   ... done
Creating lhsdock-logstash ... done
Creating lhsdock-eps      ... done
```

* stop lhsdock ```bin/stop```

-----

| REPOSITORY                                            |  TAG       | SIZE             | OPTIONAL
| ----------------------------------------------------- | ---------- | ---------------- | ----------------
| nginx:alpine                                          | latest     | 23.5MB           |
| lhsradek/lhsdock                                      | v3         | 25 .. 63.5MB ;-) | nginx:alpine
| php                                                   | fpm-alpine | 73.4MB           |
| docker.elastic.co/elasticsearch/elasticsearch         | 8.4.2      | 1.26GB           |
| docker.elastic.co/kibana/kibana                       | 8.4.2      | 797MB            |
| docker.elastic.co/enterprise-search/enterprise-search | 8.4.2      | 1.45GB           |
| logstash                                              | 8.4.2      | 735MB            |
| docker.elastic.co/beats/elastic-agent                 | 8.4.2      | 2.16GB           | 
| docker.elastic.co/beats/elastic-agent-complete        | 8.4.2      | 3.67GB           | * 
| docker.elastic.co/apm/apm-server                      | 8.4.2      | 230MB            |
| docker.elastic.co/beats/metricbeat                    | 8.4.2      | 496MB            |
| docker.elastic.co/beats/heartbeat                     | 8.4.2      | 2.09GB           |
| docker.elastic.co/beats/filebeat                      | 8.4.2      | 405MB            |
| lmenezes/cerebro                                      | 0.9.4      | 284MB            |


| IMAGES               | PORTS                  | NAMES            | HOSTNAMES                 | OPTIONAL  
| -------------------- | ---------------------- | ---------------- | ------------------------- | --------
| lhsradek/lhsdock:v3  | 80/tcp, 443/tcp        | lhsdock          | www.nginx.local           |
| php:fpm-alpine       | 9000/tcp               | lhsdock-php      | weblhs-php.nginx.local    | 
| elasticsearch        |                        | lhsdock-setup    | setup                     | *
| elasticsearch        | 9200/tcp, 9300/tcp     | lhsdock-es01     | es01.www.nginx.local      |
| elasticsearch        | 9201/tcp, 9301/tcp     | lhsdock-es02     | es02.www.nginx.local      | 
| elasticsearch        | 9202/tcp, 9302/tcp     | lhsdock-es03     | es03.www.nginx.local      |
| kibana               | 5601/tcp               | lhsdock-kibana   | kibana.www.nginx.local    |
| metricbeat           | 5066/tcp               | lhsdock-metric   | metric.nginx.local        | * 
| heartbeat            | 5067/tcp               | lhsdock-heart    | heart.nginx.local         | *
| filebeat             | 5068/tcp               | lhsdock-file     | file.nginx.local          | *
| enterprise-search    | 3002/tcp               | lhsdock-eps      | eps.nginx.local           | *
| elastic-agent        | 8200/tcp, 8220/tcp ..  | lhsdock-fleet    | fleet.nginx.local         | *
| apm-server           | 8200/tcp               | lhsdock-apm      | apm.nginx.local           | *
| logstash             | 5044/tcp, 9600/tcp     | lhsdock-logstash | logstash.nginx.local      | *
| cerebro              | 9000/tcp               | lhsdock-cerebro  | cerebro.www.nginx.local   | *

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
