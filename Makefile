up:
	docker-compose up -d

stop:
	docker-compose stop

shell:
	docker-compose run --rm php bash

psalm:
	docker-compose run --rm php ./vendor/bin/psalm