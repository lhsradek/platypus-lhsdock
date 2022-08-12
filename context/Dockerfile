FROM nginx:alpine
LABEL maintainer="lhs radek.kadner@gmail.com"
LABEL description="lhsdock"
ADD --chown=55 /etc/ssl/openssl.cnf /etc/ssl
RUN apk add --update bash openssl perl-crypt-openssl-x509
