<?php

namespace app\services;

use app\entities\models\Tick;
use app\entities\repositories\TickRepositoryInterface;

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
     * List ticks by project
     *
     * @param int $projectId
     * @param int $month
     * @param int $year
     * @param int|null $userId
     *
     * @return Tick[]
     */
    public function findByProjectId(int $projectId, int $month, int $year, int $userId = null)
    {
        $ticks = $this->repository->findByProjectId($projectId, $month, $year, $userId);

        $usersMappedById = $this->getUsersFromTicksMappedById($ticks);

        return collect($ticks)->map(function (Tick $tick) use ($usersMappedById) {
            $tick->user = $usersMappedById[$tick->user_id] ?? null;
            $tick->createdByUser = $usersMappedById[$tick->created_by] ?? null;

            return $tick;
        })->all();
    }

    /**
     * @param Tick[] $ticks
     *
     * @return array
     */
    private function getUsersFromTicksMappedById($ticks): array
    {
        $userIds = collect($ticks)->pluck('user_id')->all();
        $createdByUserIds = collect($ticks)->pluck('created_by')->all();

        $users = $this->userService->findByIds(array_merge($userIds, $createdByUserIds));

        return collect($users)->keyBy('id')->all();
    }
}