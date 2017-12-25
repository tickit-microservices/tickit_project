<?php

namespace app\services;

use app\entities\models\Project;
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
}