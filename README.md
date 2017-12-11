cs50_2017
=========

## Installation and configuration:

Pretty simple with [Composer](https://getcomposer.org/), run:

```sh
git clone https://github.com/akozeka/cs50_2017.git
cd cs50_2017/
```
Enter your local SMTP server info to enable email sending (when asked):
```sh
composer install
php bin/console doctrine:schema:create
php bin/console doctrine:fixtures:load
php bin/console server:run localhost:8000
```

## Usage:
Open browser URL: http://localhost:8000/
