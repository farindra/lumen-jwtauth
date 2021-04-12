# Lumen 8 JWT Auth Microservices
Lumen Micro PHP Framework with JWT Auth for Real World

## Installation

After cloning this repo, go to the aplication root folder and run composer install
```
$ composer install
```

edit your `.env` file, if not exist just copy it from `.env.example`

```
APP_NAME="Lumen JWT"
APP_ENV=local
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost
APP_TIMEZONE=UTC

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yourdnname
DB_USERNAME=yourdbusername
DB_PASSWORD=yourdbpassord

CACHE_DRIVER=file
QUEUE_CONNECTION=sync

JWT_SECRET=
```

generate aplication secret key
```
$ php artisan key:generate
```

generate jwt secret key
```
$ php artisan jwt:secret
```

now run migration
```
$ php artisan make:migration create_users_table
```

make sure your lumen is running
```
$ php -S localhost:8000 -t public
```


## Unit Test
please run php unit to make sure all feature is running well
```
$ phpunit
```

## Swagger File
Swagger file is in root folder ( [swagger.yaml](swagger.yaml) ), copy and paste it into [Swager Editor Online](https://editor.swagger.io) to test all Aplication API.


## CHANGE LOG
- ver. 1.0.0 
  - Jwt Auth
  - Registration
  - User Service
  - Movie Service
  - Seagger API Documentation

---

### Author

**Farindra E. P.**

* [gitlab/farindra](https://gitlab.com/farindra)
* [twitter/farindra](https://twitter.com/farindra)

### License

Copyright © 2021, [Farindra Project](https://farindra.com).
Released under the [MIT license](https://opensource.org/licenses/MIT).
