# PhotoReview

## Uzstādīšana

Vajag git, PHP 8.3 un composer. Ja ir, tad aiziet:

```sh
git clone https://github.com/tontonsb/photo-review.git
cd photo-review
composer install
composer quick-setup
```

## Darbināšana

Ieliec dažas bildes vai mapes ar bildēm `storage/app/public/reviewables`,
piereģistrē jaunieliktās bildes datubāzē:

```sh
php artisan app:register-reviewables
```

un startē

```sh
php artisan serve
```

## Izstrāde

Frontend izstrādei vajag uzstādīt arī npm un atvilkt pakas:

```sh
npm install
```

Pēc tam var izstrādāt un skatīties apdeitus:

```sh
npm run dev
```

Un sabūvēt publicējamos failus:

```sh
npm run build
```

## TODO

- Varētu reviewerim arī izmantot [Pico](https://picocss.com/s): 
  `@import '@picocss/pico';`, vienīgi layouts no jauna jātaisa un dialogam
  markups jālabo. Tad būtu smukāks dizains un natīva darkmode atbalstītos...
- Vajag iespēju ierakstīt pārbaudes rezultātu.
- Varētu ieglabāt datubāzē bilžu metadatus nevis ģenerēt atvēršanas brīdī.
- Rodas vajadzība meklēt bildes pēc vietas, lai apskatītu vietu no cita leņķa.
- Vai varbūt kāds vieglāks piegājiens ar "5 šai tuvākās bildes"? 
- Kaut kur parādīt indikāciju, ka ir atlikti marķieri, jo viegli ielikt nejauši.
