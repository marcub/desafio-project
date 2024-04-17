# Quick start

If you want to try out the project just follow those steps:

```bash
$ cp .env.template .env
$ docker-compose up
$ composer install
$ npm install
$ php -S localhost:8000 -t public/npm install
$ npm run dev
$ php bin/console doctrine:migration:migrate
$ php bin/console doctrine:fixtures:load
```