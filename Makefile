NO_COLOR=$(shell tput sgr0 -T xterm)
RED=$(shell tput bold -T xterm)$(shell tput setaf 1 -T xterm)
GREEN=$(shell tput bold -T xterm)$(shell tput setaf 2 -T xterm)
YELLOW=$(shell tput bold -T xterm)$(shell tput setaf 3 -T xterm)
BLUE=$(shell tput bold -T xterm)$(shell tput setaf 4 -T xterm)

GIT_BRANCH=$(shell git rev-parse --abbrev-ref HEAD)

# ENV_FILE Usage: make db_reset_test ENV_FILE=".env.test"
ifndef ENV_FILE
 override ENV_FILE = .env
else
 ifeq ("$(wildcard ${ENV_FILE})","")
  $(error ${RED}Could not find env file ${ENV_FILE} as specified with ENV_FILE${NO_COLOUR})
 endif
endif

-include ${ENV_FILE}

.PHONY: all
all:
	@make header --no-print-directory
	@make install --no-print-directory

.PHONY: header
header:
	@echo "$$(cat header.txt | sed "s/.*/${YELLOW}&${NO_COLOR}/")"

.PHONY: verify
verify:
	@echo '${BLUE}* Verifying${NO_COLOR}'
	@(test -f ./.env \
		&& test -f ./.env.test \
		&& test -f ./phpunit.xml \
		&& test -f ./docker-compose.override.yml) \
		|| (echo ${RED}Please create the following files from their .example equivalents and fill in any missing detail: .env, .env.test, phpunit.xml, docker-compose.override.yml${NO_COLOUR}; exit 1)
	@echo '${GREEN}OK${GREEN}'

.PHONY: install
install:
	@make verify --no-print-directory
	@make down --no-print-directory
	@make up --no-print-directory
	@make composer_install --no-print-directory
	@make composer_autoload --no-print-directory
	@make yarn_install --no-print-directory
	@make frontend --no-print-directory

.PHONY: down
down:
	@echo '${BLUE}* Stopping docker containers${NO_COLOR}'
	@docker-compose down

.PHONY: up
up:
	@echo '${BLUE}* Building docker containers${NO_COLOR}'
	@docker-compose up -d --force-recreate --remove-orphans

.PHONY: composer_install
composer_install:
	@echo '${BLUE}* Composer install${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "composer install --no-scripts --prefer-dist --quiet"

.PHONY: composer_update
composer_update:
	@echo '${BLUE}* Composer update{NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "composer update --no-scripts --prefer-dist --quiet"

.PHONY: composer_autoload
composer_autoload:
	@echo '${BLUE}* Dumping autoload${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "composer dump-autoload --no-scripts --quiet"

.PHONY: yarn_install
yarn_install:
	@echo '${BLUE}* Yarn install${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "yarn install"

.PHONY: db_migrations
db_migrations:
	@echo '${BLUE}Migrating database${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "./vendor/bin/doctrine-migrations migrations:migrate --no-interaction"

.PHONY: db_migrations_test
db_migrations_test:
	@echo '${BLUE}Migrating test database${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "./vendor/bin/doctrine-migrations migrations:migrate --no-interaction --db-configuration './migrations-db-test.php'"

.PHONY: db_fixtures
db_fixtures:
	@echo '${BLUE}Creating fixtures${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "php ./fixtures.php"

.PHONY: db_fixtures_test
db_fixtures_test:
	@echo '${BLUE}Creating test fixtures${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "php ./fixtures-test.php"

.PHONY: db_reset
db_reset:
	@echo "APP_ENV is ${APP_ENV}"
ifneq (${APP_ENV}, dev)
	$(error ${RED}Do not run unless in the dev environment${NO_COLOUR})
endif
	@echo '${BLUE}Rebuilding database${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) mysql sh -c "mysql -u root -p${DB_ROOT_PASSWORD} -e 'DROP DATABASE IF EXISTS ${DB_NAME};'"
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) mysql sh -c "mysql -u root -p${DB_ROOT_PASSWORD} -e 'CREATE DATABASE ${DB_NAME};'"
	@make db_migrations --no-print-directory
	@make db_fixtures --no-print-directory

.PHONY: db_reset_test
db_reset_test:
	@echo "APP_ENV is ${APP_ENV}"
ifneq (${APP_ENV}, test)
	$(error ${RED}Do not run unless in the test environment. You can switch to the test environment by appending ENV_FILE='.env.test' to the command that called this make target${NO_COLOUR})
endif
	@echo '${BLUE}Rebuilding test database${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) mysql sh -c "mysql -u root -p${DB_ROOT_PASSWORD} -e 'DROP DATABASE IF EXISTS ${DB_NAME};'"
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) mysql sh -c "mysql -u root -p${DB_ROOT_PASSWORD} -e 'CREATE DATABASE ${DB_NAME};'"
	@make db_migrations_test --no-print-directory
	@make db_fixtures_test --no-print-directory

.PHONY: frontend
frontend:
	@echo '${BLUE}* SASS build${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "yarn sass frontend/sass/main.scss public/css/main.css"

.PHONY: test
test:
	@make verify --no-print-directory
	@echo '${BLUE}* Running PHPUnit Tests${NO_COLOR}'
	@docker-compose exec -T ca2-php-cli sh -c "./vendor/bin/phpunit tests"