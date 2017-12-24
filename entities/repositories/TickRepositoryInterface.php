<?php

namespace app\entities\repositories;

use app\entities\models\Tick;

interface TickRepositoryInterface extends RepositoryInterface
{
    /**
     * Return ticks in a project within a month
     *
     * @param int $userId
     * @param int $projectId
     * @param int $month
     * @param int $year
     *
     * @return Tick[]
     */
    public function findByProjectId(int $projectId, int $month, int $year, int $userId = null);

    /**
     * Return list users forget ticking by project
     *
     * @param int $projectId
     * @param int $day
     *
     * @return int[]
     */
    public function findUsersMissTickingByProject(int $projectId, string $day);
}