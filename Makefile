up:
	docker-compose up -d

stop:
	docker-compose stop

shell:
	docker-compose run --rm php bash

psalm:
	docker-compose run --rm php ./vendor/bin/psalm

test:
	docker-compose run --rm -e XDEBUG_MODE=off php vendor/bin/phpunit --testsuite all

coverage:
	docker-compose run --rm -e XDEBUG_MODE=coverage php vendor/bin/phpunit --testsuite all