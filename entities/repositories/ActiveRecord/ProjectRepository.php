<?php

namespace app\entities\repositories\ActiveRecord;

use app\entities\models\Project;
use app\entities\models\UserProject;
use app\entities\repositories\ProjectRepositoryInterface;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    /**
     * @var UserProject
     */
    private $userProjectModel;

    /**
     * ProjectRepository constructor.
     *
     * @param Project $model
     * @param UserProject $userProject
     */
    public function __construct(Project $model, UserProject $userProject)
    {
        parent::__construct($model);

        $this->userProjectModel = $userProject;
    }

    /**
     * @inheritdoc
     */
    public function findAll()
    {
        return $this->model->find()->all();
    }

    /**
     * @inheritdoc
     */
    public function findProjectsByUser(int $userId)
    {
        return $this->model
            ->find()
            ->leftJoin(
                $this->userProjectModel->tableName(),
                sprintf('%s.id=%s.project_id', $this->model->tableName(), $this->userProjectModel->tableName())
            )
            ->where(['user_id' => $userId])
            ->all();
    }

    /**
     * @inheritdoc
     */
    public function join(int $userId, int $projectId)
    {
        $userProjectModel = new UserProject([
            'user_id' => $userId,
            'project_id' => $projectId
        ]);

        return $userProjectModel->save();
    }
}