### platypus-lhsdock

https://github.com/elliason/platypus-box

https://github.com/elliason/platypus-template-static-nginx

https://github.com/lhsradek/platypus-template-php-nginx

#### Setup

1) The first make image docker ```./bin/create.bash```

2) Load docker ```./bin/create.bash```

3) docker ```./bin/stop.bash```
   or 
   docker ```./bin/restart.bash```

4) exec docker ```./bin/start.bash```

5) docker ```./bin/ls.bash```

6) docker ```./bin/prune.bash```

7) To run use:

```/ # perl /root/bin/platypus.pl```

``` # ls /root/bin```

```READme.txt   add.sh       lhsdock      lhsvol       platypus.pl```


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
