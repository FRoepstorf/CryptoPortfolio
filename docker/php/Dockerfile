FROM bref/php-81-fpm as prod

COPY . $LAMBDA_TASK_ROOT

FROM bref/php-81-fpm-dev as dev

COPY --from=composer:latest /usr/bin/composer /opt/bin/composer

RUN yum install git -y