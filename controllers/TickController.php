<?php

namespace app\controllers;

use app\services\TickService;
use app\transformers\TickTransformer;
use app\transformers\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use yii\base\Module;

class TickController extends BaseController
{
    /**
     * @var TickService
     */
    private $tickService;

    /**
     * @var TickTransformer
     */
    private $tickTransformer;

    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * TickController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param Manager $manager
     * @param TickService $tickService
     * @param TickTransformer $tickTransformer
     * @param UserTransformer $userTransformer
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        Manager $manager,
        TickService $tickService,
        TickTransformer $tickTransformer,
        UserTransformer $userTransformer,
        array $config = []
    ) {
        parent::__construct($id, $module, $manager, $config);

        $this->tickService = $tickService;
        $this->tickTransformer = $tickTransformer;
        $this->userTransformer = $userTransformer;
    }

    /**
     * List all users forget ticking by project
     *
     * @return array
     */
    public function actionForgetTicking()
    {
        $projectId = $this->request->get('project_id');
        $day = $this->request->get('day');

        $users = $this->tickService->findUsersMissTickingByProject((int) $projectId, $day);

        $userCollection = new Collection($users, $this->userTransformer);

        return $this->responseCollection($userCollection);
    }
}