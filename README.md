## About This Project

This project is a test subject for Weroad interview.

This project achieves these goals:
- Full backend editorial platform (based on NOVA) with login for Admins and Editors to manipulate resources.
- Well documented (SWAGGER) APIs with authentications with CRUD (without DELETE) functionality.
- Automated installation with bash commands.
- Well organazied code with Laravel Pint.
- Stable code with Larastan.

## Requirements
- php@8.1
- Postgres 14.5

## Installation

create bash command to install and initiate the project
- creare database weroad
- creare database weroad_test
- cp .env.example to .env
- composer install
- php artisan migrate
update .env with db username

php artisan l5-swagger:generate 
./vendor/bin/phpstan analyse
./vendor/bin/pint --test

php artisan migrate:fresh --env=testing
php artisan config:cache
php artisan test
php artisan migrate:fresh --seed  

copy the postman export file in project
## Usage
Backend login:
https://127.0.0.1:8000

Admin login:
Email: admin@weroad.com
Password: admin

Editor login:
Email: editor@weroad.com
Password: editor

## API Documentation
https://127.0.0.1:8000/api/documentation

### License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
