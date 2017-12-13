<?php

namespace app\entities\repositories;

use app\entities\models\User;

interface UserRepositoryInterface
{
    /**
     * Return users
     *
     * @param array $userIds
     *
     * @return User[]
     */
    public function findByIds($userIds = []);
}