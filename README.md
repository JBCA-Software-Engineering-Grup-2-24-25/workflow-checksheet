## Quick Start
1. Install PHP >= 8.2, Node.JS (Stable), Git, Docker (Optional if you've installed MariaDB and Redis natively or using an apps like laragon)
2. Run MariaDB via Docker ```docker run --name mariadbdock --env MARIADB_ROOT_PASSWORD=root --env MARIADB_DATABASE=db_workflow_checksheets -p 3306:3306 mariadb:latest``` (Optional if you decided to installed it natively or using an apps)
3. Run Redis via Docker ```docker run --name redisdock -p6379:6379 -d redis``` (Optional if you decided to installed it natively or using an apps)
4. Run `composer install`
5. Run `npm install`
6. Copy .env.example to .env and then make sure the credential is there
7. Run `php artisan key:generate`
8. Run `php artisan migrate`
9. Run `php artisan `
