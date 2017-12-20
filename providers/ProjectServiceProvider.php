<?php

namespace app\providers;

use app\entities\models\Project;
use app\entities\models\UserProject;
use app\entities\repositories\ActiveRecord\ProjectRepository;
use app\entities\repositories\ProjectRepositoryInterface;
use app\services\ProjectService;
use app\services\UserService;
use Yii;
use yii\base\BootstrapInterface;

class ProjectServiceProvider implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$container->setSingleton(ProjectRepositoryInterface::class, function () {
            return new ProjectRepository(new Project(), new UserProject());
        });

        Yii::$container->setSingleton(ProjectService::class, function () {
            /** @var ProjectRepositoryInterface $projectRepository */
            $projectRepository = Yii::$container->get(ProjectRepositoryInterface::class);

            /** @var UserService $userService */
            $userService = Yii::$container->get(UserService::class);

            return new ProjectService($projectRepository, $userService);
        });
    }
}