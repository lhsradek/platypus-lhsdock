
### platypus-lhsdock

#### Setup

1) The first create docker ```./bin/create.bash```
2) The second exec docker ```./bin/start.bash```
3) docker ```./bin/stop.bash```
   or 
   docker ```./bin/restart.bash```

4) docker ```./bin/ls.bash```
5) docker ```./bin/prune.bash```

6) To run use:

```/ # perl /root/bin/platypus.pl```

``` # ls ~/bin/```

```READme.txt   add.sh       lhsvol       platypus.pl```


#### platypus images:


| REPOSITORY  |  TAG      | SIZE 
| ----------- | --------- | ----
| lhsdock     | v3        | 43.8MB
| nginx       | latest    | 142MB
| alpine      | latest    | 5.52MB
| traefik     | v2.6      | 102MB

| IMAGE        | COMMAND   | NAMES
| ------------ | --------- | ------
| nginx        | /docker-entrypoint.… | static-nginx-01-webserver
| nginx        | /docker-entrypoint.… | php-nginx-02-webserver
| traefik:v2.6 | /entrypoint.sh trae… | platypus-box_traefik_1
| lhsdock:v3   | sh                   | platypus-lhsdock

| DRIVER    | VOLUME NAME
| --------- | -----------
| local     | lhsdock

Volume local_lhsdock is for static-nginx-01-webserver:/var/www/html/projekt1/lhsdock for

https://github.com/elliason/platypus-template-static-nginx
