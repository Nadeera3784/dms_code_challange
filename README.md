# Bookshop
Ecommerce web application developed with laravel

## Installation

clone this repo to your server

Install the dependencies

```sh
 composer install 
```
Update .env file
rename the .env.example to .env 

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
Running Migrations

```sh
 php artisan migrate
```

Running Seeders


```sh
php artisan db:seed
```

finally, run 

```sh
php artisan serve
```

good to go.

open up your web browser and visit

```sh
http://127.0.0.1:8000
```

test coupon codes

```sh
5rKzK9WH
CN5CbjiP
```