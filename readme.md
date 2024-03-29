### platypus-lhsdock

with Elasticsearch, Logstash and Kibana ([ELK](https://www.elastic.co/))

[![Docker Pulls](https://img.shields.io/docker/pulls/lhsradek/lhsdock)](https://hub.docker.com/repository/docker/lhsradek/lhsdock)

#### setup
create .env file

```# cp .env.dist .env```

```# bin/install```

This part will produce volumes. After install elastic itself will run without other services. You can set the users, rights, find out the cluster uuid... I still use ```lhsdock``` on another computer, where it is not necessary to run e.g. Kibana. It is possible that this part is enough.

```# bin/setup```

This section will add additional services to docker-compose. If you don't want one, just comment out the file in ```bin/setup```. It is important that, for example, Kibana does not start before the Kibana user has a password set. That's why the install part is separate and not all together in one docker-compose. At the moment, e.g. logstash is turned off like this because I have one right in the traefik project and I don't need another one. You may find it useful to uncomment the line to add logstash to docker-compose. If you don't need wiki or cerebro, you can comment these lines. I find it easier to comment out just lines in ```bin/setup``` than entire long sections in docker-compose.
For example, when I debug only logstash I don't need to run Kibana and other services. Then I comment out the lines and re-build docker-compose by ```bin/setup```.

```# bin/setup-fleet``` or ```# bin/setup-eps```

It adds Fleet server or Enterprise search, which I usually don't use and which helped me configure other services. I wondered for a long time why e.g. Kibana tells me to turn on APM when I already had it set up. This was because no one was sending data to the APM server.

The ```install```, ```setup``` and ```all-remove``` parts first shut down the project and then prompt to delete docker-compose. They don't delete it straight away, because you can have important changes in it which you test with a restart. Running the command again after docker-compose has been deleted will only do the action. Existing docker-compose also works as a lock against unwanted ```all-remove``` for example. The project just stops and can be started again. Make changes in the files that are in the [compose directory](https://github.com/lhsradek/platypus-lhsdock/tree/main/compose) and from which docker-compose is compiled. The docker-compose divided into several parts allows me better scalability.

See:
* https://github.com/lhsradek/platypus-lhsdock/tree/main/extras/dokuwiki/config/dokuwiki/data/pages
* [Lightweight version](https://github.com/lhsradek/platypus-platel)

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

This section deletes the created volumes.

#### Reposirories

| REPOSITORY                                            |  TAG       | SIZE        | OPTIONAL
| ----------------------------------------------------- | ---------- | ----------- | ----------------
| nginx:alpine                                          | latest     | 40.7MB      | [platypus-lhsdock](https://github.com/lhsradek/platypus-lhsdock/blob/main/context/Dockerfile)
| [lhsradek/platypus-fpm](https://github.com/lhsradek/platypus-lhsfpm) [![Docker Pulls](https://img.shields.io/docker/pulls/lhsradek/fpm)](https://hub.docker.com/repository/docker/lhsradek/fpm)  | v1         | 488MB       | php:fpm-alpine
| [docker.elastic.co/elasticsearch/elasticsearch](https://hub.docker.com/_/elasticsearch) | 8.7.0      | 1.33GB      |
| [docker.elastic.co/kibana/kibana](https://hub.docker.com/_/kibana) | 8.7.0      | 748MB       |
| docker.elastic.co/enterprise-search/enterprise-search | 8.7.0      | 1.45GB      |
| [logstash](https://hub.docker.com/_/logstash)         | 8.7.0      | 732MB       |
| docker.elastic.co/beats/elastic-agent                 | 8.7.0      | 1.54GB      | 
| docker.elastic.co/beats/elastic-agent-complete for [Elastic Synthetics](https://www.elastic.co/guide/en/observability/current/monitor-uptime-synthetics.html#monitoring-synthetics)              | 8.7.0      | 3.22GB      |
| docker.elastic.co/apm/apm-server                      | 8.7.0      | 169MB       |
| docker.elastic.co/beats/metricbeat                    | 8.7.0      | 322MB       |
| docker.elastic.co/beats/heartbeat                     | 8.7.0      | 2.06GB      |
| docker.elastic.co/beats/filebeat                      | 8.7.0      | 291MB       |
| lmenezes/cerebro                                      | 0.9.4      | 284MB       |
| [lscr.io/linuxserver/dokuwiki](https://hub.docker.com/r/linuxserver/dokuwiki) | latest     | 235MB       |

With [lhsradek/lhsdock](https://hub.docker.com/repository/docker/lhsradek/lhsdock/) You can use the program [platypus.pl](https://github.com/lhsradek/platypus-lhsdock/blob/main/context/root/bin/platypus.pl) for certificates,
which I don't use much anymore, the Elastic Certificate Tool is used by webservice [setup](https://github.com/lhsradek/platypus-lhsdock/blob/main/compose/docker-setup.yml).

```# perl /root/bin/platypus.pl```

-----

| IMAGES               | PORTS                  | NAMES              | HOSTNAMES                            | OPTIONAL  
| -------------------- | ---------------------- | ------------------ | ------------------------------------ | --------
| lhsradek/lhsdock:v3  | 80/tcp, 443/tcp        | lhsdock            | ```docker.nginx.local```             |
| php:fpm-alpine       | 9000/tcp               | lhsdock-php        | ```weblhs-php.docker.nginx.local```  | 
| elasticsearch        |                        | lhsdock-setup      | ```setup.docker.nginx.local```       | *
| elasticsearch        | 9200/tcp, 9300/tcp     | lhsdock-es01       | ```es01.docker.nginx.local```        |
| elasticsearch        | 9201/tcp, 9301/tcp     | lhsdock-es02       | ```es02.docker.nginx.local```        | 
| elasticsearch        | 9202/tcp, 9302/tcp     | lhsdock-es03       | ```es03.docker.nginx.local```        |
| kibana               | 5601/tcp               | lhsdock-kibana     | ```kibana.docker.nginx.local```      |
| apm-server           | 5066/tcp, 8200/tcp     | lhsdock-apm-server | ```apm-server.docker.nginx.local```  | *
| metricbeat           | 5066/tcp               | lhsdock-metricbeat | ```metricbeat.docker.nginx.local```  | * 
| filebeat             | 5066/tcp               | lhsdock-filebeat   | ```filebeat.docker.nginx.local```    | *
| heartbeat            | 5066/tcp               | lhsdock-heartbeat  | ```heartbeat.docker.nginx.local```   | *
| enterprise-search    | 3002/tcp               | lhsdock-eps        | ```eps.docker.nginx.local```         | *
| elastic-agent        | 8200/tcp, 8220/tcp ..  | lhsdock-fleet      | ```fleet.docker.nginx.local```       | *
| logstash             | 5044/tcp, 9600/tcp     | lhsdock-logstash   | ```logstash.docker.nginx.local```    | *
| cerebro              | 9000/tcp               | lhsdock-cerebro    | ```cerebro.docker.nginx.local```     | *
| dokuwiki:latest      | 80/tcp, 443/tcp        | lhsdock-wiki       | ```wiki.docker.nginx.local```        | *

-----

##### Cluster uuid

Set ```CLUSTER_UUID```  in the ```.env``` before the first launch of the Fleet Server.

```
# curl -s -X GET --cacert certs/ca/ca.crt -u elastic:[KIBANA_PASSWORD] https://es01.docker.nginx.local:9200/?pretty | grep cluster_uuid
```

display such like this:
```
  "cluster_uuid" : "Eft1LUxGR5af29XSygQMHA",
```

Or see
```
# docker logs -f lhsdock-setup
```

In case of any change in the environment variables, the volume of the fleet server must be deleted, the fleet server will be created again and will enroll everything by itself. It is naive to think that variables can be changed additionally. It is always necessary to empty the volume

You will find an integrations when you first start Kibana and they will have polices set. [See settings.](https://github.com/lhsradek/platypus-lhsdock/blob/main/extras/kibana/kibana.yml)

#### My home network

My home network consists of two computers running docker. I have two elasticsearch nodes on computer ```docker``` and one node is enough for me on the computer ```www```. Applications from computers can therefore write to their nearest node. That one on ```www``` will be yellow when the main ```docker``` computer is not running. As soon as I release it, the nodes communicate with each other and the cluster turns green. Furthermore, I placed logstash in a project with traefik, so it is easily accessible to other projects that have traefik as the default network. Each project, including traefik, has its own filebeat and metricbeat or fleet server, which takes care of its logs and services. So services and logs are not tested if the project is not running. In a production environment, it would be enough to have only one filebeat and one metricbeat each or one fleet server per computer.

See:
* https://github.com/lhsradek/platypus-lhsdock/blob/main/png/cerebro02.png
* https://github.com/lhsradek/platypus-lhsdock/blob/main/png/diagram.png

#### Setting Fleet Server

##### Elasticsearch

Elasticsearch - hosts:

```https://es01.docker.nginx.local:9200```

Elasticsearch - Advanced YAML configuration:

```
ssl.certificate_authorities: ["/usr/share/elastic-agent/certs/ca.crt"]
timeout: 20s
```

##### Logstash

See https://www.gooksu.com/2022/05/fleet-server-with-logstash-output-elastic-agent/


For Server SSL certificate authorities (optional) output from

```cat ./certs/ca.crt```

Specify hosts:

```logstash.docker.nginx.local:5045```

For Client SSL certificate output from

```cat ./certs/logstash.docker.nginx.local/logstash.docker.nginx.local.crt```

For Client SSL certificate key output from

```cat ./certs/logstash.docker.nginx.local/logstash.docker.nginx.local.key```

To logstash output - Advanced YAML configuration add:

```
ssl.verification_mode: none
timeout: 20s
```

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
everything will be created by itself thanks to how the environment variables of the Fleet Service are set in
[docker-compose file](https://github.com/lhsradek/platypus-lhsdock/blob/main/compose/docker-fleet.yml).

See:
* https://github.com/lhsradek/platypus-lhsdock/blob/main/png/fleet01.png
* https://github.com/lhsradek/platypus-lhsdock/blob/main/png/fleet02.png
* https://github.com/lhsradek/platypus-lhsdock/blob/main/png/fleet03.png
* https://github.com/lhsradek/platypus-lhsdock/blob/main/png/fleet04.png

Restart and see how Fleet Server start and enroll.

-----

* https://www.facebook.com/radek.kadner/
* https://www.linkedin.com/in/radekkadner/
* mailto:radek.kadner@gmail.com
