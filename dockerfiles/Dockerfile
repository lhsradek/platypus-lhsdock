FROM alpine:latest
LABEL org.opencontainers.image.authors="radek.kadner@gmail.com"
LABEL description="platypus-lhsdock"
ENV DOCKER_VOLUME=lhsdock
ENV APP_ID=lhsdock
ENV APP_HOST=lhsdock.localhost
ADD --chown=55 /etc/ssl/openssl.cnf /etc/ssl
ADD --chown=55 /root/bin/* /root/bin/
RUN apk add --update openssl perl-crypt-openssl-x509
