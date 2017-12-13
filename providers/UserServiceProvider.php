<?php

namespace app\providers;

use app\entities\repositories\Api\UserRepository;
use app\entities\repositories\UserRepositoryInterface;
use app\services\UserService;
use GuzzleHttp\Client;
use Yii;
use yii\base\BootstrapInterface;

class UserServiceProvider implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$container->setSingleton(UserRepositoryInterface::class, function () {
            /** @var Client $http */
            $http = Yii::$container->get(Client::class);

            return new UserRepository($http);
        });

        Yii::$container->setSingleton(UserService::class, function () {
            /** @var UserRepositoryInterface $UserRepository */
            $UserRepository = Yii::$container->get(UserRepositoryInterface::class);

            return new UserService($UserRepository);
        });
    }
}