<?php

namespace app\entities\models;

/**
 * Class Project
 *
 * @package app\entities\models
 *
 * @property-read UserProject[] $userProjects
 */
class Project extends BaseActiveRecord
{
    /**
     * @var Tick[]
     */
    public $ticksInAMonth = [];

    /**
     * @var User[]
     */
    public $untickedUsers = [];

    /**
     * @var User[]
     */
    public $tickedUsers = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    public function getUserProjects()
    {
        return $this->hasMany(UserProject::class, ['project_id' => 'id']);
    }
}