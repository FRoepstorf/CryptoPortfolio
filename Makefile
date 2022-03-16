DOCKER_COMPOSE_RUN_XDEBUG_OFF=docker-compose run --rm -e XDEBUG_MODE=off

up: vendor
	docker-compose up -d

stop:
	docker-compose stop

vendor: composer.json composer.lock
	$(DOCKER_COMPOSE_RUN_XDEBUG_OFF) php composer install

shell:
	$(DOCKER_COMPOSE_RUN_XDEBUG_OFF) php bash

psalm:
	$(DOCKER_COMPOSE_RUN_XDEBUG_OFF) php ./vendor/bin/psalm

test: vendor
	$(DOCKER_COMPOSE_RUN_XDEBUG_OFF) -e XDEBUG_MODE=off php vendor/bin/phpunit --testsuite unit

coverage: vendor
	docker-compose run --rm -e XDEBUG_MODE=coverage php vendor/bin/phpunit --testsuite all --coverage-html var/coverage

logs:
	docker-compose logs -f php

seed:
	$(DOCKER_COMPOSE_RUN_XDEBUG_OFF) php php ./bin/seed.php

rector:
	$(DOCKER_COMPOSE_RUN_XDEBUG_OFF) php ./vendor/bin/rector process src tests

csfix:
	$(DOCKER_COMPOSE_RUN_XDEBUG_OFF) php ./vendor/bin/ecs check src tests --fix

precommit: vendor rector csfix psalm test