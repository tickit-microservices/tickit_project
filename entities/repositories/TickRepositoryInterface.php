<?php

namespace app\entities\repositories;

/**
 * Interface TickRepositoryInterface
 *
 * @deprecated
 * @package app\entities\repositories
 */
interface TickRepositoryInterface extends RepositoryInterface
{
    /**
     * Return list users forget ticking by project
     *
     * @param int $projectId
     * @param string $day
     *
     * @return int[]
     */
    public function findUsersMissTickingByProject(int $projectId, string $day);
}