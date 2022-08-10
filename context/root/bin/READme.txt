
== Platypus-lhsdock ==

== DOCKER ==

NETWORK:
NAME                         DRIVER    SCOPE
bridge                       bridge    local
host                         host      local
none                         null      local
platypus-local-dev-network   bridge    local

REPOSITORY   TAG       SIZE
lhsdock      v3        43.8MB
nginx        latest    142MB
alpine       latest    5.52MB
traefik      v2.6      102MB
REPOSITORY         TAG            SIZE
redis              7.0.4-alpine   28.5MB
postgres           13.7-alpine    213MB
nginx              alpine         23.5MB
lhsradek/lhsdock   v3             43.8MB
phpmyadmin         fpm-alpine     128MB
tomcat             9.0            475MB
mariadb            latest         383MB
wordpress          fpm-alpine     299MB
traefik            v2.6           102MB

IMAGE          COMMAND                  NAMES
nginx          "/docker-entrypoint.…"   static-nginx-01-webserver
nginx          "/docker-entrypoint.…"   php-nginx-02-webserver
traefik:v2.6   "/entrypoint.sh trae…"   platypus-box_traefik_1
lhsdock:v3     "sh"                     platypus-lhsdock

REPOSITORY         TAG            SIZE
lhsradek/lhsdock   v3             43.8MB
mariadb            latest         383MB
nginx              alpine         23.5MB
postgres           13.7-alpine    213MB
phpmyadmin         fpm-alpine     128MB
redis              7.0.4-alpine   28.5MB
tomcat             9.0            475MB
traefik            v2.6           102MB
wordpress          fpm-alpine     299MB

IMAGE                COMMAND                  PORTS                                        NAMES
nginx:alpine         "/docker-entrypoint.…"   80/tcp                                       wordpress-01-webserver
wordpress:fpm-alpine "docker-entrypoint.s…"   9000/tcp                                     wordpress-01-php
e46bcc697531         "/docker-entrypoint.…"   80/tcp                                       phpmyadmin-01-webserver
phpmyadmin:fpm-alpine"/docker-entrypoint.…"   9000/tcp                                     phpmyadmin-01-php
lhsradek/lhsdock:v3  "/bin/sh -c 'exec /r…"                                                platypus-lhsdock
tomcat:9.0           "catalina.sh run"        8080/tcp                                     tomcat-01-webserver
mariadb              "docker-entrypoint.s…"   0.0.0.0:3306->3306/tcp                       mysql-01-db
redis:7.0.4-alpine   "docker-entrypoint.s…"   0.0.0.0:6379->6379/tcp                       redis-01-db
postgres:13.7-alpine "docker-entrypoint.s…"   0.0.0.0:5432->5432/tcp                       postgres-01-db
traefik:v2.6         "/entrypoint.sh trae…"   0.0.0.0:8080->8080/tcp0.0.0.0:8443->8443/tcp platypus-box_traefik_1

VOLUME:
DRIVER    VOLUME NAME
local     mysql-01
local     phpmyadmin-01
local     postgres-01
local     redis-01
local     wordpress-01

LISTEN 0.0.0.0:8443        0.0.0.0:*     users:("docker-proxy")                                       
LISTEN 0.0.0.0:443         0.0.0.0:*     users:("nginx") 
LISTEN 0.0.0.0:8080        0.0.0.0:*     users:("docker-proxy")                                       
LISTEN 0.0.0.0:80          0.0.0.0:*     users:("nginx") 


Volume local_lhsdock is for static-nginx-01-webserver:/var/www/html

 ├── index.html
 ├── page2.html
 └── projekt1
    ├── index.html
    ├── lhsdock     <------ here is local_lhsdock
    │   ├── Dockerfile.txt
    │   └── READme.txt
    ├── nginx-logo.png
    └── style.css


platypus-lhsdock:/root/bin/

 ├── READme.txt
 ├── demoCA
 │   ├── cacert.pem
 │   ├── crl
 │   ├── index.txt
 │   ├── index.txt.attr
 │   ├── index.txt.attr.old
 │   ├── index.txt.old
 │   ├── newcerts
 │   │   ├── 01.pem
 │   │   ├── 02.pem
 │   │   ├── 03.pem
 │ ..
 │   │   ├── 0D.pem
 │   │   ├── 0E.pem
 │   │   └── 0F.pem
 │   ├── private
 │   │   └── cakey.pem
 │   ├── serial
 │   └── serial.old
 ├── lhsdock     <------ here is local_lhsdock
 │   ├── Dockerfile.txt
 │   ├── READme.txt
 │   └── certs
 ├── openssl
 │   ├── docker.intranet.local-key.pem
 │   ├── docker.intranet.local.pem
 │   ├── docker.traefik.local-key.pem
 │   ├── docker.traefik.local.pem
 │ ..
 │   ├── www.alma.local-key.pem
 │   ├── www.alma.local.pem
 │   ├── www.traefik.local-key.pem
 │   └── www.traefik.local.pem
 └── platypus.pl

To run use:

/ # perl /root/bin/platypus.pl;

== Certification authority ==
subject: C=CZ, ST=Czech Republic, L=Klasterec nad Ohri, O=lhs, OU=intranet.local, CN=Certification authority, emailAddress=radek.kadner@gmail.com
issuer: C=CZ, ST=Czech Republic, L=Klasterec nad Ohri, O=lhs, OU=intranet.local, CN=Certification authority, emailAddress=radek.kadner@gmail.com
notBefore: Jul 30 17:41:44 2022 GMT
notAfter: Jul 31 17:41:44 2023 GMT
== virtual:'lhs.intranet.local', o:'lhs', ou:'intranet.local', cn:'lhs.intranet.local', cert:true ==
subject: C=CZ, ST=Czech Republic, L=Klasterec nad Ohri, O=lhs, OU=intranet.local, CN=lhs.intranet.local, emailAddress=radek.kadner@gmail.com
notBefore: Jul 30 17:41:44 2022 GMT
notAfter: Jul 30 17:41:44 2023 GMT

.......

== virtual:'www.traefik.local', o:'www', ou:'traefik.local', cn:'www.traefik.local', cert:true ==
subject: C=CZ, ST=Czech Republic, L=Klasterec nad Ohri, O=www, OU=traefik.local, CN=www.traefik.local, emailAddress=radek.kadner@gmail.com
notBefore: Jul 30 17:42:08 2022 GMT
notAfter: Jul 30 17:42:08 2023 GMT

