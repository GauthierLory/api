up:
	@docker-compose up -d nginx

stop:
	@docker-compose stop

shell:
	@docker-compose exec php sh