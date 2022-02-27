up:
	docker-compose up -d

stop:
	docker-compose stop

shell:
	docker-compose run --rm php bash

psalm:
	docker-compose run --rm php ./vendor/bin/psalm

test:
	docker-compose run --rm -e XDEBUG_MODE=off php vendor/bin/phpunit --testsuite unit

coverage:
	docker-compose run --rm -e XDEBUG_MODE=coverage php vendor/bin/phpunit --testsuite all --coverage-html var/coverage

logs:
	docker-compose logs -f php

seed:
	docker-compose run --rm php php ./bin/seed.php

rector:
	docker-compose run --rm php -e XDEBUG_MODE=off ./vendor/bin/rector process src tests

csfix:
	docker-compose run --rm php ./vendor/bin/ecs check src tests --fix

precommit: rector csfix psalm test
