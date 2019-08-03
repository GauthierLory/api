up:
	@docker-compose up -d nginx

stop:
	@docker-compose stop

shell:
	@docker-compose exec php sh

asset:
	@docker-compose run node yarn encore dev