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

| OPTIONAL | REPOSITORY                                            |  TAG       | SIZE             | FROM
| -------- | ----------------------------------------------------- | ---------- | ---------------- | -------------
|          | nginx:alpine                                          | latest     | 23.5MB           |              
| *        | lhsradek/lhsdock                                      | v3         | 25 .. 63.5MB ;-) | nginx:alpine 
|          | php                                                   | fpm-alpine | 73.4MB           | ubuntu
|          | docker.elastic.co/elasticsearch/elasticsearch         | 8.4.1      | 1.26GB           | ubuntu
|          | docker.elastic.co/kibana/kibana                       | 8.4.1      | 799MB            | ubuntu
|          | docker.elastic.co/enterprise-search/enterprise-search | 8.4.1      | 1.45GB           | ubuntu
|          | logstash                                              | 8.4.1      | 735MB            | ubuntu
|          | docker.elastic.co/beats/elastic-agent                 | 8.4.1      | 2.16GB           | ubuntu
|          | docker.elastic.co/apm/apm-server                      | 8.4.1      | 229MB            | ubuntu
|          | docker.elastic.co/beats/heartbeat                     | 8.4.1      | 2.08GB           | ubuntu
|          | docker.elastic.co/beats/packetbeat                    | 8.4.1      | 591MB            | ubuntu
|          | docker.elastic.co/beats/filebeat                      | 8.4.1      | 405MB            | ubuntu


| IMAGES                                 | PORTS                         | NAMES          | HOSTNAMES
| -------------------------------------- | ----------------------------- | -------------- | ------------------------
| lhsradek/lhsdock:v3                    | 80/tcp, 443/tcp               | lhsdock        | www.nginx.local
| php:fpm-alpine                         | 9000/tcp                      | lhsdock-php    | weblhs-php.nginx.local
| docker.elastic.co/elasticsearch        |                               | lhsdock-setup  | setup
| docker.elastic.co/elasticsearch        | 9200/tcp, 9300/tcp            | lhsdock-es01   | es01.www.nginx.local
| docker.elastic.co/elasticsearch        | 9300->9201/tcp, 9201->9200/tcp| lhsdock-es02   | es02.www.nginx.local
| docker.elastic.co/kibana               | 5601/tcp                      | lhsdock-kibana | kibana.www.nginx.local
| docker.elastic.co/enterprise-search    | 3002/tcp                      | lhsdock-eps    | 
| docker.elastic.co/beats/elastic-agent  | 8200/tcp                      | elastic-agent  |
| docker.elastic.co/apm/apm-server       | 8200/tcp                      | lhsdock-apm    |
| logstash:8.4.1                         | 5044/tcp                      | lhsdock-log    | log.www.nginx.local
| docker.elastic.co/beats/heartbeat      |                               | lhsdock-heart  |
| docker.elastic.co/beats/packetbeat     |                               | lhsdock-packet |
| docker.elastic.co/beats/filebeat       |                               | lhsdock-file   |


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

