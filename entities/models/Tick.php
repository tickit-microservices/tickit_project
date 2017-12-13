<?php

namespace app\entities\models;

class Tick extends BaseActiveRecord
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var User
     */
    public $createdByUser;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticks';
    }

    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }
}