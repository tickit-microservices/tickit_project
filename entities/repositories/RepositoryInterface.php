<?php

namespace app\entities\repositories;

use yii\db\ActiveRecord;


/**
 * Interface RepositoryInterface
 *
 * @todo Remove the ActiveRecord param hint
 *
 * @package app\entities\repositories
 */
interface RepositoryInterface
{
    /**
     * Return main model class of this repository
     *
     * @return ActiveRecord
     */
    public function getModel();

    /**
     *
     * @param ActiveRecord $model
     * @param bool $runValidation
     *
     * @return mixed
     */
    public function save(ActiveRecord $model, $runValidation = true);

    /**
     * @param ActiveRecord $model
     *
     * @return mixed
     */
    public function delete(ActiveRecord $model);

    /**
     * @param array $conditions
     * @param int $page
     * @param int $pageSize
     *
     * @return mixed
     */
    public function paginate($conditions = [], $page = 1, $pageSize = 20);

    /**
     * @param array $conditions
     *
     * @return mixed
     */
    public function findOne($conditions = []);
}