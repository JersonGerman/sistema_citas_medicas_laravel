<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Requirements
- PHP >= 8.1.17
- Composer 2.5.5
- MySql

## Configuration
1. Clone the repository
```shell
git clone https://github.com/JersonGerman/sistema_citas_medicas_laravel.git
```
2. Run the following command
```shell
composer install
```
3. Rename the `.env.example` file to `.env`
4. Create a database and configure it in the `.env` file
```shell
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citamedica
DB_USERNAME=root
DB_PASSWORD=admin
```
5. Generate a `KEY` for the `APP_KEY` environment variable
```shell
php artisan key:generate
```
6. Run the artisan command to do the database migration
```shell
php artisan migrate
```
7. Run the migration with test data with the following command
```shell
php artisan migrate:fresh --seed
```

## Run application
Create a local domain, example `http://citamedica.test` and open the domain in the browser






