up:
	- docker-compose up -d

build:
	- docker-compose build
	- docker-compose up -d

import:
	- cp $(INPUT) .tmp
	- docker exec productsapp php bin/console import .tmp $(OUTPUT)
	- rm -rf .tmp

coverage:
	- docker exec -e=XDEBUG_MODE=coverage  productsapp phpunit --coverage-html coverage_report