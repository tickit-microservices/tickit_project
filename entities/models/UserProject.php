<?php

namespace app\entities\models;

class UserProject extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_projects';
    }
}