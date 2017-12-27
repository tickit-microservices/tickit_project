<?php

namespace app\services;

use app\entities\models\User;
use app\entities\repositories\TickRepositoryInterface;

/**
 * Class TickService
 *
 * @deprecated
 * @package app\services
 */
class TickService extends BaseService
{
    /**
     * @var TickRepositoryInterface
     */
    protected $repository;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * TickService constructor.
     *
     * @param TickRepositoryInterface $repository
     * @param UserService $userService
     */
    public function __construct(
        TickRepositoryInterface $repository,
        UserService $userService
    )
    {
        parent::__construct($repository);

        $this->userService = $userService;
    }

    /**
     * List all users forget ticking by project
     *
     * @todo Move this method to ProjectService
     *
     * @param int $projectId
     * @param string $day
     *
     * @return User[]
     */
    public function findUsersMissTickingByProject(int $projectId, string $day)
    {
        $userIds = $this->repository->findUsersMissTickingByProject($projectId, $day);

        $userIds = collect($userIds)->pluck('user_id')->all();

        return $this->userService->findByIds($userIds);
    }
}