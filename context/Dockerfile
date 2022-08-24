FROM nginx:alpine
LABEL org.opencontainers.image.authors="radek.kadner@gmail.com"
LABEL description="lhsdock"
RUN mkdir /root/bin /root/bin/alpine
ADD --chown=44 /etc/ssl/openssl.cnf /etc/ssl
ADD --chown=44 /root/bin/readme.txt /root/bin
ADD --chown=55 /root/bin/platypus.pl /root/bin
ADD --chown=55 /root/bin/alpine/add.sh /root/bin/alpine
ADD --chown=55 /root/bin/alpine/timezone.sh /root/bin/alpine
EXPOSE 80 443
RUN apk add --update bash acme-client openssl perl-crypt-openssl-x509
