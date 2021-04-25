# Ape Haven

The humble beginnings of the website home for the Ape Haven project.

## Installation

Follow the Instructions below to get the application up and running on your local development environment:

1 - Create auth.json file with Laravel Nova token:

```json
{
    "http-basic": {
        "nova.laravel.com": {
            "username": "admin@example.com",
            "password": "example-passsword"
        }
    }
}
```

2 - Run migrations with `php artisan migrate:fresh`
