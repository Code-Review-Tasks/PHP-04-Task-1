
composeDev = -f docker-compose.yml --env-file .env
userAndAppInDocker = -u $(WWWUSER) $(APP_CONTAINER_NAME)
userId = $(WWWUSER)
groupId = $(WWWGROUP)

-include .env

first-install: install-sail build-no-cache up composer-install npm-install npm-run-dev migrate run-seed

install-sail:
	@docker run --rm --interactive --tty --volume $(PWD):/app --user $(userId):$(groupId) composer:2.1.11 composer require --dev laravel/sail

build:
	@docker-compose $(composeDev) build

build-no-cache:
	@docker-compose $(composeDev) build --no-cache

up:
	@docker-compose $(composeDev) up -d

down:
	@docker-compose $(composeDev) down --remove-orphans

restart: down up

exec:
	@docker exec -it $(userAndAppInDocker) bash

composer-install:
	@docker exec -it $(userAndAppInDocker) composer install

migrate:
	@docker exec -it $(userAndAppInDocker) php artisan migrate

cache-clear:
	@docker exec -it $(userAndAppInDocker) php artisan cache:clear
	@docker exec -it $(userAndAppInDocker) php artisan config:clear
	@docker exec -it $(userAndAppInDocker) php artisan route:clear
	@docker exec -it $(userAndAppInDocker) php artisan view:clear

npm-install:
	@docker exec -it $(userAndAppInDocker) npm install

npm-run-dev:
	@docker exec -it $(userAndAppInDocker) npm run dev

npm-run-build:
	@docker exec -it $(userAndAppInDocker) npm run prod

run-seed:
	@docker exec -it $(userAndAppInDocker) php artisan db:seed

fix:
	@docker exec -it $(userAndAppInDocker) php vendor/bin/php-cs-fixer fix --allow-risky=yes

fix-check:
	@docker exec -it $(userAndAppInDocker) php vendor/bin/php-cs-fixer fix --dry-run --verbose --allow-risky=yes

fix-check-quiet:
	@docker exec -i $(userAndAppInDocker) php vendor/bin/php-cs-fixer fix --dry-run --quiet --allow-risky=yes

test:
	@docker exec -i $(userAndAppInDocker) php artisan test

route-list:
	@docker exec -i $(userAndAppInDocker) php artisan route:list
