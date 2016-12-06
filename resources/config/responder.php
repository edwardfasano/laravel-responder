<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Serializer Class Path
    |--------------------------------------------------------------------------
    |
    | The full class path to the serializer class you would like the package
    | to use when generating successful JSON responses. You may change it
    | to one of Fractal's serializers or create a custom one yourself.
    |
    */

    'serializer' => Flugg\Responder\Serializers\ApiSerializer::class,

    /*
    |--------------------------------------------------------------------------
    | Include Status Code
    |--------------------------------------------------------------------------
    |
    | Wether or not you want to include status codes in your JSON responses.
    | If true the status code is prepended to both your success and error
    | responses. This takes place right after your data is serialized.
    |
    */

    'include_status_code' => true,

    /*
    |--------------------------------------------------------------------------
    | Load Relations From Parameter
    |--------------------------------------------------------------------------
    |
    | The responder will automatically parse and load relations from a query
    | string parameter if the value below is a string value. If you don't
    | want the package to auto load relations, you can set it to null.
    |
    */

    'load_relations_from_parameter' => 'include',

    /*
    |--------------------------------------------------------------------------
    | Error Presets
    |--------------------------------------------------------------------------
    |
    | These errors serve as presets to stop the continuous repetition of
    | error codes and status messages.
    |
    | Using them is as easy as follows:
    | return responder()->error('access_denied');
    |
    */

    'errors' => [
        // 'access_denied' => [
        //     'errorCode'  => 'ERR-ACCESS-DENIED',
        //     'statusCode' => 403,
        //     'message'    => 'Access Denied',
        // ],
    ]

];
