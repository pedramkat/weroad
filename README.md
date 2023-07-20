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

1. Clone the project with:
    - `git clone  https://github.com/pedramkat/weroad.git`
2. Go to the root directory of the Weroad project
    - `cd weroad`
3. Create two databases in PostgreSQL
    Connect to the database `psql`, then:
    - `create database weroad`
    - `create database weroad_test`
    
    Alternativly:
    - `psql -c "CREATE DATABASE weroad"`
    - `psql -c "CREATE DATABASE weroad_test"`
4. Create .env file
    - `cp .env.example .env`
4. Copy the database Username and Password in the .env of the project
    - DB_USERNAME={username}
    - DB_PASSWORD={password}
4. Copy the database Username and Password in the .env.testing of the project
    - DB_USERNAME={username}
    - DB_PASSWORD={password} 
5. Lunch the deploy command
    - `bash scripts/deploy_local.sh`

Now the platform is up and running see the **Usage** section below.
## Usage
Backend login:
http://127.0.0.1:8000

Admin login:
Email: admin@weroad.com
Password: admin

Editor login:
Email: editor@weroad.com
Password: editor

## API documentation
http://127.0.0.1:8000/api/documentation
## Testing

**Lunch the test**
`php artisan test`

**Lunch the phpstan**
`./vendor/bin/phpstan analyse`

**Lunch the php cs fixer test**
`./vendor/bin/pint --test`

### License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
