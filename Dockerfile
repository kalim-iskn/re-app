FROM php:8.1.5-fpm-alpine3.14

USER root

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql;

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    composer -V

RUN echo https://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add shadow

RUN apk add --no-cache bash && \
    curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash && \
    apk add symfony-cli && \
    symfony check:requirements;

RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
RUN sed -i 's/memory_limit = 128M/memory_limit = 256M/' $PHP_INI_DIR/php.ini
RUN sed -i 's/post_max_size = 8M/post_max_size = 200M/' $PHP_INI_DIR/php.ini
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 200M/' $PHP_INI_DIR/php.ini
RUN sed -i 's/max_execution_time = 30/max_execution_time = 120/' $PHP_INI_DIR/php.ini

RUN usermod -u 1000 www-data && \
    groupmod -g 1000 www-data

USER www-data

WORKDIR /opt/app

CMD composer install && \
    php-fpm
