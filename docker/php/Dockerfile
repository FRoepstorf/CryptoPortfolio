FROM bref/php-81-fpm as prod

COPY . /var/task

# Configure the handler file (the entrypoint that receives all HTTP requests)
CMD ["public/index.php"]

FROM bref/php-81-fpm-dev as dev

CMD ["public/index.php"]