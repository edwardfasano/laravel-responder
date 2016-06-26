<?php

namespace Mangopixel\Responder;

use Illuminate\Http\JsonResponse;
use Mangopixel\Responder\Contracts\Respondable;

/**
 *
 *
 * @package Laravel Responder
 * @author  Alexander Tømmerås <flugged@gmail.com>
 * @license The MIT License
 */
trait RespondsWithJson
{
    /**
     *
     *
     * @param  mixed $data
     * @param  int   $statusCode
     * @return JsonResponse
     */
    public function successResponse( $data, int $statusCode = 200 ):JsonResponse
    {
        return app( Respondable::class )->generateResponse( $data, $statusCode );
    }
}