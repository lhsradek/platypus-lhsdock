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
Stopping lhsdock-eps    ... done
Stopping elastic-agent  ... done
Stopping lhsdock-es01   ... done
Stopping lhsdock        ... done
Stopping lhsdock-php    ... done
Removing lhsdock-eps    ... done
Removing elastic-agent  ... done
Removing lhsdock-kibana ... done
Removing lhsdock-es01   ... done
Removing lhsdock        ... done
Removing lhsdock-php    ... done
Removing lhsdock-setup  ... done
Network platypus-local is external, skipping
Removing network nginx.local
================= START =================
Pulling weblhs        ... done
Pulling weblhs-php    ... done
Pulling setup         ... done
Pulling es01          ... done
Pulling kibana        ... done
Pulling elastic-agent ... done
Creating network "nginx.local" with the default driver
Creating lhsdock-php   ... done
Creating lhsdock-setup ... done
Creating lhsdock       ... done
Creating lhsdock-es01  ... done
Creating elastic-agent  ... done
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
|          | <strike>docker.elastic.co/enterprise-search/enterprise-search</strike> | <strike>8.4.1</strike>      | <strike>1.45GB</strike>
|          | <strike>logstash</strike>                                              | <strike>8.4.1</strike>      | <strike>735MB</strike>
|          | docker.elastic.co/beats/elastic-agent                 | 8.4.1      | 2.16GB
|          | <strike>docker.elastic.co/apm/apm-server</strike>                      | <strike>8.4.1</strike>      | <strike>229MB</strike>
|          | <strike>docker.elastic.co/beats/heartbeat</strike>                     | <strike>8.4.1</strike>      | <strike>2.08GB</strike>
|          | <strike>docker.elastic.co/beats/metricbeat</strike>                    | <strike>8.4.1</strike>      | <strike>496MB</strike>
|          | <strike>docker.elastic.co/beats/filebeat</strike>                      | <strike>8.4.1</strike>      | <strike>405MB</strike>


| IMAGES               | PORTS                    | NAMES          | HOSTNAMES
| -------------------- | ------------------------ | -------------- | ------------------------
| lhsradek/lhsdock:v3  | 80/tcp, 443/tcp          | lhsdock        | www.nginx.local
| php:fpm-alpine       | 9000/tcp                 | lhsdock-php    | weblhs-php.nginx.local
| elasticsearch        |                          | lhsdock-setup  | setup
| elasticsearch        | 9200/tcp, 9300/tcp       | lhsdock-es01   | es01.www.nginx.local
| <strike>elasticsearch</strike>        | <strike>9200/tcp, 9301->9300/tcp</strike> | <strike>lhsdock-es02</strike>   | <strike>es02.www.nginx.local</strike>
| kibana               | 5601/tcp                 | lhsdock-kibana | kibana.www.nginx.local
| <strike>enterprise-search</strike>    | <strike>3002/tcp</strike>                 | <strike>lhsdock-eps</strike>    | <strike>eps.nginx.local</strike> 
| elastic-agent        | 8200/tcp                 | elastic-agent  | fleet.nginx.local
| <strike>apm-server</strike>           | <strike>8200/tcp</strike>                 | <strike>lhsdock-apm</strike>    | <strike>apm.nginx.local</strike>
| <strike>logstash</strike>             | <strike>5044/tcp</strike>                 | <strike>lhsdock-log</strike>    | <strike>log.nginx.local</strike>
| <strike>heartbeat</strike>            |                          | <strike>lhsdock-heart</strike>  | <strike>heart.nginx.local</strike>
| <strike>metricbeat</strike>           |                          | <strike>lhsdock-metric</strike> | <strike>metric.nginx.local</strike>
| <strike>filebeat</strike>             |                          | <strike>lhsdock-file</strike>   | <strike>file.nginx.local</strike>



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
|┌platypus-box_traefik_1.platypus-dev.local:36236    |    =        8   |     2025  |  --A-   |  eth1
|└www.nginx.local:80                                 |    =       24   |    29881  |  CLOSE  |  eth1
|┌www.nginx.local:59090                              |    =        5   |     1660  |  CLOSE  |  eth0
|└weblhs-php.nginx.local:9000                        |    =        5   |     4508  |  CLOSE  |  eth0

-----

https://www.facebook.com/radek.kadner/

https://www.linkedin.com/in/radekkadner/

mailto:radek.kadner@gmail.com

