<?php

namespace app\entities\models;

class UserProject extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_projects';
    }
}