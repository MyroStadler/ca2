-include .env

NO_COLOR=$(shell tput sgr0 -T xterm)
RED=$(shell tput bold -T xterm)$(shell tput setaf 1 -T xterm)
GREEN=$(shell tput bold -T xterm)$(shell tput setaf 2 -T xterm)
YELLOW=$(shell tput bold -T xterm)$(shell tput setaf 3 -T xterm)
BLUE=$(shell tput bold -T xterm)$(shell tput setaf 4 -T xterm)

GIT_BRANCH=$(shell git rev-parse --abbrev-ref HEAD)

.PHONY: all
all:
	@make header --no-print-directory
	@make install --no-print-directory

.PHONY: verify
verify:
	@echo '${BLUE}* Verifying${NO_COLOR}'
	@test -f ./.env || (echo ${RED}Please create .env from .env.dist${NO_COLOUR}; exit 1)
	@test -f ./phpunit.xml || (echo ${RED}Please create phpunit.xml from phpunit.xml.dist${NO_COLOUR}; exit 1)
	@echo '${GREEN}OK${GREEN}'

.PHONY: install
install:
	@make verify --no-print-directory
	@echo '${BLUE}* Stopping docker containers${NO_COLOR}'
	@docker-compose down
	@echo '${BLUE}* Building docker containers${NO_COLOR}'
	@docker-compose up -d --force-recreate --remove-orphans
	@echo '${BLUE}* Composer install${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "composer install --no-scripts --prefer-dist --quiet"
	@echo '${BLUE}* Dumping autoload${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "composer dump-autoload --no-scripts --quiet"
	@echo '${BLUE}* Yarn install${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "yarn install"
	@make assets --no-print-directory
# 	@echo '${BLUE}* Migrate database${NO_COLOR}'
# 	@docker-compose exec -T ca2-php-cli sh -c "./bin/console doctrine:migrations:migrate -n"
# 	@echo '${BLUE}* Load fixtures${NO_COLOR}'
# 	@docker-compose exec -T ca2-php-cli sh -c "./bin/console doctrine:fixtures:load -n"

.PHONY: test
test:
	@make verify --no-print-directory
	@echo '${BLUE}* Running PHPUnit Tests${NO_COLOR}'
	@docker-compose exec -T ca2-php-cli sh -c "./vendor/bin/phpunit tests"

.PHONY: assets
assets:
	@echo '${BLUE}* SASS build${NO_COLOR}'
	@docker-compose exec -T --user $$(id -u ${USER}):$$(id -g ${USER}) ca2-php-cli sh -c "yarn sass assets/sass/main.scss public/css/main.css"

.PHONY: header
header:
	@echo "$$(cat header.txt | sed "s/.*/${YELLOW}&${NO_COLOR}/")"

