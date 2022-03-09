.SILENT:

CON = bin/console

db-create:
	$(CON) doctrine:database:create --if-not-exists

db-migrate:
	$(CON) doctrine:migrations:migrate -n --allow-no-migration

db-reset:
	$(CON) doctrine:database:drop --force --if-exists
	$(MAKE) db-create
	$(MAKE) db-migrate

fixtures-install:
	$(CON) doctrine:fixtures:load -n --append

clear:
	$(MAKE) db-reset
	$(MAKE) fixtures-install
	php -d memory_limit=-1 $(CON) cache:clear
