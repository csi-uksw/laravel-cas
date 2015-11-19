<?php

namespace CSI_UKSW\Laravel\CAS\Facades;

use Illuminate\Support\Facades\Facade;

class CAS extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cas';
    }
}
