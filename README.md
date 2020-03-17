# Gizer Results

Recruitment Task from Marcin Lenkowski.

App is based on Laravel Framework 6.18.1.

## Installation

You need have installed docker envirinment in your machine.

1. Clone this repository
2. Run docker container using `docker-compose up`
3. Open docker workspace container using `docker exec -it gizer_app bash`
4. Run command `composer install`
5. Copy env file `cp .env.example .env`
6. Generate key for application `php artisan key:generate`

## How to test this app

You can use laravel vendor phpunit to test it inside container. Additionaly container has xdebug installed, so you can even generate code coverage reports.

1. Open docker container `docker exec -it gizer_app bash`
2. Run `vendor/bin/phpunit` for unit tests
3. Run `vendor/bin/phpunit -c phpunit-integration.xml` for integration tests
4. You can also check code coverage by typing: `phpunit -c phpunit-integration.xml --coverage-html ./coverage`


**According to goal and business requiremenst i've add my ideas to create this app in specific way:**

## Goal

The goal of this task is to create an REST API endpoint for frontend app to read data about scores taken from 3rd party service via backend app. We estimate this task should take roughly 8 hours.

## Architectural drivers

According to businness requirements we will use following:

### Performance

- [TODO] Mongodb as a caching database from remote server.
- Docker usage for easy implementation in diffrent env's

### Scalability

- [TODO] Possibility to get data particle data from endpoint.
- Possibility to easy create instance of application (just docker-compose up and minimum configuration).
- [TODO] Separated jobs queues for fetch data and separated solution for fetch data (including cache)
- Design based on separate layers
- Using SOLID and Desing Patterns

### Failure impact

- [TODO] Preparation for bad responses code from server, allowing us to fetch data again
- [TODO] Serving data from temporary database
- [TODO] Raporting about issues in long term of time

### Well-tested

- Using TDD for whole development process
- Maximum coverage by code

## Requirements

- [TODO] Allow to read data in JSON format, but should be open to extend
- [TODO] Allow to sort by date / score

## 3 party service

Documentation was digged here: https://jacek10.docs.apiary.io/# ;)

URL for api call is:

```plain
GET https://private-b5236a-jacek10.apiary-mock.com/results/games/1
```