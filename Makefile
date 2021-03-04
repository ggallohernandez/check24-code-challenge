# define root project dir
ROOT_DIR:=$(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))
-include ${ROOT_DIR}/.env

build:
	@docker-compose run app bash -c "composer install; composer dump; vendor/bin/doctrine orm:schema-tool:update --force"

certs:
	@echo "Run 'brew install mkcert nss' if it's not already installed"
	@mkcert -install
	@mkcert -cert-file .docker/nginx.dev/site.crt -key-file .docker/nginx.dev/site.key '*.local.services' localhost 127.0.0.1

ps:
	@docker-compose ps

restart: down up

up:
	@docker-compose up -d

stop:
	@docker-compose stop

down:
	@docker-compose down

pull:
	@docker-compose pull

test:
	@docker-compose exec app bash -c "php vendor/bin/paratest --configuration phpunit.xml --runner WrapperRunner \
	    --testsuite=unit; php -dxdebug.client_host=host.docker.internal -dxdebug.client_port=9000 -dxdebug.start_with_request=true vendor/bin/phpspec run"

ask:
	@echo "Are you sure? [y/N]" && read ans && [ $${ans:-N} = y ]

clean: ask down
	@rm -rf .local_data
	@make up
