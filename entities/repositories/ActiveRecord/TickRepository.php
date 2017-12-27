<?php

namespace app\entities\repositories\ActiveRecord;

use app\entities\repositories\TickRepositoryInterface;

/**
 * Class TickRepository
 *
 * @deprecated
 * @package app\entities\repositories\ActiveRecord
 */
class TickRepository extends BaseRepository implements TickRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function findUsersMissTickingByProject(int $projectId, string $day)
    {
        return \Yii::$app->db->createCommand("
            SELECT user_id FROM user_projects WHERE project_id = 1 AND user_id NOT IN (
              SELECT user_id FROM ticks WHERE project_id = :projectId AND DATE_FORMAT(created, '%Y-%m-%d') = :day
            )")
            ->bindValues([
                ':projectId' => $projectId,
                ':day' => $day
            ])
            ->queryAll();
    }
}