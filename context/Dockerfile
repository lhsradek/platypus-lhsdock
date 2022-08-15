FROM nginx:alpine
LABEL org.opencontainers.image.authors="radek.kadner@gmail.com"
LABEL description="lhsdock"
ADD --chown=55 /etc/ssl/openssl.cnf /etc/ssl
EXPOSE 80 443
RUN apk add --update bash openssl
