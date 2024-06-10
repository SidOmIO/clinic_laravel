
<h1 align="center">Clinic_booking</h1>

## Dependencies ##

The following tools were used in this project:

- [PHP](https://www.php.net)
- [Node](https://nodejs.org/)
- [Laravel](https://laravel.com)
- [Maildev](https://github.com/maildev/maildev)
- [Dompdf](https://github.com/dompdf/dompdf)
- [Stripe API](https://github.com/stripe/stripe-php)

## Dev Dependencies ##

- [PHPMetrics](phpmetrics/phpmetrics)
- [PHPStan](phpstan/phpstan)

## Requirements ##

Before starting, you need to have [PHP](https://www.php.net), [Composer](https://getcomposer.org), [Node](https://nodejs.org/) installed.

## Starting ##

Clone this project.

Access
- cd clinic_booking

Install dependencies
- composer install

Create Database
- php artisan migrate:fresh

Populate Database
- php artisan db:seed

Run
- npm run dev
- php artisan serve

Install Maildev for email testing (Easier if install using Docker)

Change the .env.example file into .env and update the value as needed.

Update STRIPE_SECRET_KEY in .env for payment testing. (Can refer [here](https://www.youtube.com/watch?v=HpDxCST02Ks&t=76s))

For card number used in payment module can refer [here](https://docs.stripe.com/testing)
