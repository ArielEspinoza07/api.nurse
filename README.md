# Nurse API

## Project Setup

<br>

#### Requirements
    
    PHP: 8.1

## Getting start

<br>

#### Clone the project

    https:
        https://github.com/ArielEspinoza07/api.nurse.git

    ssh:
        git@github.com:ArielEspinoza07/api.nurse.git

#### Add .env file

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

#### Configuration
    
    Modify .env.testing configuration file with your own values
    By default sqlite is use for testing

#### Generate Project key

    php artisan key:generate --env=testing

#### Generate tables on your DB

    php artisan migrate --seed --env=testing

#### Run your tests with a local server with

    .vendor/bin/phpunit

    // or with the artisan command

    php artisan test
