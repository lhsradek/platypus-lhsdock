### platypus-lhsdock

with Elasticsearch, Logstash and Kibana ([ELK](https://www.elastic.co/))

[![Docker Pulls](https://img.shields.io/docker/pulls/lhsradek/lhsdock)](https://hub.docker.com/repository/docker/lhsradek/lhsdock)
[![Docker Pulls](https://img.shields.io/docker/pulls/lhsradek/fpm)](https://hub.docker.com/repository/docker/lhsradek/fpm) from [platypus-lhsfpm](https://github.com/lhsradek/platypus-lhsfpm)

#### setup
create .env file

```# cp .env.dist .env```

```# bin/install```

```# bin/setup```

```# bin/setup-fleet``` or ```# bin/setup-eps```

See https://github.com/lhsradek/platypus-lhsdock/tree/main/extras/dokuwiki/config/dokuwiki/data/pages

#### run lhsdock
```# bin/start```

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
Pulling es03        ... done
Pulling cerebro     ... done
Pulling heartbeat   ... done
Pulling kibana      ... done
Pulling logstash    ... done
Pulling fleet       ... done
Pulling eps         ... done
Creating network "nginx.local" with driver "bridge"
Creating lhsdock-setup ... done
Creating lhsdock-php   ... done
Creating lhsdock-web   ... done
Creating lhsdock-es01  ... done
Creating lhsdock-es02  ... done
Creating lhsdock-es03      ... done
Creating lhsdock-wiki  ... done
Creating lhsdock-kibana    ... done
Creating lhsdock-cerebro   ... done
Creating lhsdock-logstash  ... done
Creating lhsdock-heartbeat ... done
Creating lhsdock-fleet     ... done
Creating lhsdock-eps       ... done
```

#### stop lhsdock
```# bin/stop```

#### remove lhsdock
```# bin/all-remove```

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
| lhsradek/lhsdock:v3  | 80/tcp, 443/tcp        | lhsdock            | ```www.nginx.local```                |
| php:fpm-alpine       | 9000/tcp               | lhsdock-php        | ```weblhs-php.nginx.local```         | 
| elasticsearch        |                        | lhsdock-setup      | ```setup.www.nginx.local```          | *
| elasticsearch        | 9200/tcp, 9300/tcp     | lhsdock-es01       | ```es01.www.nginx.local```           |
| elasticsearch        | 9201/tcp, 9301/tcp     | lhsdock-es02       | ```es02.www.nginx.local```           | 
| elasticsearch        | 9202/tcp, 9302/tcp     | lhsdock-es03       | ```es03.www.nginx.local```           |
| kibana               | 5601/tcp               | lhsdock-kibana     | ```kibana.www.nginx.local```         |
| apm-server           | 5066/tcp, 8200/tcp     | lhsdock-apm        | ```apm.nginx.local```                | *
| metricbeat           | 5066/tcp               | lhsdock-metricbeat | ```metricbeat.nginx.local```         | * 
| filebeat             | 5066/tcp               | lhsdock-filebeat   | ```filebeat.nginx.local```           | *
| heartbeat            | 5066/tcp               | lhsdock-heartbeat  | ```heartbeat.nginx.local```          | 
| enterprise-search    | 3002/tcp               | lhsdock-eps        | ```eps.nginx.local```                | *
| elastic-agent        | 8200/tcp, 8220/tcp ..  | lhsdock-fleet      | ```fleet.nginx.local```              | *
| logstash             | 5044/tcp, 9600/tcp     | lhsdock-logstash   | ```logstash.nginx.local```           | *
| cerebro              | 9000/tcp               | lhsdock-cerebro    | ```cerebro.www.nginx.local```        | *
| dokuwiki:latest      | 80/tcp, 443/tcp        | lhsdock-wiki       | ```wiki.www.nginx.local```           | *

-----

##### Cluster uuid

So that Filebeat does not beats to a ```Standalone Cluster```, it is good to have the ```CLUSTER_UUID``` set in the ```.env``` before the first
launch of the Fleet Server. Setup writes it on the console.

In case of any change in the environment variables, the volume of the fleet server must be deleted, the fleet server will be created again and will enroll everything by itself. It is naive to think that variables can be changed additionally. It is always necessary to empty the volume

##### Heartbeat

Heartbeat is in a separate container, it tests the necessary ones before starting kibana and logstash, because it is sufficient
with elasticsearch. Metricbeat in the elastic agent requires kibana, so the Fleet Server starts only after starting Kibana and
its heartbeat is only used if the elastic synthetic police is set or another monitoring is manually set - it will introduce
the police itself

You will find an integrations when you first start kibana and they will have polices set.

```cp certs/ca/ca.crt cert/ca.crt``` This is so that other elastic agents from other projects can have ca.crt in the cert directory
```/usr/share/elastic-agent/certs/ca.crt```

#### Setting Fleet Server

##### Elasticsearch

Elasticsearch - hosts:

```https://es01.docker.nginx.local:9200```

Elasticsearch - Advanced YAML configuration:

```ssl.certificate_authorities: ["/usr/share/elastic-agent/certs/ca.crt"]```

##### Logstash

See https://www.gooksu.com/2022/05/fleet-server-with-logstash-output-elastic-agent/

Specify hosts:

```logstash.docker.nginx.local:5044```

For Server SSL certificate authorities (optional) output from

```cat ./certs/ca/ca.crt```

For Client SSL certificate output from

```cat ./certs/logstash.docker.nginx.local/logstash.docker.nginx.local.crt```

For Client SSL certificate key output from

```cat ./certs/logstash.docker.nginx.local/logstash.docker.nginx.local.key```

To logstash output - Advanced YAML configuration You can optional add:

```ssl.verification_mode: none```

Default for agent integrations interferes with APM, don't change it

Set Make this output the default for agent monitoring.

##### Enrollment token

For this project In ```.env``` set ```FLEET_ENROLLMENT_TOKEN``` from Enrollment tokens - Agent Nginx policy 1

##### Fleet Server

In Fleet - Agents add a Fleet Server. Select Advanced Agent Nginx policy 1
as Fleet Server host select ```https://fleet.docker.nginx.local:8220``` and Add host

Generate a service token and copy the token to ```FLEET_SERVER_SERVICE_TOKEN``` in ```.env```
For this policy set ```FLEET_SERVER_POLICY_ID=agent-nginx-policy-1``` in ```.env```
If you would make a new police (for example Agent Nginx policy 2) you need to create a fleet server with a new police
and edit the .env and set it.

Ignore other advice about enrollment (as curl and sudo elastic-agent enroll...) if the volume for the Fleet Server is empty,
everything will be created by itself thanks to how the environment variables of the Fleet Service are set in docker-compose file.

Restart and see how Fleet Server start and enroll.

-----

* https://www.facebook.com/radek.kadner/
* https://www.linkedin.com/in/radekkadner/
* mailto:radek.kadner@gmail.com
