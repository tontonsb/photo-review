<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Norādītie pieslēgšanās dati nav pareizi.',
    'password' => 'Norādītā parole nav pareiza.',
    'throttle' => 'Pārāk daudz pieslēgšanās mēģinājumu. Mēģini vēl pēc :seconds sekundēm.',

    'login' => 'Pieslēgties',
    'logout' => 'Atslēgties',
    'register' => 'Reģistrēties',

    'name' => 'Vārds',
    'email' => 'Epasts',
    'password' => 'Parole',
    'password confirmation' => 'Parole vēlreiz',
    'remember' => 'Atcerēties mani',
    'forgot' => 'Aizmirsi paroli?',

    'registration description' => <<<DESCRIPTION
        ### Kāpēc reģistrēties?

        Pēc piereģistrēšanās varēsi savam kontam piesaistīt pārskatīšanas progresu.
        Tas nodrošinās, ka to nepazaudēsi arī notīrot sīkdatnes vai mainot pārlūku vai ierīci.

        Tas ir izdevīgi arī tad, ja pārskatīšanu veic uz vairākām ierīcēm — progress
        skaitīsies kopīgi un vienā ierīce izskatītais netiks rādīts citā.

        ### Kas notiks ar iesniegtajiem datiem?

        Lietotnes turētājiem ir redzami norādītie lietotāju vārdi un epasti.
        Epasts nepieciešamības gadījumā var tikt izmantots, lai sazinātos ar pārskatītāju par kādu noteiktu pārskatījumu.
        Paroles pirms saglabāšanas tiek apstrādātas ar
        <a href="https://en.wikipedia.org/wiki/Cryptographic_hash_function">jaucējfunkciju</a> un tiek saglabāta tikai
        jaucējvērtība, pēc kuras nevar uzzināt norādīto paroli.

        Nekādām reklāmu vajadzībām ievadītā informācija izmantota netiks,
        kā arī tā netiks publicēta vai nodota citām personām,
        izņemot gadījumus, kad to darīt liks likums.
        DESCRIPTION
];
