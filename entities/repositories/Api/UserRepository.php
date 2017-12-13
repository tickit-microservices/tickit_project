<?php

namespace app\entities\repositories\Api;

use app\entities\models\User;
use app\entities\repositories\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function findByIds($userIds = [])
    {
        $url = $this->getBaseUrl() . '/' . 'users';

        $response = $this->http->get($url);

        $data = json_decode($response->getBody());

        return collect($data->data)->map(function($userData) {
            return new User((array) $userData);
        })->all();
    }

    private function getBaseUrl()
    {
        return getenv('USER_SERVICE_URL');
    }
}