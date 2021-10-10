init: docker-down-clear \
	docker-pull docker-build docker-up \
	bot-init
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

test: bot-tests

bot-init: bot-composer-install

bot-composer-install:
	docker-compose run --rm bot-php-cli composer install

bot-tests:
	docker-compose run --rm bot-php-cli composer test