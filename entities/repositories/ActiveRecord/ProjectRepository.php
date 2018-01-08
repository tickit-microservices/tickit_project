<?php

namespace app\entities\repositories\ActiveRecord;

use app\entities\models\Project;
use app\entities\models\Tick;
use app\entities\models\UserProject;
use app\entities\repositories\ProjectRepositoryInterface;
use yii\db\Expression;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    /**
     * @var UserProject
     */
    private $userProjectModel;

    /**
     * @var Tick
     */
    private $tickModel;

    /**
     * ProjectRepository constructor.
     *
     * @param Project $model
     * @param UserProject $userProject
     * @param Tick $tickModel
     */
    public function __construct(Project $model, UserProject $userProject, Tick $tickModel)
    {
        parent::__construct($model);

        $this->userProjectModel = $userProject;
        $this->tickModel = $tickModel;
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
        if ($this->userHasJoinedProject($userId, $projectId)) {
            return true;
        }

        $userProjectModel = new UserProject([
            'user_id' => $userId,
            'project_id' => $projectId
        ]);

        return $userProjectModel->save();
    }

    /**
     * @inheritdoc
     */
    public function findTicks(int $projectId, int $year, int $month)
    {
        $minDay = '01';
        $maxDay = '31';

        $minDate = $year . '-' . $month . '-' . $minDay . ' 00:00:00';
        $maxDate = $year . '-' . $month . '-' . $maxDay . ' 23:59:59';

        return $this->tickModel->find()
            ->where(['project_id' => $projectId])
            ->andWhere('created >= :minDate', [':minDate' => $minDate])
            ->andWhere('created <= :maxDate', [':maxDate' => $maxDate])
            ->all();
    }

    /**
     * @inheritdoc
     */
    public function findTickById(int $tickId)
    {
        return $this->tickModel->find()
            ->where(['id' => $tickId])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function removeTick(Tick $tick)
    {
        return $tick->delete();
    }

    /**
     * @inheritdoc
     */
    public function findExistingTick(int $projectId, int $userId, string $date)
    {
        return $this->tickModel->find()
            ->where(['project_id' => $projectId])
            ->andWhere(['user_id' => $userId])
            ->andWhere(['DATE(created)' => $date])
            ->one();
    }

    /**
     * Check if an user has joined a project or not
     *
     * @param int $userId
     * @param int $projectId
     *
     * @return bool
     */
    private function userHasJoinedProject(int $userId, int $projectId)
    {
        $userProjects = $this->findProjectsByUser($userId);

        foreach ($userProjects as $userProject)
        {
            if ($userProject->id === $projectId) {
                return true;
            }
        }

        return false;
    }
}