# Platypus-lhsdock
== Platypus-lhsdock ==

NETWORK:
NAME                         DRIVER    SCOPE
bridge                       bridge    local
host                         host      local
lhsdock-local-dev-network    bridge    local
none                         null      local
platypus-local-dev-network   bridge    local

REPOSITORY   TAG       SIZE
lhsdock      v3        43.8MB
nginx        latest    142MB
alpine       latest    5.52MB
traefik      v2.6      102MB

IMAGE          COMMAND                  NAMES
nginx          "/docker-entrypoint.…"   static-nginx-01-webserver
traefik:v2.6   "/entrypoint.sh trae…"   platypus-box_traefik_1
lhsdock:v3     "sh"                     platypus-lhsdock

VOLUME:
DRIVER    VOLUME NAME
local     lhsdock

Volume local_lhsdock is for static-nginx-01-webserver:/var/www/html/projekt1/lhsdock

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
