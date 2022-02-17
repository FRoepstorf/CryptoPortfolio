FROM bref/php-81-fpm as prod

COPY . /var/task

FROM bref/php-81-fpm-dev as dev

COPY --from=composer:latest /usr/bin/composer /opt/bin/composer

RUN yum install git -y