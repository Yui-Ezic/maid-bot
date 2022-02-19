init: docker-down-clear \
	docker-pull docker-build docker-up \
	bot-clear bot-init
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

check: lint test analyze
test: bot-test
lint: bot-lint
analyze: bot-analyze
cs-fix: bot-cs-fix

bot-clear:
	docker run --rm -v ${PWD}/api:/app -w /app alpine sh -c 'rm -rf var/cache/*'

bot-init: bot-composer-install

bot-composer-install:
	docker-compose run --rm bot-php-cli composer install

bot-test:
	docker-compose run --rm bot-php-cli composer test

bot-lint:
	docker-compose run --rm bot-php-cli composer lint
	docker-compose run --rm bot-php-cli composer php-cs-fixer fix -- --dry-run --diff

bot-analyze:
	docker-compose run --rm bot-php-cli composer psalm
bot-cs-fix:
	docker-compose run --rm bot-php-cli composer php-cs-fixer fix

build:
	docker --log-level=debug build --pull --file=bot/docker/production/php-fpm/Dockerfile -t ${_REGION}/${PROJECT_ID}/${_DOCKER_REGISTRY}/${_DOCKER_IMAGENAME}:${SHORT_SHA} bot
