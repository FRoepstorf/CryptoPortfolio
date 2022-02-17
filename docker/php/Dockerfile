FROM bref/php-81-fpm as prod

COPY . /var/task

# Configure the handler file (the entrypoint that receives all HTTP requests)
CMD ["public/index.php"]

FROM bref/php-81-fpm-dev as dev

COPY --from=composer:latest /usr/bin/composer /opt/bin/composer

RUN yum install git -y

CMD ["public/index.php"]