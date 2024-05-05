# PhotoReview

## Uzstādīšana

```sh
git clone https://github.com/tontonsb/photo-review.git
cd photo-review
cp .env.example .env
composer install
php artisan migrate
```

## Darbināšana

Ieliec dažas bildes vai mapes ar bildēm `storage/app/public/reviewables` un

```sh
php artisan serve
```
