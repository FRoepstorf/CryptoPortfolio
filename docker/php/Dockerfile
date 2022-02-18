FROM bref/php-81-fpm as prod

COPY --from=bref/extra-mongodb-php-81 /opt /opt

COPY ./docker/php/intl.ini /opt/bref/etc/php/conf.d/intl.ini

COPY . $LAMBDA_TASK_ROOT

FROM bref/php-81-fpm-dev as dev

RUN yum install git -y

COPY --from=bref/extra-mongodb-php-81 /opt /opt
COPY --from=composer:latest /usr/bin/composer /opt/bin/composer

COPY ./docker/php/intl.ini /opt/bref/etc/php/conf.d/intl.ini