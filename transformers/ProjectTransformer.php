<?php

namespace app\transformers;

use app\entities\models\Project;

class ProjectTransformer extends BaseTransformer
{
    /**
     * @param Project $project
     *
     * @return array
     */
    public function transform(Project $project)
    {
        return [
            'id' => $project->id,
            'name' => $project->name
        ];
    }
}