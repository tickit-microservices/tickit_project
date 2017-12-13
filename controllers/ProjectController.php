<?php

namespace app\controllers;

use app\services\ProjectService;
use app\transformers\ProjectTransformer;
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
     * ProjectController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param Manager $manager
     * @param ProjectService $projectService
     * @param ProjectTransformer $projectTransformer
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        Manager $manager,
        ProjectService $projectService,
        ProjectTransformer $projectTransformer,
        array $config = []
    ) {
        parent::__construct($id, $module, $manager, $config);

        $this->projectService = $projectService;
        $this->projectTransformer = $projectTransformer;
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
}