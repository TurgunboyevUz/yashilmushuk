# Default Makefile for Laravel Project

# Variables
PHP := php
COMPOSER := composer
ARTISAN := $(PHP) artisan
NPM := npm

# Default target
.PHONY: help
help:
	@echo "Available commands:"
	@echo "  make install      - Install PHP and JS dependencies"
	@echo "  make migrate      - Run database migrations"
	@echo "  make seed         - Seed the database"
	@echo "  make serve        - Start Laravel development server"
	@echo "  make queue        - Start Laravel queue worker"
	@echo "  make cache-clear  - Clear Laravel cache"
	@echo "  make test         - Run PHPUnit tests"

.PHONY: install
install:
	$(COMPOSER) install --no-interaction --prefer-dist
	$(NPM) install
	$(NPM) run build

.PHONY: migrate
migrate:
	$(ARTISAN) migrate --force

.PHONY: fresh
fresh:
	$(ARTISAN) migrate:fresh --seed

.PHONY: seed
seed:
	$(ARTISAN) db:seed --force

.PHONY: serve
serve:
	$(ARTISAN) serve

.PHONY: queue
queue:
	$(ARTISAN) queue:work --tries=3

.PHONY: cache-clear
cache-clear:
	$(ARTISAN) cache:clear
	$(ARTISAN) config:clear
	$(ARTISAN) route:clear
	$(ARTISAN) view:clear

.PHONY: test
test:
	$(PHP) vendor/bin/phpunit