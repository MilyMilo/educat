FROM php:7-cli-alpine

RUN docker-php-ext-install pdo pdo_mysql

COPY ./src /usr/src/code
WORKDIR /usr/src/code

ENTRYPOINT ["php", "-S", "0.0.0.0:80"]
