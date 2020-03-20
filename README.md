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

## How to use this app

This app for works needs to get data from remote API server. Default endpoint is set on `https://private-b5236a-jacek10.apiary-mock.com/results/games/` but you can change it by edit `API_3TH_ENDPOINT_RESULTS` parameter in your .env file. Remember that last path parameter (/1) will be added by repository on fetch - do not add this element!

We are prepared for fetch data it in many ways:

- using get api call and do it from middleware (not reccomended)
- using command manually `php artisan fetch:results` (option)
- using laravel build-in cron system with command `* * * * * php artisan schedule:run >> /dev/null 2>&1` (recomended, required cron configuration)
- you can also just once use `php artisan schedule:run`

When data will be there, you can start using REST API.

### Rest API

Application provide only one endpoint. It is also described for OpenApi standard (as a command in controller).

```plain
GET http://localhost:1111/api/results

Parameters:
- (string) order
    - asc - ascending
    - desc - descending
- (string) order_by
    - finished_at - finished date
    - score - score date

Example call for get results ordered ascending by score:

GET http://localhost:1111/api/results?order=asc&order_by=score
```

#### Important notice

If you want to always on get data fetch it from external api, there is an option for that. However it's highly not recomended for performence issues.

To use that add to .env variable: `API_FETCH_ALWAYS=true` then config file will be changed on always fetch.

#### Response type

For now app response with JSON data, but in future, there is an option for change it easly. It is done with Open / Close principle and Strategy pattern. For now available is only `json`, but if new response class will be created there is an option for other type response.

It is also configurable by env param `API_RESPONSE_DEFAULT=json`.

### Get data from command

You can get data from external API using command
`php artisan fetch:results`.

In case of any errors you will get notice. Data fetch may take a while, dependently on current internet connection.

## How to test this app

You can use laravel vendor phpunit to test it inside container. Additionaly container has xdebug installed, so you can even generate code coverage reports.

1. Open docker container `docker exec -it gizer_app bash`
2. Run `vendor/bin/phpunit` for unit tests
3. Run `vendor/bin/phpunit -c phpunit-integration.xml` for integration tests
4. You can also check code coverage by typing: `vendor/bin/phpunit -c phpunit-integration.xml --coverage-html ./coverage`


**According to goal and business requiremenst i've add my ideas to create this app in specific way:**

## Goal

The goal of this task is to create an REST API endpoint for frontend app to read data about scores taken from 3rd party service via backend app. We estimate this task should take roughly 8 hours.

## Architectural drivers

According to businness requirements we will use following:

### Performance

- Mongodb as a caching database from remote server.
- Docker usage for easy implementation in diffrent env's

### Scalability

- Possibility to get data particle data from endpoint.
- Possibility to easy create instance of application (just docker-compose up and minimum configuration).
- Separated command and preparation for easy configuration it with cron.
- Design based on separate layers
- Using SOLID and Desing Patterns

### Failure impact

- Preparation for bad responses code from server, allowing us to fetch data again
- Serving data from cache database

### Well-tested

- Using TDD for whole development process
- Maximum coverage by code

## Requirements

- Allow to read data in JSON format, but should be open to extend
- Allow to sort by date / score

## 3 party service

Documentation was digged here: https://jacek10.docs.apiary.io/# ;)

URL for api call is:

```plain
GET https://private-b5236a-jacek10.apiary-mock.com/results/games/1
```