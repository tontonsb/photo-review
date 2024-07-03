# PhotoReview

An app to split work of reviewing a lot of images.
Visitors can review images one by one, in random order.

At the moment of writing, app is live and in use here: https://photoreview.glaive.pro/

## Installation

You'll need git, PHP 8.3 and composer. Once you have them:

```sh
git clone https://github.com/tontonsb/photo-review.git
cd photo-review
composer install
composer quick-setup
```

## Running

Place some images or image folders in `storage/app/public/reviewables`,
register the new images in the database:

```sh
php artisan app:register-reviewables

# you can also store the image metadata in the database
# it will allow showing them on the map as well as remove the need for PHP to read the data every time
php artisan app:load-metadata
```

and launch the app:

```sh
php artisan serve
```

> [!NOTE]
> Project has been tried and is being used on MariaDB and SQLite.

### Training images

Training/tutorial images should be put in the `tutorial` subfolder, then they
will not be included in the reviewing flow outside the tutorial.

To include images in the tutorial flow, you have to fill in the order field
(`tutorial_order`) in the database (`reviewables` tables). The displayable
texts can be specified in the `tutorial_info` field. There is no UI for
management of these values.

## Usage

The "public facade" is visible instantly.

The data "back" end is visible by visiting `/reviews`, nearly everything is
visible without logging in.

One can register by visiting `/register`. It will give no permissions, but
registered users are able to log in, log out and bind their progress to the account.

You can verify the registered users using CLI:

```sh
php artisan tinker

$user = User::where('email', 'test@example.com')->first();
$user->verify();
```

or directly in the DB by putting the current timestamp in the `verified_at`.

The verified users are essentially admins — they can add comments to reviews,
change statuses, see the comment authors and see the review authors (if they
are registered).

## Development

Frontend development requires npm and some packages:

```sh
npm install
```

You can develop from then on and see live updates:

```sh
npm run dev
```

Or build the files to publish:

```sh
npm run build
```

## TODO (sry, only in LV)

- [ ] Varētu reviewerim arī izmantot [Pico](https://picocss.com/s): 
  `@import '@picocss/pico';`, vienīgi layouts no jauna jātaisa un dialogam
  markups jālabo. Tad būtu smukāks dizains un natīva darkmode atbalstītos...
- [x] Vajag iespēju ierakstīt pārbaudes rezultātu.
- [x] Varētu ieglabāt datubāzē bilžu metadatus nevis ģenerēt atvēršanas brīdī.
- [ ] Rodas vajadzība meklēt bildes pēc vietas, lai apskatītu vietu no cita leņķa.
- [x] Vai varbūt kāds vieglāks piegājiens ar "5 šai tuvākās bildes"? Minikartē atzīmēt ar linkiem? Pie saistītajām pielikt?
- [x] Kaut kur parādīt indikāciju, ka ir atlikti marķieri, jo viegli ielikt nejauši.
- [x] Pārskatījumu filtru pārtaisīt — rādīt jebko ar info. Un info vietā mby tikai ikonas 💬⚠️📌
- [x] Marķierus jāpadara redzamākus.
- [ ] Instrukcija "backend" sadaļām?
- [ ] Paroles atjaunošana.
- [ ] Atsevišķa sadaļa — fullscreen karte ar bilžu noseguma attēlojumu un linkiem uz bildēm.
- [ ] Pielikt /map arī nostaigātās līnijas.
