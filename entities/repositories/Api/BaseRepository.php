<?php

namespace app\entities\repositories\Api;

use GuzzleHttp\Client;

class BaseRepository
{
    /**
     * @var Client
     */
    protected $http;

    /**
     * BaseRepository constructor.
     *
     * @param Client $http
     */
    public function __construct(Client $http)
    {
        $this->http = $http;
    }
}