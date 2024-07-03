<!DOCTYPE html>
<html lang={{app()->getLocale()}}>
<meta charset=utf-8>
<meta name=viewport content="width=device-width, initial-scale=1">

<title>Attēlu pārskatīšana Annas meklēšanai</title>
<meta name=title content="Attēlu pārskatīšana Annas meklēšanai">
<meta name=description content="Pārskatām apkārtnes bildes, lai noskaidrotu, kas un kur noticis ar Annu">
<meta property=og:type content=website>
<meta property=og:url content="{{url()->full()}}">
<meta property=og:title content="Attēlu pārskatīšana Annas meklēšanai">
<meta property=og:description content="Pārskatām apkārtnes bildes, lai noskaidrotu, kas un kur noticis ar Annu">
<meta property=og:image content="{{url('card.jpg')}}">
<meta property=og:locale content=lv_LV>

<meta name=twitter:card content=summary_large_image>
<meta name=twitter:url content="{{url()->full()}}">
<meta name=twitter:title content="Attēlu pārskatīšana Annas meklēšanai">
<meta name=twitter:description content="Pārskatām apkārtnes bildes, lai noskaidrotu, kas un kur noticis ar Annu">
<meta name=twitter:image content="{{url('card.jpg')}}">

<link rel=apple-touch-icon sizes=180x180 href=/apple-touch-icon.png>
<link rel=icon type=image/png sizes=32x32 href=/favicon-32x32.png>
<link rel=icon type=image/png sizes=16x16 href=/favicon-16x16.png>
<link rel=manifest href=/site.webmanifest>

@foreach(LaravelLocalization::getSupportedLocales() as $loc => $props)
@if($loc !== app()->getLocale())
<link
    rel=alternate
    hreflang={{$loc}}
    href="{{LaravelLocalization::getLocalizedURL($loc)}}"
>
@endif
@endforeach

@yield('head')

@if(config('services.matomo.url'))
<script>
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  _paq.push(['disableCookies']);
  (function() {
    var u="{{config('services.matomo.url')}}";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '{{config('services.matomo.site_id')}}']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
@endif

@yield('body')
