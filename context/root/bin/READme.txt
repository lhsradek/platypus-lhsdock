
== Platypus-lhsdock ==

LISTEN 0.0.0.0:8443        0.0.0.0:*     users:("docker-proxy")                                       
LISTEN 0.0.0.0:443         0.0.0.0:*     users:("nginx") 
LISTEN 0.0.0.0:8080        0.0.0.0:*     users:("docker-proxy")                                       
LISTEN 0.0.0.0:80          0.0.0.0:*     users:("nginx") 


== DOCKER ==

Client:
 Context:    default
 Plugins:
  app: Docker App (Docker Inc., v0.9.1-beta3)
  buildx: Docker Buildx (Docker Inc., v0.8.2-docker)
  compose: Docker Compose (Docker Inc., v2.6.0)
  scan: Docker Scan (Docker Inc., v0.17.0)

Server:
 Containers: 4
  Running: 4
  Paused: 0
  Stopped: 0
 Images: 12
 Logging Driver: json-file
 Cgroup Version: 2
 Plugins:
  Volume: local
  Network: bridge host ipvlan macvlan null overlay
  Log: awslogs fluentd gcplogs gelf journald json-file local logentries splunk syslog
 Init Binary: docker-init
 OSType: linux
 CPUs: 2
 Name: docker
 Registry: https://index.docker.io/v1/
 Experimental: false
 Insecure Registries:
  127.0.0.0/8


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
 │   └── READme.txt
 ├── lhsvol
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

