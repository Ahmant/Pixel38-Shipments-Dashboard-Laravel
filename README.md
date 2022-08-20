
# Shipmemts Dashboard

## Project setup

### .env

#### #Database
Change these parameters to math your database
`DB_DATABASE`
`DB_USERNAME`
`DB_PASSWORD`
  
#### #Queues
Change this as below:
`QUEUE_CONNECTION=database`

#### #Sanctum
Change these as below:
`SESSION_DRIVER=cookie`
`SESSION_DOMAIN=localhost` 👈 Instead of "localhost" set your top level domain your application uses (it can be "localhost" if you are working locally)
`SANCTUM_STATEFUL_DOMAINS=localhost,localhost:5173` 👈 Add all the subdomains (if any), that your frontend uses (used by VUE project in our case).

##### #Mail
Add these settings to work with email
`MAIL_MAILER=smtp`
`MAIL_HOST=in-v3.mailjet.com`
`MAIL_PORT=587`
`MAIL_USERNAME=edf68f67905ffebba914b81fe5fc993f`
`MAIL_PASSWORD=cc026c9fd14502e21ace08c6a41f8154`
`MAIL_ENCRYPTION=tls`
`MAIL_FROM_ADDRESS="almooradi@gmail.com"`
  
### Install Packages
```

composer update

```

### Migrations

```

php artisan migrate

```

### Start queue listner (used in email verification)

```

php artisan queue:work

```

### Start the project

```

php artisan serve

```