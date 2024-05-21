@extends('base-layout')

@section('head')
@vite(['resources/css/reviewer.css'])
@endsection

@section('body')
<main>
    <div id=image></div>

    <form method=post action="{{route('reviews.store')}}">
        @csrf
        <input type=hidden name=filepath value="{{$file->path}}">
        <input type=hidden name=reviewing_duration_ms value=0>

        <div class=actions>
            <button type=submit name=conclusion value=ok class=button--ok>Apskatīju, nav nekā ievērības cienīga</button>

            <details open>
                <summary>Redzi ko aizdomīgu?</summary>
                <textarea name=review></textarea>
            </details>

            <details>
                <summary>Ziņot par sliktu/nekvalitatīvu bildi</summary>
                <textarea name=problem></textarea>
            </details>

            <button type=submit name=conclusion value=suspect class=button--suspect>Iesniegt</button>

            <button type=submit name=conclusion value=skip class=button--skip>Izlaist šo bildi</button>
        </div>

        <div class=file>
            <div id=location-map style="width: 100%; height: 100px;"></div>
            <details>
                <summary>
                    {{$file->path}}
                </summary>
                <a href="{{$file->url}}" target=_blank>{{$file->path}}</a>
                @if ($linkedFile)
                    <br><a href="{{$linkedFile->url}}" target=_blank>
                        @if ($linkedFile->isSrc())
                            Attēla versija ar ģeometrijas korekciju
                        @else
                            Oriģinālo datu attēls (bez korekcijas)
                        @endif
                    </a>
                @endif
                <code>
                    @foreach ($exif as $key => $value)
                        @if (is_scalar($value) || is_null($value))
                            {{$key}}: {{$value}}
                        @elseif (is_array($value))
                            @foreach ($value as $subkey => $subvalue)
                                {{$key}} {{$subkey}}: {{is_string($subvalue) ? $subvalue : json_encode($subvalue)}}
                            @endforeach
                        @endif
                    @endforeach
                </code>
            </details>
        </div>

        <aside>
            <div class="progress" data-label="{{$reviewed_percentage}}% pārskatīti" title="Kopā esam pārskatījuši {{$reviewed_percentage}}% bilžu!">
                <div class="value" style="width:{{$reviewed_percentage}}%;"></div>
            </div>

            <button type=button class="js-show-infobox button--info">Atvērt pamācību</button>
        </aside>
    </form>
</main>

