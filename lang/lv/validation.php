<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute ir jābūt apstiprinātam.',
    'accepted_if' => 'The :attribute field must be accepted when :other is :value.',
    'active_url' => ':attribute nav derīgs vietrādis (URL).',
    'after' => ':attribute ir jābūt datumam pēc :date.',
    'after_or_equal' => 'The :attribute field must be a date after or equal to :date.',
    'alpha' => ':attribute var saturēt tikai burtus.',
    'alpha_dash' => ':attribute var saturēt tikai burtus, ciparus un svītras (domuzīmes).',
    'alpha_num' => ':attribute var saturēt tikai burtus un ciparus.',
    'array' => ':attribute ir jābūt masīvam.',
    'ascii' => 'The :attribute field must only contain single-byte alphanumeric characters and symbols.',
    'before' => ':attribute ir jābūt datumam pirms :date.',
    'before_or_equal' => 'The :attribute field must be a date before or equal to :date.',
    'between' => [
        'numeric' => ':attribute ir jābūt starp :min un :max.',
        'file' => ':attribute ir jābūt starp :min un :max kilobaitiem.',
        'string' => ':attribute ir jābūt starp :min un :max rakstzīmēm.',
        'array' => ':attribute ir jāsatur starp :min un :max elementiem.',
    ],
    'boolean' => ':attribute ir jābūt patiesam vai aplamam.',
    'can' => 'The :attribute field contains an unauthorized value.',
    'confirmed' => ':attribute apstiprinājums nesakrīt.',
    'current_password' => 'Parole nav pareiza',
    'date' => ':attribute nav derīgs datums.',
    'date_equals' => 'The :attribute field must be a date equal to :date.',
    'date_format' => ':attribute formāts neatbilst formātam :format.',
    'decimal' => 'The :attribute field must have :decimal decimal places.',
    'declined' => 'The :attribute field must be declined.',
    'declined_if' => 'The :attribute field must be declined when :other is :value.',
    'different' => ':attribute un :other ir jābūt atšķirīgiem.',
    'digits' => ':attribute ir jābūt :digits cipariem.',
    'digits_between' => ':attribute ir jābūt starp :min starp :max cipariem.',
    'dimensions' => 'The :attribute field has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'doesnt_end_with' => 'The :attribute field must not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute field must not start with one of the following: :values.',
    'email' => ':attribute ir jābūt derīgai e-pasta adresei.',
    'ends_with' => 'The :attribute field must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'Izvēlētais :attribute nav derīgs.',
    'extensions' => 'The :attribute field must have one of the following extensions: :values.',
    'file' => 'The :attribute field must be a file.',
    'filled' => 'Lauks :attribute ir obligāts.',
    'gt' => [
        'array' => 'The :attribute field must have more than :value items.',
        'file' => 'The :attribute field must be greater than :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than :value.',
        'string' => 'The :attribute field must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute field must have :value items or more.',
        'file' => 'The :attribute field must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than or equal to :value.',
        'string' => 'The :attribute field must be greater than or equal to :value characters.',
    ],
    'hex_color' => 'The :attribute field must be a valid hexadecimal color.',
    'image' => ':attribute ir jābūt attēlam.',
    'in' => 'Izvēlētais :attribute nav derīgs.',
    'in_array' => 'The :attribute field must exist in :other.',
    'integer' => ':attribute ir jābūt veselam skaitlim.',
    'ip' => ':attribute ir jābūt derīgai IP adresei.',
    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    'json' => ':attribute ir jābūt derīgai JSON virknei.',
    'list' => 'The :attribute field must be a list.',
    'lowercase' => 'The :attribute field must be lowercase.',
    'lt' => [
        'array' => 'The :attribute field must have less than :value items.',
        'file' => 'The :attribute field must be less than :value kilobytes.',
        'numeric' => 'The :attribute field must be less than :value.',
        'string' => 'The :attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute field must not have more than :value items.',
        'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be less than or equal to :value.',
        'string' => 'The :attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute field must be a valid MAC address.',
    'max' => [
        'array' => ':attribute nevar saturēt vairāk nekā :max elementus.',
        'file' => ':attribute nevar būt lielāks par :max kilobaitiem.',
        'numeric' => ':attribute nevar būt lielāks nekā :max.',
        'string' => ':attribute nevar būt lielāks par :max rakstzīmēm.',
    ],
    'max_digits' => 'The :attribute field must not have more than :max digits.',
    'mimes' => ':attribute ir jābūt ar faila tipu: :values.',
    'mimetypes' => 'The :attribute field must be a file of type: :values.',
    'min' => [
        'array' => ':attribute ir jāsatur vismaz :min elementus.',
        'file' => ':attribute ir jābūt vismaz :min kilobaitiem.',
        'numeric' => ':attribute ir jābūt vismaz :min.',
        'string' => ':attribute ir jābūt vismaz :min rakstzīmēm.',
    ],
    'min_digits' => 'The :attribute field must have at least :min digits.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'The :attribute field must be a multiple of :value.',
    'not_in' => 'Izvēlētāis :attribute ir nederīgs.',
    'not_regex' => 'The :attribute field format is invalid.',
    'numeric' => ':attribute ir jābūt skaitlim.',
    'password' => [
        'letters' => 'The :attribute field must contain at least one letter.',
        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => 'The :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'The :attribute field must be present.',
    'present_if' => 'The :attribute field must be present when :other is :value.',
    'present_unless' => 'The :attribute field must be present unless :other is :value.',
    'present_with' => 'The :attribute field must be present when :values is present.',
    'present_with_all' => 'The :attribute field must be present when :values are present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => ':attribute formāts ir nederīgs.',
    'required' => 'Lauks :attribute ir obligāts.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'Lauks :attribute ir obligāts, kad :other ir :value.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_if_declined' => 'The :attribute field is required when :other is declined.',
    'required_unless' => 'Lauks :attribute ir obligāts, izņemot ja :other satur :values.',
    'required_with' => 'Lauks :attribute ir obligāts, kad :values ir aizpildīts.',
    'required_with_all' => 'Lauks :attribute ir obligāts, kad :values ir aizpildīts.',
    'required_without' => 'Lauks :attribute ir obligāts, kad :values nav aizpildīti.',
    'required_without_all' => 'Lauks :attribute ir obligāts, ja :values nav aizpildīti.',
    'same' => ':attribute un :other ir jāskarīt.',
    'size' => [
        'array' => ':attribute ir jāsatur :size elementi.',
        'file' => ':attribute ir jābūt :size kilobaitiem.',
        'numeric' => ':attribute ir jābūt :size.',
        'string' => ':attribute ir jābūt :size rakstzīmēm.',
    ],
    'starts_with' => 'The :attribute field must start with one of the following: :values.',
    'string' => ':attribute ir jābūt teksta virknei.',
    'timezone' => ':attribute ir jābūt derīgai laika zonai.',
    'unique' => ':attribute jau ir aizņemts.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'The :attribute field must be uppercase.',
    'url' => ':attribute formāts ir nederīgs.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'Vārds',
        'password' => 'Parole',
        'email' => 'E-pasts',
        'old_password' => 'Vecā parole',
        'file' => 'Fails',
    ],

];
