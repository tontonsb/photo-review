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

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'login' => 'Login',
    'logout' => 'Logout',
    'register' => 'Register',

    'name' => 'Name',
    'email' => 'Email',
    'password' => 'Password',
    'password confirmation' => 'Confirm password',
    'remember' => 'Remember me',
    'forgot' => 'Forgot your password?',

    'registration description' => <<<'DESCRIPTION'
        ### Why should one register?

        You'll be able to bind your reviewing progress to your account once you register.
        It will ensure you won't lose the progress even if you clear cookies or swap devices.

        It can also be useful if you do the reviews on multiple devices — you can link all of
        them to the same account and the progress will count together, the images already reviewed
        on one device will not be shown to you on another.

        ### What happens to the data I submit?

        The owners of the app can see the submitted names and emails.
        In some cases the email address may be used to contact the reviewer about a particular review.
        Passwords are <a href="https://en.wikipedia.org/wiki/Cryptographic_hash_function">hashed</a> before saving and only a hash value is stored.

        The submitted info will not be used for any marketing or advertising purposes.
        It will not be published or handed to another parties, except for cases where the law forces us to hand over the information.
        DESCRIPTION
];
