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

# var pēc tam arī ieglabāt šo bilžu metadatus datubāzē
php artisan app:load-metadata
```

un startē

```sh
php artisan serve
```

> [!NOTE]
> Projekts pārbaudīts un tiek lietots ar MariaDB un SQLite.

## Lietošana

"Publiskā fasāde" ir redzama.

Datu daļu var apskatīt, apmeklējot `/reviews`. Praktiski viss ir apskatāms bez pieslēgšanās.

Piereģistrēties var, apmeklējot `/register`. Piereģistrēšanās pati par sevi nekādas tiesības nedos, vienīgi varēs pieslēgties/atslēgties.

Reģistrētos lietotājus var apstiprināt komandrindā

```sh
php artisan tinker

$user = User::where('email', 'test@example.com')->first();
$user->verify();
```

vai datubāzē ieliekot šodienas datumu laukā `verified_at`.

Apstiprinātie lietotāji var pievienot komentārus un redzēt komentāru autorus.

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

- [ ] Varētu reviewerim arī izmantot [Pico](https://picocss.com/s): 
  `@import '@picocss/pico';`, vienīgi layouts no jauna jātaisa un dialogam
  markups jālabo. Tad būtu smukāks dizains un natīva darkmode atbalstītos...
- [x] Vajag iespēju ierakstīt pārbaudes rezultātu.
- [x] Varētu ieglabāt datubāzē bilžu metadatus nevis ģenerēt atvēršanas brīdī.
- [ ] Rodas vajadzība meklēt bildes pēc vietas, lai apskatītu vietu no cita leņķa.
- [x] Vai varbūt kāds vieglāks piegājiens ar "5 šai tuvākās bildes"? Minikartē atzīmēt ar linkiem? Pie saistītajām pielikt?
- [ ] Kaut kur parādīt indikāciju, ka ir atlikti marķieri, jo viegli ielikt nejauši.
- [x] Pārskatījumu filtru pārtaisīt — rādīt jebko ar info. Un info vietā mby tikai ikonas 💬⚠️📌
- [x] Marķierus jāpadara redzamākus.
- [ ] Instrukcija "backend" sadaļām?
- [ ] Paroles atjaunošana.
