FROM alpine:latest
LABEL org.opencontainers.image.authors="radek.kadner@gmail.com"
LABEL description="platypus-lhsdock"
ENV DOCKER_VOLUME=lhsdock
ENV APP_ID=static-lhsdock-01
ENV APP_HOST=static-lhsdock-01.localhost
ADD --chown=55 /etc/ssl/openssl.cnf /etc/ssl
ADD --chown=55 /root/bin/* /root/bin/
RUN apk add --update openssl perl-crypt-openssl-x509
