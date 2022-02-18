FROM bref/php-81-fpm as prod

COPY --from=bref/extra-mongodb-php-81 /opt /opt

COPY . $LAMBDA_TASK_ROOT

FROM bref/php-81-fpm-dev as dev

COPY --from=bref/extra-mongodb-php-81 /opt /opt
COPY --from=composer:latest /usr/bin/composer /opt/bin/composer

RUN yum install git -y