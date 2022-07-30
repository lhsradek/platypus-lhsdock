
### Platypus-lhsdock

| REPOSITORY  |  TAG      | SIZE 
| ----------- | --------- | ----
| lhsdock     | v3        | 43.8MB
| nginx       | latest    | 142MB
| alpine      | latest    | 5.52MB
| traefik     | v2.6      | 102MB

| IMAGE        | COMMAND   | NAMES
| ------------ | --------- | ------
| nginx        | /docker-entrypoint.… | static-nginx-01-webserver
| traefik:v2.6 | /entrypoint.sh trae… | platypus-box_traefik_1
| lhsdock:v3   | sh                   | platypus-lhsdock

| DRIVER    | VOLUME NAME
| --------- | -----------
| local     | lhsdock

Volume local_lhsdock is for static-nginx-01-webserver:/var/www/html/projekt1/lhsdock

To run use:

/ # perl /root/bin/platypus.pl;
