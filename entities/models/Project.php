<?php

namespace app\entities\models;

class Project extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }
}