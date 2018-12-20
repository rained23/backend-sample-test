## About SampleTest

A SampleTest to demonstrate a backend logic of CRUD attached with and without UI using Laravel.

## Installation

Install project dependency .
```
composer install
```

```
yarn install
```

#### Create .env File
Create .env file from .env.example and update the configuration.

#### Setup Database

Run schema migration.
```
php artisan migrate
```

Run seeder
```
php artisan db:seed
```
Compile the assets
```
yarn run dev
```

#### Additional Notes
To login into the backend system :

1. Register new account from the registration page.
2. Use console command to assign admin role to that account.

The `admin` and `support` role has been added when the database seeded

## Available Console Command

#### Manage Roles
```
php artisan manage:roles --help
```

#### Manage Tags
```
php artisan manage:tags --help
```

#### Assign or Unassign Roles to User
```
php artisan user:roles --help
```

#### Assign or Unassign Tags to Users (Bulk)
```
php artisan user:tags --help
```
