## About

This is shop website 

It has cart, product attributes, and other features

This project is based on docker

For launch you must specify GITHUB_API_TOKEN in .env file and then start docker
```
docker-compose up --build -d --remove-orphans
```

After then you should run artisan key generate and migrations
```
php artisan key:generate
php artisan migrate:fresh --seed
```

For email sending you should complete these fields in .env file
```
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
```
