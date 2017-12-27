<?php

namespace app\services;

use app\entities\models\Project;
use app\entities\models\Tick;
use app\entities\models\User;
use app\entities\repositories\ProjectRepositoryInterface;

class ProjectService extends BaseService
{
    /**
     * @var ProjectRepositoryInterface
     */
    protected $repository;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * ProjectService constructor.
     *
     * @param ProjectRepositoryInterface $repository
     * @param UserService $userService
     */
    public function __construct(
        ProjectRepositoryInterface $repository,
        UserService $userService
    ) {
        parent::__construct($repository);

        $this->userService = $userService;
    }

    /**
     * Return all projects
     *
     * @return Project[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Return projects by user
     *
     * @param int $userId
     *
     * @return Project[]
     */
    public function findProjectsByUser(int $userId)
    {
        return $this->repository->findProjectsByUser($userId);
    }

    /**
     * Return all users in a project
     *
     * @param int $projectId
     *
     * @return User[]
     */
    public function findUsersInProject(int $projectId)
    {
        /** @var Project $project */
        $project = $this->repository->findOne(['id' => $projectId]);

        $userIds = collect($project->userProjects)->pluck('user_id')->all();

        return $this->userService->findByIds($userIds);
    }

    /**
     * Join an user to a project
     *
     * @param int $userId
     * @param int $projectId
     *
     * @return bool
     */
    public function join(int $userId, int $projectId)
    {
        return $this->repository->join($userId, $projectId);
    }

    /**
     * Find a project by id and populate all ticks within a month
     *
     * @param int $projectId
     * @param int $year
     * @param int $month
     *
     * @return Project|null
     */
    public function findProjectWithTicks(int $projectId, int $year, int $month)
    {
        /** @var Project $project */
        $project = $this->repository->findOne(['id' => $projectId]);
        $ticks = $this->repository->findTicks($projectId, $year, $month);
        $usersMappedById = $this->getUsersFromTicksMappedById($ticks);

        $tickWithUsers = collect($ticks)->map(function (Tick $tick) use ($usersMappedById) {
            $tick->user = $usersMappedById[$tick->user_id] ?? null;
            $tick->createdByUser = $usersMappedById[$tick->created_by] ?? null;

            return $tick;
        })->all();

        $project->ticksInAMonth = $tickWithUsers;

        return $project;
    }

    /**
     * @param Tick[] $ticks
     *
     * @return array
     */
    private function getUsersFromTicksMappedById($ticks = []): array
    {
        $userIds = collect($ticks)->pluck('user_id')->all();
        $createdByUserIds = collect($ticks)->pluck('created_by')->all();

        $users = $this->userService->findByIds(array_merge($userIds, $createdByUserIds));

        return collect($users)->keyBy('id')->all();
    }
}