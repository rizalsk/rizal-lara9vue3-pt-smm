# Laravel 9 with Vuejs, Bootstrap.

This is a lite Blog CMS based on [Laravel PHP Framework](https://laravel.com/docs/9.x/releases).

## Prerequisites

1. PHP > 8.0
1. (I am using SQlite) Extension DB For PHP & Database MySQL, Postgre, SQLite
1. [Composer](http://getcomposer.org)
1. [Nodejs v18.16.0](https://nodejs.org)

## Getting Started

1. Clone to your base project directory.

	```
	git clone https://github.com/rizalsk/rizal-lara9vue3-pt-smm.git
	```

1. Go to the projects' directory.

	```
	cd rizal-lara9vue3-pt-smm

1. Don't forget to remove `.git` folder, create your own repository.

	```
	rm -rf !$/.git
	```

1. Install composer dependencies.

	```
	composer install
	```

2. Create configuration file `.env` (copy from `.env.example`) and set the database configuration, choose one of the following credentials according to your database connection:
    ```
	cp .env.example .env
	```

	```
    ##SQLite
	DB_DRIVER=sqlite

    ##MySQL
    DB_DRIVER=mysql
	DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
		
	##PostgreSQL
	DB_DRIVER=pgsql
	DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=laravel
    DB_USERNAME=postgres
    DB_PASSWORD=postgres
	```
3. Migrate and seed the database.

	incase you want to drop all tables
	```
	php artisan db:wipe
	```
	and migrate & seed the database
	```
	php artisan migrate:refresh --seed
	```
4. Install front-end library dependencies.
    ```
    npm install
	```
5. Build vite for production, and make sure your `.env` file has the following `APP_ENV=production` and run this command :
    ```
    npm run build
	```
6. For security reason, please generate new application key.
	```
	php artisan key:generate
	```
7. Run the local server.
   Make sure you have the following line on your `.env` file `APP_URL=http://localhost:8080` and run the following command on your project directory
	```
	php artisan serve --port=8080
	```

## Frontend Libraries

All frontend libraries are managed using **Node.js packages**:

1. [Vue JS](https://vuejs.org)
2. [Vue Router](https://router.vuejs.org/)
3. [Axios](https://axios-http.com/docs/intro)

