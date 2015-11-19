<?php

namespace CSI_UKSW\Laravel\CAS;

class CASManager
{
    private $config;
    private $auth;
    private $connection;

    /**
     * Init CASManager
     */
    function __construct()
    {
        $this->config = config('cas');
        $this->auth = app('auth');
    }

    /**
     * Dynamically pass methods to the default connection.
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->connection(), $method], $parameters);
    }

    /**
     * Establish connection
     *
     * @return CASAuthentication
     */
    public function connection()
    {
        $this->connection = isset($this->connection) ? $this->connection : new CASAuthentication($this->config,
            $this->auth);

        return $this->connection;
    }
}