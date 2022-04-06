.SILENT:

CON = bin/console

db-create:
	$(CON) doctrine:database:create --if-not-exists

db-migrate:
	$(CON) doctrine:migrations:migrate -n --allow-no-migration

db-reset:
	-$(CON) doctrine:database:drop --force --if-exists
	$(MAKE) db-create
	$(MAKE) db-migrate

fixtures-install:
	$(CON) doctrine:fixtures:load -n --append

clear:
	$(MAKE) db-reset
	$(MAKE) fixtures-install
	php -d memory_limit=-1 $(CON) cache:clear

test-unit:
	php bin/phpunit tests/Unit

test-api:
	$(MAKE) clear
	php bin/phpunit tests/Functional

test-static:
	php vendor/bin/phpstan analyse -l 3 src tests

test-psr:
	php tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run

psr:
	php tools/php-cs-fixer/vendor/bin/php-cs-fixer fix
