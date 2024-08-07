<?php

$tutorialUrl = route('tutorial.index');

return [
    'text' => <<<INFOBOX
        Šī projekta mērķis ir iegūt informāciju par to, kas notics ar bezvēsts pazudušo Annu Jansoni.

        Anna pazuda 2023. gada 1. novembrī un par pēdējo zināmo viņas atrašanās vietu uzskatām meža ceļu pie šosejas P101 5.5 km atzīmes.
        Kopš 2. novembra nav iegūta jauna informācija par to, kas ar Annu noticis vai kurā virzienā viņa devusies.
        Visticamāk, viņai līdzi bija pelēks pusmētelis, melni puszābaki un melnas džinsu bikses. Iespējams, arī mugursoma ar sarkaniem akcentiem un varbūt antifrīza pudele viena litra tilpumā.

        **Lūdzu rūpīgi apskatīt bildes un ierakstīt informāciju, ja kādā bildē redzams jebkas, kas varētu liecināt par to, kas ar Annu noticis, kurā virzienā viņa devusies.
        Tas var būt jebkas, kas neiederas ainā redzamajā apkārtnē, piemēram, kurpe, soma vai kādi neierastas formas objekti.**
        Kā ieraudzīt objektus vari patrenēties [šeit]($tutorialUrl).

        <details>
        <summary>
        Kas tās par bildēm? Kā tās skatīties?
        </summary>

        Attēli ir fotogrāfijas un eholotes datu ieraksti (atpazīstami pēc oranžajiem toņiem) no pazušanas vietas apkārtnes.

        Fotogrāfijas ir uzņemtas no gaisa, augstumā līdz 70 metriem. Tās var būt stipri jāpievelk, lai aplūkotu visas detaļas.
        Bildes pietuvināt var ar peles rullīti vai pirkstu atdalīšanas žestu uz skārienekrāniem un skārienpaliktņiem. Pēc pietuvināšanas bildi var bīdīt ar kursoru vai pirkstu (skārienekrānos).

        Informācijas un pogu joslā zem minikartes ir attēla nosaukums, uz kuru nospiežot var atvērt papildus informāciju par šo bildi — tiešo saiti uz bildi, atrašanās vietu un dažādus tehniskos datus.
        Bildes uzņemšanas vieta vai bildei atbilstošais reģions atzīmēts arī minikartē informācijas blokā.

        Ja vieglāk ir koncentrēties uz viena veida bildēm, var "Turpināsim ar ... bildi" izvēlēties skatīt attēlus nevis nejaušā secībā, bet pēc kārtas no esošās kopas.

        Ar pogu attēla labajā augšējā stūrī daļai attēlu var ieslēgt/izslēgt brīvu kustību bez attēla ierobežošanas rāmī — lai ērti vajadzīgo vietu pievilkt pie mērlentes.
        </details>

        <details>
        <summary>Kas ir tās oranžās bildes?</summary>

        Eholotes ieraksti attēlo ainu ūdenskrātuvēs zem ūdens. Mēroga izpratnei der zināt, ka joslas platums ir 10–50 metri, parasti 20–40.
        Attēlojumi mēdz būt divu veidu: oriģinālie ar atšķirīgu joslu vidū un SRC (slant range corrected) bez tās.

        Ņem vērā, ka eholotes attēlu ģeometrija var būt deformēta un attēlu kvalitāte — zema, tāpēc šie attēli jāapskata īpaši rūpīgi.
        </details>

        <details>
        <summary>
        Kuros gadījumos izmantot kuras pogas?
        </summary>

        Ja bildē redzams jebkas, kas sniedz informāciju par to, kas varētu būt noticis ar Annu vai kur viņa varētu būt devusies, to jāieraksta lodziņā
        "Redzi ko aizdomīgu?" un jāspiež pogu "Iesniegt". Tieši tāpat jārīkojas arī gadījumos, kad nav pārliecības un šķiet, ka attēlā redzamo vajadzētu pārbaudīt klātienē —
        piemēram, ja bildē redzama ēka, kurā būtu vērts ielūkoties.

        Ievērības cienīgo vietu var atzīmēt, spiežot uz pašas kartes. Uzliktie marķieri tiks saglabāti kopā ar pārējo iesniegto informāciju.

        Gadījumos, kad aplūkojamā vieta nav redzama gana labi un nepieciešams par to vietu gatavot jaunu bildi, lūdzu problēmu norādīt lodziņā, kurš atveras spiežot "Bilde ir nekvalitatīva vai cita problēma?" un iesniegt.
        Tas varētu būt ne tikai burtiskā izplūdušas bildes gadījumā, bet arī, piemēram, tad, ja eholotes ierakstā josla būtiski nosedz citu joslas daļu. Pie vienas bildes drīkst aizpildīt abus teksta lodziņus.

        Minikartē redzama ne tikai attēla uzņemšanas vieta, bet arī citu uzņemto bilžu vietas. Ja liekas aktuāli apskatīt kādu blakus bildi, spied kartē uz punkta un zem kartes parādīsies saite uz attiecīgo bildi.

        Gadījumā, ja redzams, ka bildē nav nekā, kas varētu sniegt šādu informāciju, jāspiež zaļo pogu "Apskatīju, nav nekā ievērības cienīga".

        Sistēma centīsies atcerēties aplūkotās bildes un vienam cilvēkam vienā pārlūkā atkārtoti nerādīt jau pārskatīto.

        Ja kāda bilde šķiet par sarežģītu, lai to kārtīgi pārbaudītu, vari ekrāna apakšā spiest "Izlaist šo bildi".
        Izlaistās bildes parādīs atkal, ja visas pārējās būs jau apskatītas.
        </details>

        Ar meklēšanu saistītos ģeodatus — pārmeklētās vietas, novērotos objektus u.c. var aplūkot <a href="https://ej.uz/AnnasVietas" target=_blank>ej.uz/AnnasVietas</a>.

        Jebkuru citu informācija par to, kas ar Annu varētu būt noticis lūdzu sniegt
        uz [27020337](tel:+37127020337) (pieejams arī WhatsApp, Signal, Telegram),
        juris@glaive.pro vai Valsts policijai.
        INFOBOX,
];
