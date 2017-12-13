<?php

namespace app\entities\repositories;

use app\entities\models\Project;

interface ProjectRepositoryInterface extends RepositoryInterface
{
    /**
     * Return projects of an user
     *
     * @param int $userId
     *
     * @return Project[]
     */
    public function findProjectsByUser(int $userId);
}