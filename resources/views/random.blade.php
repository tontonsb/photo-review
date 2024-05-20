@extends('base-layout')

@section('head')
@vite(['resources/css/reviewer/main.css'])
<link rel=stylesheet href=https://cdn.jsdelivr.net/npm/zoomist@2/zoomist.css>
<style>
.zoomist-container {
    --zoomist-wrapper-bg-color: #1c1c1c;

    --zoomist-slider-bg-color: rgba(255, 255, 255, .3);
    --zoomist-slider-padding-x: 10px;
    --zoomist-slider-padding-y: 14px;
    --zoomist-slider-bar-size: 100px;

    --zoomist-zoomer-button-size: 40px;
    --zoomist-zoomer-button-color: rgba(255, 255, 255, .6);
    --zoomist-zoomer-button-color-hover: rgba(255, 255, 255, .9);
    --zoomist-zoomer-button-color-disabled: rgba(255, 255, 255, .3);
}

.zoomist-wrapper {
    min-height: 60lvh;
}
</style>
@endsection

@section('body')
<main>
    <div class=zoomist-container-container> <!-- zoomist works wrongly in grid -->
        <div class=zoomist-container>
            <div class=zoomist-wrapper>
                <div class=zoomist-image>
                    <img src="{{$file->url}}" {!! $exif['COMPUTED']['html'] ?? '' !!} >
                </div>
            </div>
        </div>
    </div>

    <form method=post action="{{route('reviews.store')}}">
        @csrf
        <input type=hidden name=filepath value="{{$file->path}}">
        <input type=hidden name=reviewing_duration_ms value=0>

        <details class="file">
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

        <button type=submit name=conclusion value=ok class=button--ok>Apskatīju, nav nekā ievērības cienīga</button>

        <div>
            <details open>
                <summary>Redzi ko aizdomīgu?</summary>
                <textarea name=review></textarea>
            </details>

            <details>
                <summary>Bilde ir nekvalitatīva vai cita problēma?</summary>
                <textarea name=problem></textarea>
            </details>

            <button type=submit name=conclusion value=suspect class=button--suspect>Iesniegt</button>
        </div>

        <footer>
            <div class="progress" data-label="{{$reviewed_percentage}}% pārskatīti" title="Kopā esam pārskatījuši {{$reviewed_percentage}}% bilžu!">
                <div class="value" style="width:{{$reviewed_percentage}}%;"></div>
            </div>

            <div class=footer>
                <button type=submit name=conclusion value=skip class=button--info>Izlaist šo bildi</button>

                <button type=button class="js-show-infobox button--info">Atvērt pamācību</button>
            </div>
        </footer>
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

<script type=module>
import Zoomist from 'https://cdn.jsdelivr.net/npm/zoomist@2/zoomist.js'

const zoomistOverlay = document.querySelector('.zoomist-wrapper')

// Find the scale that's needed to zoom img to 100%. We'll allow to scale 4 times more.
const widthScale = {{$exif['COMPUTED']['Width'] ?? 0}} / zoomistOverlay.clientWidth
const heightScale = {{$exif['COMPUTED']['Height'] ?? 0}} / zoomistOverlay.clientHeight
const imgScale = Math.max(widthScale, heightScale, 2) // 2 will allow at least 8x zooming

const zoomist = new Zoomist('.zoomist-container', {
    zoomer: true,
    slider: true,
    zoomRatio: 0.28,
    maxScale: 3 * imgScale,
    on: {
        zoom(zoomist, scale) {
            if (1 == scale)
                zoomistOverlay.style.cursor = 'unset'
            else
                zoomistOverlay.style.cursor = 'grab'
        },
    },
})

zoomistOverlay.addEventListener('mousedown', () => {
    if (zoomist.transform.scale == 1)
        return

    zoomistOverlay.style.cursor = 'grabbing'
})

zoomistOverlay.addEventListener('mouseup', () => {
    if (zoomist.transform.scale == 1)
        return

    zoomistOverlay.style.cursor = 'grab'
})

const infobox = document.querySelector('.js-infobox')
infobox.querySelectorAll('.js-close').forEach(
    button => button.addEventListener('click', _ => infobox.close())
)
document.querySelector('.js-show-infobox').addEventListener('click', _ => infobox.showModal())
@unless($seenInfobox)
infobox.showModal()
@endunless

const timeStarted = new Date()
const form = document.querySelector('form')
const timeInput = document.querySelector('[name=reviewing_duration_ms]')
form.addEventListener('submit', () => timeInput.value = (new Date()) - timeStarted)
</script>
@endsection
