# Nurse API

## Project Setup

<br>

#### Requirements
    
    PHP: 8.1

## Getting start

<br>

#### Clone the project

    https:

    ssh:

    Linux, MacOs
        cp .env.example .env

    Windows
        copy .env.example .env            

#### Database

    Create your database (Mysql, MariaDB, PostgreSQL, MSQL Server)

    Modify the .env file values with the your db credentials

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=laravel
        DB_USERNAME=root
        DB_PASSWORD=123456

<br>

## Development

<br>

#### Install dependencies

    composer install

#### Generate Project key

    php artisan key:generate

#### Generate tables on your DB

    php artisan migrate --seed

<br>

## Production

<br>

#### Install dependencies

    composer install --optimize-autoloader --no-dev

#### Generate Project key

    php artisan key:generate

#### Generate tables on your DB

    php artisan migrate --seed
<br>

## Testing

<br>

You can run your tests with a local server with

    .vendor/bin/phpunit

    // or with the artisan command

    php artisan test
