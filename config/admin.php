<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Usuario Administrador
    |--------------------------------------------------------------------------
    |
    | Datos de la cuenta raiz que crea AdminUserSeeder. Todos se leen del .env
    | para que ninguna credencial quede escrita en el codigo.
    |
    */

    'email' => env('ADMIN_EMAIL'),

    'password' => env('ADMIN_PASSWORD'),

    'name' => env('ADMIN_NAME', 'Administrador'),

    'last_name' => env('ADMIN_LAST_NAME', 'Sistema'),

    'document_number' => env('ADMIN_DOCUMENT_NUMBER'),

];