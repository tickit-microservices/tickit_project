<?php

namespace app\controllers;

use app\services\TickService;
use app\transformers\TickTransformer;
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
     * TickController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param Manager $manager
     * @param TickService $tickService
     * @param TickTransformer $tickTransformer
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        Manager $manager,
        TickService $tickService,
        TickTransformer $tickTransformer,
        array $config = []
    ) {
        parent::__construct($id, $module, $manager, $config);

        $this->tickService = $tickService;
        $this->tickTransformer = $tickTransformer;
    }

    /**
     * List ticks
     *
     * @return array
     */
    public function actionIndex()
    {
        $projectId = $this->request->get('project_id');
        $userId = $this->request->get('user_id');
        $month = $this->request->get('month');
        $year = $this->request->get('year');

        $ticks = $this->tickService->findByProjectId($projectId, $month, $year, $userId);

        $tickCollection = new Collection($ticks, $this->tickTransformer);

        return $this->responseCollection($tickCollection);
    }
}