@extends('layout')

@section('content')
<form method=post action="{{route('register')}}">
    @csrf

    <label>
        Vārds
        <input name=name value="{{old('name')}}" required autofocus autocomplete=name>
        @error('name')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        Epasts
        <input type=email name=email value="{{old('email')}}" required autocomplete=username >
        @error('email')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        Parole
        <input type=password name=password required autocomplete=new-password >
        @error('password')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        Parole vēlreiz
        <input type=password name=password_confirmation required autocomplete=new-password >
        @error('password_confirmation')
            <small>{{$message}}</small>
        @enderror
    </label>

    <button type=submit>Reģistrēties</button>
</form>

<article>
    <h3>Kāpēc reģistrēties?</h3>
    <p>Pēc piereģistrēšanās varēsi savam kontam piesaistīt pārskatīšanas progresu. Tas nodrošinās, ka to nepazaudēsi arī notīrot sīkdatnes vai mainot pārlūku vai ierīci.
    <p>Tas ir izdevīgi arī tad, ja pārskatīšanu veic uz vairākām ierīcēm — progress skaitīsies kopīgi un vienā ierīce izskatītais netiks rādīts citā.

    <h3>Kas notiks ar iesniegtajiem datiem?</h3>
    <p>Lietotnes turētājiem ir redzami norādītie lietotāju vārdi un epasti.
    Epasts nepieciešamības gadījumā var tikt izmantots, lai sazinātos ar pārskatītāju par kādu noteiktu pārskatījumu.
    Paroles pirms saglabāšanas tiek apstrādātas ar <a href="https://en.wikipedia.org/wiki/Cryptographic_hash_function">jaucējfunkciju</a> un tiek saglabāta tikai jaucējvērtība, pēc kuras nevar uzzināt norādīto paroli.

    <p>Nekādām reklāmu vajadzībām ievadītā informācija izmantota netiks, kā arī tā netiks publicēta vai nodota citām personām, izņemot gadījumus, kad to darīt liks likums.
</article>
@endsection
