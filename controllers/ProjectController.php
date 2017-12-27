<?php

namespace app\controllers;

use app\services\ProjectService;
use app\services\TickService;
use app\transformers\ProjectTransformer;
use app\transformers\ProjectWithTicksTransformer;
use app\transformers\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use yii\base\Module;

class ProjectController extends BaseController
{
    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @var TickService
     */
    private $tickService;

    /**
     * @var ProjectTransformer
     */
    private $projectTransformer;

    /**
     * @var ProjectWithTicksTransformer
     */
    private $projectWithTicksTransformer;

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
     * @param TickService $tickService
     * @param ProjectTransformer $projectTransformer
     * @param ProjectWithTicksTransformer $projectWithTicksTransformer
     * @param UserTransformer $userTransformer
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        Manager $manager,
        ProjectService $projectService,
        TickService $tickService,
        ProjectTransformer $projectTransformer,
        ProjectWithTicksTransformer $projectWithTicksTransformer,
        UserTransformer $userTransformer,
        array $config = []
    ) {
        parent::__construct($id, $module, $manager, $config);

        $this->projectService = $projectService;
        $this->tickService = $tickService;
        $this->projectTransformer = $projectTransformer;
        $this->projectWithTicksTransformer = $projectWithTicksTransformer;
        $this->userTransformer = $userTransformer;
    }

    /**
     * List all projects
     *
     * @return mixed
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
     * @return mixed
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
     * @return mixed
     */
    public function actionUsers($projectId)
    {
        $users = $this->projectService->findUsersInProject((int) $projectId);

        $userCollection = new Collection($users, $this->userTransformer);

        return $this->responseCollection($userCollection);
    }

    /**
     * Join an user to a project
     *
     * @param int $userId
     * @param int $projectId
     *
     * @return mixed
     */
    public function actionJoin($userId, $projectId)
    {
        $this->projectService->join($userId, $projectId);

        $projects = $this->projectService->findProjectsByUser((int) $userId);

        $projectCollection = new Collection($projects, $this->projectTransformer);

        return $this->responseCollection($projectCollection);
    }

    /**
     * List ticks in a project
     *
     * @param int $projectId
     * @param int $year
     * @param int $month
     *
     * @return mixed
     */
    public function actionTicks($projectId, $year, $month)
    {
        $project = $this->projectService->findProjectWithTicks((int)$projectId, (int)$year, (int)$month);

        $projectItem = new Item($project, $this->projectWithTicksTransformer);

        return $this->responseItem($projectItem);
    }
}