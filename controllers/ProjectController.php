<?php

namespace app\controllers;

use app\services\ProjectService;
use app\transformers\ProjectTransformer;
use app\transformers\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use yii\base\Module;

class ProjectController extends BaseController
{
    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @var ProjectTransformer
     */
    private $projectTransformer;

    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * ProjectController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param Manager $manager
     * @param ProjectService $projectService
     * @param ProjectTransformer $projectTransformer
     * @param UserTransformer $userTransformer
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        Manager $manager,
        ProjectService $projectService,
        ProjectTransformer $projectTransformer,
        UserTransformer $userTransformer,
        array $config = []
    ) {
        parent::__construct($id, $module, $manager, $config);

        $this->projectService = $projectService;
        $this->projectTransformer = $projectTransformer;
        $this->userTransformer = $userTransformer;
    }

    /**
     * List all projects
     *
     * @return array
     */
    public function actionIndex()
    {
        $projects = $this->projectService->findAll();

        $projectCollection = new Collection($projects, $this->projectTransformer);

        return $this->responseCollection($projectCollection);
    }

    /**
     * List projects of an user
     *
     * @param string $userId
     *
     * @return array
     */
    public function actionByUser($userId)
    {
        $projects = $this->projectService->findProjectsByUser((int) $userId);

        $projectCollection = new Collection($projects, $this->projectTransformer);

        return $this->responseCollection($projectCollection);
    }

    /**
     * List all users in a project
     *
     * @param string $projectId
     *
     * @return array
     */
    public function actionUsers($projectId)
    {
        $users = $this->projectService->findUsersInProject((int) $projectId);

        $userCollection = new Collection($users, $this->userTransformer);

        return $this->responseCollection($userCollection);
    }
}