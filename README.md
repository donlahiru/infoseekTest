# Infoseek Test

## Getting Started

get clone of the project
```
composer update

```
copy .env.example to .env
set database

```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
run
```
php artisan key:generate

```

for the first question update mail connection in .env
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=ssl
```

second question facebook post update configeration in .env
```
FACEBOOK_APP_ID=
FACEBOOK_APP_SECRET=
```

twitter post update configeration in .env
```
TWITTER_CONSUMER_KEY=
TWITTER_CONSUMER_SECRET=
TWITTER_ACCESS_TOKEN=
TWITTER_ACCESS_TOKEN_SECRET=
```

third question api endpoints
insert customer records(check with the customer table for feilds)
```
your_domain/api/customers/create
```

update record
```
your_domain/api/customers/update/{customerId}
```

delete record
```
your_domain/api/customers/delete/{customerId}
```

search customer (GET request)
```
your_domain/api/customers/{customerId}
```

search all customers (GET request)
```
your_domain/api/customers
```