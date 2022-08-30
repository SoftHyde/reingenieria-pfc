# PFC - Plataforma web de participación ciudadana
Web platform for citizen participation.  
Developed as a final project for the degree in Informatics Engineering at "Universidad Nacional del Litoral".

## Technologies
Laravel, Bootstrap, php, javascript, mysql.

## Installation

### Notes
- The project was developed and tested using **Ubuntu 16.04 LTS, PHP 5.5.9 and Laravel 5.1.**
- Correct functioning on other systems and software versions is not guaranteed.

### Set up DB
- Install Mysql server and create a user (optionally install phpmyadmin to manage your DBs)
- Create a mysql  database locally named `pfc` utf8_general_ci
- Create a mysql  database locally named `tracker` utf8_general_ci

### Install project and dependencies
- Clone or download repo: `git clone git@github.com:jeronimok/pfc.git`
- Download and install composer https://getcomposer.org/download/
- Rename `.env.example` file to `.env`inside your project root and fill the database information (username and password)
- Open the command line and cd to the project root directory
- Run `composer install` or ```php composer.phar install```

### Generate app key
- Run `php artisan key:generate` 

### Run seeders and migrations

**Note:** Check the seeder UserTableSeeder.php and edit it to be able to quickly create admin users with your credentials.

- Run `php artisan migrate`
- Run `php artisan db:seed` to run seeders

### Serve
- Run `php artisan serve`
- At this point you should be able to access the project at http://localhost:8000

### Set up mail server for local testing (required for users registration)
- Create an account in https://mailtrap.io/
- Fill the required variables in your .env file

### Set up recaptcha
- Create yor public and private recaptcha keys: https://cloud.google.com/recaptcha-enterprise/docs/create-key
- Fill the required variables in your .env file

### User manual
- After installing the project, it may be helpful to read the user manual: https://github.com/jeronimok/pfc/blob/master/Manual-de-usuario.pdf



### If for some reason your project stops working try this:
- `composer install`
- `php artisan migrate`


## Contact 

- Jerónimo Calace Montú
- jeronimo.calace@gmail.com
