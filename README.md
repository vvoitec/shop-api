# shop-api
## Requirements
- Docker
- Composer
## Project set-up
In project's root directory:\
`> composer install`\
`> docker-compose up`

To setup the database connection string in .env file should be:\
`DATABASE_URL=mysql://shop-api:shop-api@localhost:3306/shop-api.db`\
Then to update database schema: \
`> php bin/console make:migration`\
`> php bin/console doctrine:migrations:migrate`\
For application to work properly after performing the migration\
you have to change the connection string to:\
`DATABASE_URL=mysql://shop-api:shop-api@db:3306/shop-api.db`


shop-api comes with swagger-ui, with project running visit
`localhost:8000/api-docs/`
to test the api.
## About
This project is an attempt of _DDD CQRS_ architecture. \
It uses _PHP 8_, _mySQL 8.0_ for data storage and Symfony 5.2 as web framework.

