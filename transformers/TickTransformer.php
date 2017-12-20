<?php

namespace app\transformers;

use app\entities\models\Tick;

class TickTransformer extends BaseTransformer
{
    public function transform(Tick $tick)
    {
        return [
            'id' => $tick->id,
            'projectId' => $tick->project_id,
            'user' => $tick->user,
            'created' => $tick->created,
            'createdBy' => $tick->createdByUser
        ];
    }
}