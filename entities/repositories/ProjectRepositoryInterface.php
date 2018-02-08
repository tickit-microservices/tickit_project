<?php

namespace app\entities\repositories;

use app\entities\models\Project;
use app\entities\models\Tick;

interface ProjectRepositoryInterface extends RepositoryInterface
{
    /**
     * Return all projects
     *
     * @return Project[]
     */
    public function findAll();

    /**
     * Return projects of an user
     *
     * @param int $userId
     *
     * @return Project[]
     */
    public function findProjectsByUser(int $userId);

    /**
     * Join an user to a project
     *
     * @param int $userId
     * @param int $projectId
     *
     * @return bool
     */
    public function join(int $userId, int $projectId);

    /**
     * Find ticks of a project within a month
     *
     * @param int $projectId
     * @param int $year
     * @param int $month
     *
     * @return Tick[]
     */
    public function findTicks(int $projectId, int $year, int $month);

    /**
     * Find tick by its Id
     *
     * @param int $tickId
     *
     * @return Tick|null
     */
    public function findTickById(int $tickId);

    /**
     * Find all ticks within a day
     *
     * @param $date
     *
     * @return Tick[]
     */
    public function findTicksByDate($date);

    /**
     * Remove tick by its Id
     *
     * @param Tick $tick
     *
     * @return bool
     */
    public function removeTick(Tick $tick);

    /**
     * Find an existing tick
     *
     * @param int $projectId
     * @param int $userId
     * @param string $date
     *
     * @return Tick|null
     */
    public function findExistingTick(int $projectId, int $userId, string $date);
}