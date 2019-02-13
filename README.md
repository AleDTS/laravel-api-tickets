# Case

Basic API server made with laravel.

## Prerequisites

* [Docker](https://docs.docker.com/get-started/)
* [Docker-compose](https://docs.docker.com/compose/install/)

## Getting Started

Run docker-compose and enter container's bash
```
docker-composer up -d nginx mariadb phpmyadmin
docker-composer exec workspace bash
```
Install the dependencies for the classifier algorithm
```
cd classifier
git clone https://github.com/abusby/php-vadersentiment.git
composer update #the composer.json have it
#or
composer require stichoza/google-translate-php
```
Execute the JSON's classifier and move it to laravel database folder
```
php classifier.php "desafio-backend-master/tickets.json" "tickets.json"
mkdir ../laravel/database/data
mv tickets.json ../laravel/database/data
cd ../laravel
```
Execute artisan's commands to populate mariadb
```
php artisan migrate:fresh
php artisan db:seed
```
And you're ready to go! access [http/localhost](http/localhost) on your browser, and if you want, [http/localhost:8080](http/localhost:8080) to access phpmyadmin and view the database.

## Classifier

The classifier algorithm classifies priority in object (tickets) at the given json data for this project according to given requisites. If PriorityScore is 0, it means normal priority, else if is >0, means high priority, varying between 1-3, for ordering purposes.

## API

The api has the following route, where you can get all the tickets from de database:

* [http/localhost/api/tickets](http/localhost/api/tickets)

Also, there are parameters for filtering, sorting and pagination:

|Parameter|Description|
|---------|-----------|
|?include=interactions|include ticket's relationship (not working)|
|?filter[tableProperties*]=value|filter by table's properties|
|?filter[starts_between]:YYYY-MM-DD,YYYY-MM-DD|filter in given range|
|?sort=tableProperties*|sort by table's properties|


* Allowed filters properties: PriorityScore, TicketID, DateCreate
* Allowed sort properties: PriorityScore, DateCreate, DateUpdate

## Built With

* [Laravel](https://github.com/laravel/laravel)
* [Laradock](https://laradock.io/)
* [stichoza/google-translate-php](https://github.com/Stichoza/google-translate-php)
* [patie/laravel-query-builder](https://github.com/spatie/laravel-query-builder)
