<?php

namespace app\entities\repositories;

use app\entities\models\Project;

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
}