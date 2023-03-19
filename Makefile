docker-compose = docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env
docker-run = $(docker-compose) run --rm
php-cli = $(docker-run) php-cli

bash:
	$(php-cli) bash

up:
	$(docker-compose) up --build -d
