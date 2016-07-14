<?php

namespace Flugg\Responder\Facades;

use Flugg\Responder\Contracts\Responder;
use Illuminate\Support\Facades\Facade;

/**
 * An optional facade you can register to quickly access the responder service.
 *
 * @package Laravel Responder
 * @author  Alexander Tømmerås <flugged@gmail.com>
 * @license The MIT License
 */
class ApiResponse extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Responder::class;
    }
}