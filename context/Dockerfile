FROM nginx:alpine
LABEL maintainer="lhs radek.kadner@gmail.com"
LABEL description="lhsdock-platypus"
LABEL traefik.enable=true
LABEL traefik.docker.network=platypus-local-dev-network
LABEL traefik.http.routers.nginx.local-public.rule=Host(`lhs.nginx.local`)
LABEL traefik.http.routers.nginx.local-public.entrypoints=https
LABEL traefik.http.routers.nginx.local-public.tls=true
ENV APP_ID=lhsdock-01
ENV APP_HOST=lhs.nginx.local
ENV DOCKER_NETWORK=platypus-local-dev-network
ENV NGINX_HOST=lhs.nginx.local
ENV NGINX_PORT=80
ADD --chown=55 /.dockerenv /
ADD --chown=55 /etc/ssl/openssl.cnf /etc/ssl
ADD --chown=22 /docker-entrypoint.sh /
ADD --chown=22 /docker-entrypoint.d/10-listen-on-ipv6-by-default.sh /docker-entrypoint.d
RUN apk add --update openssl perl-crypt-openssl-x509
