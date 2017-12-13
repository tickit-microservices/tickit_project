<?php

namespace app\services;

use app\entities\models\User;
use app\entities\repositories\UserRepositoryInterface;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Find users
     * @param array $userIds
     *
     * @return User[]
     */
    public function findByIds($userIds = [])
    {
        return $this->userRepository->findByIds($userIds);
    }
}