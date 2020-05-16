Below steps are for local testing

[Step1] Git clone
```
git@github.com:June17ang/techinal-exercise.git
```
[Step2] Copy env files
```
cp .env.example .env
```
[Step3] Composer install
```
composer install
```
[Step4] Generate key
```
php artisan key:generate
```
[Step5] Update env config
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
[Step6] config cache
```
php artisan config:cache
```
[Step7] Migrate for testing
```
php artisan migrate --seed
```
[Step8] Start local development server
```
php artisan serve
```

#### For PHPUnit Test
-- Run ```php artisan test```
