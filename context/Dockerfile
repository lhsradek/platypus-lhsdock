FROM alpine:latest
LABEL org.opencontainers.image.authors="radek.kadner@gmail.com"
LABEL maintainer="lhs radek.kadner@gmail.com"
LABEL description="platypus-lhsdock"
ENV APP_ID=platypus-lhsdock
ENV APP_HOST=platypus-lhsdock.localhost
ADD --chown=55 /etc/ssl/openssl.cnf /etc/ssl
RUN apk add --update openssl perl-crypt-openssl-x509 openssh
RUN echo 'PasswordAuthentication yes' >> /etc/ssh/sshd_config
RUN adduser -h /home/lhs -s /bin/sh -D lhs
RUN echo -n 'lhs:some_password_here' | chpasswd
ENTRYPOINT ["/entrypoint.sh"]
EXPOSE 22
COPY entrypoint.sh /
