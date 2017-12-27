<?php

namespace app\transformers;

use app\entities\models\Tick;

/**
 * Class TickTransformer
 *
 * @todo Remove this, it should be included in ProjectWithTicksTransformer
 * @deprecated
 * @package app\transformers
 */
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