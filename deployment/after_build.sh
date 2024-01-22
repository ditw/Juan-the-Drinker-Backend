
#! /bin/bash

php artisan --version;

# Run migration and database seeding
php artisan migrate;
php artisan db:seed