# restaurantAPI
## Get started
### How to

- Insert project into empty folder / git clone https://github.com/dimolinadicrespo/restaurantAPI
- Create an empty database table
- Change the .env and insert the database config
- Run the following commands

```
composer install
php artisan migrate --seed
php artisan l5-swagger:generate
php artisan serve

```
- Visit http://127.0.0.1:8000/api/documentation and check how the api works.
- ¡Enjoy the meal!
