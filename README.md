## Juan the Drinker

API tool to collect all the relevant data for a single user and get information about bars that he is visiting, type of liquor that he is consuming, and frequency of it. The backend system also includes a search functionality for bars and visits. 

## Requirements

* Apache or Nginx Web Server.
* PHP version 8.2.0 or greater.
* Laravel Framework 10.x.
* MySQL Database engine version 8.0.31 or greater.
* The following modules must be installed and enabled on the server:
  * Mod_rewrite.
  * Ctype PHP Extension.
  * cURL PHP Extension.
  * DOM PHP Extension.
  * Fileinfo PHP Extension.
  * Filter PHP Extension.
  * Hash PHP Extension.
  * Mbstring PHP Extension.
  * OpenSSL PHP Extension
  * PCRE PHP Extension
  * PDO PHP Extension
  * Session PHP Extension
  * Tokenizer PHP Extension
  * XML PHP Extension

## Configuration

Rename the `.environment.local` to `.env` and change the required credentials accordingly (e.g: DB credentials...) by adding/updating the following parameters to match the application configuration:

* APP_URL=`<APPLICATION_URL>`
* DB_CONNECTION=`<DB_ENGINE>`
* DB_HOST=`<DB_HOST>`
* DB_PORT=`<DB_PORT>`
* DB_DATABASE=`<DB_NAME>`
* DB_USERNAME=`<DB_USERNAME>`
* DB_PASSWORD=`<DB_PASSWORD>`
* S3_REGION=`<REGION>`
* S3_BUCKET=`<BUCKET_NAME>`
* S3_BUCKET_SUFFIX=`<BUCKET_SUFFIX>`
* S3_BUCKET_OBJECTS_LOCATION=`<OBJECTS_LOCATION_NAME>`
* S3_BUCKET_OBJECTS_URL="https://s3.${S3_REGION}.amazonaws.com/${S3_BUCKET}/${S3_BUCKET_SUFFIX}/${S3_BUCKET_OBJECTS_LOCATION}"

## Installation

* Replace the `APP_URL` parameter in the file `env file` with the correct value.
* Run `php composer install` to install the project dependencies.
* Run the artisans commands below:
    * `php artisan storage:link` (symbolic storage link).
    * `php artisan migrate` (migration - To create the tables).
    * `php artisan db:seed` (seeding - To populate the tables).
* For development and testing, run `php artisan serve` to start the server in development mode.

## Indications for deployment

The solution uses the Apache as the web server running for the application. In case of Nginx server, some configuration must be set for deployment which can be found [here](https://laravel.com/docs/10.x/deployment).

For MySQL database engine, set the `DB_HOST` value to tbe as the service name of the database in the docker-compose file (i.e. mysql).

The Apache server version for this setup is 2.4.54.2.

## About the framework

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.