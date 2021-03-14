.PHONY: start
start:
	docker-compose up -d

.PHONY: stop
stop:
	docker-compose stop

.PHONY: docker-start
docker-start:
	sudo service docker start

.PHONY: composer-update
composer-update:
	docker-compose run --rm composer composer update