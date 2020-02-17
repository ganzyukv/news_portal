.DEFAULT_GOAL := help
.PHONY: help build migrate
help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[%a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

docker_file=./.docker/docker-compose.yaml

APP_CONTAINER=php-fpm
MYSQL_CONTAINER=mysql
NGINX_CONTAINER=nginx

up: ## Start all containers (in background) for development
	docker-compose -f ${docker_file} up -d

down: ## Stop all started for development containers
	docker-compose -f ${docker_file} down -v --remove-orphans

restart: ## Restart all started for development containers
	docker-compose -f ${docker_file} restart

build: ## Build all containers
	docker-compose -f ${docker_file} rm -vsf
	docker-compose -f ${docker_file} down -v --remove-orphans
	docker-compose -f ${docker_file} build

fixtures: ## Loads fixtures to database.
	docker-compose exec ${APP_CONTAINER} ./bin/console doctrine:fixtures:load

migrate: ## Runs application migrations.
	docker-compose exec ${APP_CONTAINER} ./bin/console doctrine:migrations:migrate

jumpin: ## Start shell into application container
	docker-compose -f ${docker_file} exec ${APP_CONTAINER} /bin/bash

make_migration: ## Runs application migrations.
	docker-compose exec ${APP_CONTAINER} ./bin/console make:migration

tail-logs: ## Display all logs from containers
	docker-compose -f ${docker_file} logs -f ${APP_CONTAINER}