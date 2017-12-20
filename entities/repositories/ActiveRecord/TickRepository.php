<?php

namespace app\entities\repositories\ActiveRecord;

use app\entities\repositories\TickRepositoryInterface;

class TickRepository extends BaseRepository implements TickRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function findByProjectId(int $projectId, int $month, int $year, int $userId = null)
    {
        $minDay = '01';
        $maxDay = '31';

        $minDate = $year . '-' . $month . '-' . $minDay . ' 00:00:00';
        $maxDate = $year . '-' . $month . '-' . $maxDay . ' 23:59:59';

        return $this->model->find()
                ->where(['project_id' => $projectId])
                ->andWhere('created >= :minDate', [':minDate' => $minDate])
                ->andWhere('created <= :maxDate', [':maxDate' => $maxDate])
                ->andFilterWhere(['user_id' => $userId])
                ->all();
    }
}