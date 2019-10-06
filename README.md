## How to run

```
λ cd /path/to/project/docker
λ mv .env.exaple .env
λ docker-compose exec php-fpm sh -c "composer install"
λ docker-compose exec php-fpm sh -c "vendor/bin/doctrine-migrations migrate"
λ docker-compose up
```