# OpenCart Rest API

## How to install

### Clone the repo
```
git clone git@github.com:terezos/opencart-rest.git
or
git clone https://github.com/terezos/opencart-rest.git

cd opencart-rest
```

### Execute the following commands in your terminal
```
cp docker-compose.sample.yml docker-compose.yml
cp Dockerfile.sample Dockerfile
cp upload/config-dist.php upload/config.php
cp upload/admin/config-dist.php upload/admin/config.php
cp .env.example .env
```

### Start the Docker services
```
docker-compose up -d
```

### Import the database
You can use the Phpmyadmin interface which comes with this installation.
```
Phpmyadmin: http://localhost:8080
Server: simpler_db
Username: root
Password: root
```

### Log into server container and execute the following commands 
```
$ docker exec -it simpler_web bash
$ cd app
$ composer install
$ mkdir storage/logs/
$ touch storage/logs/error.log 
```

### Admin area
```
localhost/admin
Username: simpler
Password: simpler
```

## Rest Api
### Where is the extension?
```
On the left column of the dashboard, within the "Extensions" dropdown menu,
you will find a link titled "Rest API."
Here, you have the option to configure the username and password required for Basic Authentication.
Additionally, you may enable or disable the plugin as necessary..
```
### Rest Api Documentation
```
localhost/api/v1/orders -> returns all existing orders.
localhost/api/v1/orders/{$id} -> returns a single order if exists.

To Make an API request you must use Basic Auth
```
### Postman Basic Auth
Link: [Postman Basic Auth](https://learning.postman.com/docs/sending-requests/authorization/authorization-types/)
### Curl Basic Auth
Link: [Curl Basic Auth](https://dev.to/lucasg/how-to-use-basic-authentication-with-curl-1j6j)

## Orders
### How I can create dummy orders?
```
Log into server container again and execute the following commands:
$ docker exec -it simpler_web bash
$ cd app
$ php cli simpler:create-dummy-orders
```