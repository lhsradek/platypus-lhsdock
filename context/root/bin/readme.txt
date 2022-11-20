### platypus-lhsdock

with Elasticsearch, Logstash and Kibana ([ELK](https://www.elastic.co/))

[![Docker Pulls](https://img.shields.io/docker/pulls/lhsradek/lhsdock)](https://hub.docker.com/repository/docker/lhsradek/lhsdock)

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

See:
* https://github.com/lhsradek/platypus-lhsdock/blob/main/png/fleet01.png
* https://github.com/lhsradek/platypus-lhsdock/blob/main/png/fleet02.png
* https://github.com/lhsradek/platypus-lhsdock/blob/main/png/fleet03.png
* https://github.com/lhsradek/platypus-lhsdock/blob/main/png/fleet04.png

-----

* https://www.facebook.com/radek.kadner/
* https://www.linkedin.com/in/radekkadner/
* mailto:radek.kadner@gmail.com
