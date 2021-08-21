up:
	- docker-compose up -d

build:
	- docker-compose build
	- docker-compose up -d

import:
	- docker-compose build
	- docker-compose up -d
	- docker exec productsapp php bin/console import $(INPUT) $(OUTPUT)