<dialog class=js-infobox>
    <div>
        <button title=Aizvērt class="x-button js-close">✕</button>

        <div autofocus>
            <p>Šī projekta mērķis ir iegūt informāciju par to, kas notics ar bezvēsts pazudušo Annu Jansoni.

            <p>Anna pazuda 2023. gada 1. novembrī un par pēdējo zināmo viņas atrašanās vietu uzskatām meža ceļu pie šosejas P101 5.5 km atzīmes.
            Kopš 2. novembra nav iegūta jauna informācija par to, kas ar Annu noticis vai kurā virzienā viņa devusies.
            Visticamāk, viņai līdzi bija pelēks pusmētelis, melni puszābaki un melnas džinsu bikses. Iespējams, arī mugursoma ar sarkaniem akcentiem un varbūt antifrīza pudele viena litra tilpumā.

            <p><strong>Lūdzu rūpīgi apskatīt bildes un ierakstīt informāciju, ja kādā bildē redzams jebkas, kas varētu liecināt par to, kas ar Annu noticis, kurā virzienā viņa devusies.
                Tas var būt jebkas, kas neiederas ainā redzamajā apkārtnē, piemēram, kurpe, soma vai kādi neierastas formas objekti.
            </strong>

            <details>
                <summary>
                    Kas tās par bildēm? Kā tās skatīties?
                </summary>

                <p>Attēli ir fotogrāfijas un eholotes datu ieraksti (atpazīstami pēc oranžajiem toņiem) no pazušanas vietas apkārtnes.

                <p>Fotogrāfijas ir uzņemtas no gaisa, augstumā līdz 70 metriem. Tās var būt stipri jāpievelk, lai aplūkotu visas detaļas.
                Bildes pietuvināt var ar peles rullīti vai pirkstu atdalīšanas žestu uz skārienekrāniem un skārienpaliktņiem. Pēc pietuvināšanas bildi var bīdīt ar kursoru vai pirkstu (skārienekrānos).

                <p>Informācijas un pogu joslas sākumā ir attēla nosaukums, uz kuru nospiežot var atvērt papildus informāciju par šo bildi — tiešo saiti uz bildi, atrašanās vietu un dažādus tehniskos datus.
            </details>

            <details>
                <summary>Kas ir tās oranžās bildes?</summary>

                <p>Eholotes ieraksti attēlo ainu ūdenskrātuvēs zem ūdens. Mēroga izpratnei der zināt, ka joslas platums ir 10–50 metri, parasti 20–40.
                Attēlojumi mēdz būt divu veidu: oriģinālie ar atšķirīgu joslu vidū un SRC (slant range corrected) bez tās.

                <p>Ņem vērā, ka ehelotes attēlu ģeometrija var būt deformēta un attēlu kvalitāte — zema, tāpēc šie attēli jāapskata īpaši rūpīgi.
            </details>

            <details>
                <summary>
                    Kuros gadījumos izmantot kuras pogas?
                </summary>

                <p>Ja bildē redzams jebkas, kas sniedz informāciju par to, kas varētu būt noticis ar Annu vai kur viņa varētu būt devusies, to jāieraksta lodziņā
                "Redzi ko aizdomīgu?" un jāspiež pogu "Iesniegt". Tieši tāpat jārīkojas arī gadījumos, kad nav pārliecības un šķiet, ka attēlā redzamo vajadzētu pārbaudīt klātienē —
                piemēram, ja bildē redzama ēka, kurā būtu vērts ielūkoties.

                <p>Gadījumos, kad aplūkojamā vieta nav redzama gana labi un nepieciešams par to vietu gatavot jaunu bildi, lūdzu problēmu norādīt lodziņā, kurš atveras spiežot "Bilde ir nekvalitatīva vai cita problēma?" un iesniegt.
                Tas varētu būt ne tikai burtiskā izplūdušas bildes gadījumā, bet arī, piemēram, tad, ja eholotes ierakstā josla būtiski nosedz citu joslas daļu. Pie vienas bildes drīkst aizpildīt abus teksta lodziņus.

                <p>Gadījumā, ja redzams, ka bildē nav nekā, kas varētu sniegt šādu informāciju, jāspiež zaļo pogu "Apskatīju, nav nekā ievērības cienīga".

                <p>Sistēma centīsies atcerēties aplūkotās bildes un vienam cilvēkam vienā pārlūkā atkārtoti nerādīt jau pārskatīto.

                <p>Ja kāda bilde šķiet par sarežģītu, lai to kārtīgi pārbaudītu, vari ekrāna apakšā spiest "Izlaist šo bildi".
                Izlaistās bildes parādīs atkal, ja visas pārējās būs jau apskatītas.
            </details>


            <p>Ar meklēšanu saistītos ģeodatus — pārmeklētās vietas, novērotos objektus u.c. var aplūkot <a href="https://ej.uz/AnnasVietas" target=_blank>ej.uz/AnnasVietas</a>.

            <p>Jebkuru citu informācija par to, kas ar Annu varētu būt noticis lūdzu sniegt
            uz <a href="tel:27020337">27020337</a> (pieejams arī WhatsApp, Signal, Telegram),
             <a href="mailto:juris@glaive.pro">juris@glaive.pro</a> vai Valsts policijai.
        </div>
    </div>
</dialog>

@vite(['resources/js/reviewer.js'])
<script type=module>
@if ($file->isSonarImage() && ($exif['LOCATION'] ?? false))
    displayImageOnMap('image', @json($exif['LOCATION']), '{{$file->url}}')
@else
    displayImage('image', {{$exif['COMPUTED']['Width'] ?? 0}}, {{$exif['COMPUTED']['Height'] ?? 0}}, '{{$file->url}}')
@endif

bootInfobox('.js-infobox', '.js-show-infobox', {{$seenInfobox ? 'false' : 'true'}})

@if ($exif['LOCATION'] ?? false)
    @if ($file->isSonarImage())
        makeMapWith.box('location-map', @json($exif['LOCATION']))
    @else
        makeMapWith.pin('location-map', @json($exif['LOCATION']))
    @endif
@endif
</script>
@endsection
