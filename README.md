<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## How to install

This app can install on your local or server. You can following this

- do git clone this repository.
- create .env with following file .env.exampe or if u are using linux, you can do [cp .env.example .env](#)
- set database name, user database and password in .env file
- do [php artisan key:generate](#)
- do [composer install](#)
- extract folder inside [path_and_file_default_storage.zip](#) to [storage/app/public/...](#) , so your path like this [storage/app/public/images](#)
- do [php artisan storage:link](#)
- fill data seed and create table in your database, you can do [php artisan migrate:fresh --seed](#)
- done

Laravel is accessible, powerful, and provides tools required for large, robust applications.
