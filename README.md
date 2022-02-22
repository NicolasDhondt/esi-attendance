# esi-attendance

This project was done by a group of 7 poeple as part of a school project.
Method used : XP with pair proramming.

## Generate the vendor repository

Use the following command :

-   composer install

## To populate the BD

### Check your database

Check your database is created and is the right one in the .env file.

### Migrate all tables

Migrate all tables with the command : php artisan migrate.

### Add data

There are two way to add some data.

1. Some files can be added in this apps to generate data

    You can find them in the ICS_CSV_exemple repository.
    Add MAX 20 files at the same times.

2. Some randomly data generated

    You can use this command to generate some data randomly.
    The command : php artisan db:seed

## Brief

To use this app easier, enter the following command :

-   composer install
-   php artisan migrate
-   php artisan db:seed
