FROM alpine:latest
LABEL org.opencontainers.image.authors="radek.kadner@gmail.com"
LABEL description="platypus-lhsdock"
ENV APP_ID=platypus-lhsdock
ENV APP_HOST=platypus-lhsdock.localhost
ENV DOCKER_VOLUME=lhsdock
ADD --chown=55 /etc/ssl/openssl.cnf /etc/ssl
ADD --chown=55 /root/bin/* /root/bin/
RUN apk add --update openssl perl-crypt-openssl-x509
