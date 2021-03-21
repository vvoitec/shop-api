# shop-api
## Requirements
- Docker
- Composer
## Project set-up
In project's root directory:\
`> composer install`\
`> docker-compose up`

shop-api comes with swagger-ui, with project running visit
`localhost:8000/api-docs/`
to test the api.\
In `.env` file you can find symfony enviroment variables with database conneciton string. \
And in `docker-compose.yaml` there a is docker configuration.
## About
This project is an attempt of _DDD CQRS_ architecture. \
It uses _PHP 8_, _mySQL 8.0_ for data storage and uses Symfony 5.2.

