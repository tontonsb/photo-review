<!DOCTYPE html>
<html lang=lv>
<meta charset=utf-8>
<meta name=viewport content="width=device-width, initial-scale=1">
@vite(['resources/css/app.css'])

<title>Attēlu pārskatītājs</title>
<meta name=title content="Attēlu pārskatītājs">
<meta name=description content="Pārskatām apkārtnes bildes, lai noskaidrotu, kas un kur noticis ar Annu">
<meta property=og:type content=website>
<meta property=og:url content="{{url()->full()}}">
<meta property=og:title content="Attēlu pārskatītājs">
<meta property=og:description content="Pārskatām apkārtnes bildes, lai noskaidrotu, kas un kur noticis ar Annu">
<meta property=og:image content="{{url('card.jpg')}}">

<meta name=twitter:card content=summary_large_image>
<meta name=twitter:url content="{{url()->full()}}">
<meta name=twitter:title content="Attēlu pārskatītājs Annas meklēšanai">
<meta name=twitter:description content="Pārskatām apkārtnes bildes, lai noskaidrotu, kas un kur noticis ar Annu">
<meta name=twitter:image content="{{url('card.jpg')}}">

<link rel=apple-touch-icon sizes=180x180 href=/apple-touch-icon.png>
<link rel=icon type=image/png sizes=32x32 href=/favicon-32x32.png>
<link rel=icon type=image/png sizes=16x16 href=/favicon-16x16.png>
<link rel=manifest href=/site.webmanifest>

@yield('head')

@yield('body')
