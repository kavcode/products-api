## How to run

```
λ cd /path/to/project/docker
λ mv .env.exaple .env
λ docker-compose exec php-fpm sh -c "composer install"
λ docker-compose exec php-fpm sh -c "vendor/bin/doctrine-migrations migrate"
λ docker-compose up
```

## Descrtiption

Please make an application implements a simple example of REST API.

The architecture of the app should fit the MVC pattern and consist of such an object as Controller, Entity, Repository, Service. 

API must have the following endpoints: 

1. Generates the initial data set. It should create 20 items represented as "product". There are "id", "name" and "price" such a product has. 
2. Returns all the products 
3. Creates an order. This endpoint accepts a list of existing product ids. Also, an order has a status which could be one of "new" and "paid". 
The "new" is default. If the order has been created successfully the endpoint must return its "number". 
3. Accepting payment for an order. The endpoint assumes that it's given a sum and the order "id". 
If the given sum is same as the order sum,  it needs to send a http request to an external service (must be defined via configuration). 
When the external server returns `200 OK` the order status must become as "paid". 

There is no need to manage around the user's functionality, let's assume the current user has an "id" equals 1, and they authenticated under the login "admin".
Also, please skip handling the stock stuff like product's quantity, let's imagine they are infinite. 

Please implement the API without using any framework, but it's available to use separate libraries (e.g. symfony router). Using mysql triggers and procedures are discouraged.    
