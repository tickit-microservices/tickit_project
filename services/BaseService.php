<?php

namespace app\services;

use app\entities\repositories\RepositoryInterface;
use Exception;

class BaseService
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * BaseService constructor.
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Save a model
     *
     * @param array $data
     * @param bool $runValidation
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function save(array $data, $runValidation = true)
    {
        $modelClass = get_class($this->repository->getModel());

        if (!class_exists($modelClass)) {
            throw new Exception(sprintf("Class '%s' does not exist", $modelClass));
        }

        if (empty($data['id'])) {
            $model = new $modelClass();
        } else {
            $model = $this->findOne(['id' => $data['id']]);
        }

        foreach ($data as $key => $value)
        {
            $model->setAttribute($key, $value);
        }

        return $this->repository->save($model, $runValidation);
    }

    /**
     * @inheritdoc
     */
    public function paginate($conditions = [], $page = 1, $pageSize = 20)
    {
        return $this->repository->paginate($conditions, $page, $pageSize);
    }

    /**
     * @inheritdoc
     */
    public function findOne($conditions)
    {
        return $this->repository->findOne($conditions);
    }
}