FROM nginx:alpine
LABEL org.opencontainers.image.authors="radek.kadner@gmail.com"
LABEL description="lhsdock"
ADD --chown=55 /etc/ssl/openssl.cnf /etc/ssl
RUN apk add --update bash openssl perl-crypt-openssl-x509 mc
