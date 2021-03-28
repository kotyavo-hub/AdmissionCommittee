FROM php:7.4-fpm-alpine

RUN echo 'nameserver 8.8.8.8' >> /etc/resolv.conf
RUN sed -i 's/dl-cdn/nl/' /etc/apk/repositories
RUN echo -e "https://alpine.global.ssl.fastly.net/alpine/v3.11/main\nhttps://alpine.global.ssl.fastly.net/alpine/v3.11/community\n" > /etc/apk/repositories

RUN apk update; \
    apk upgrade;

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Install bash
RUN apk add --update bash && rm -rf /var/cache/apk/*