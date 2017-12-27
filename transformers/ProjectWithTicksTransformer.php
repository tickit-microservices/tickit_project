<?php

namespace app\transformers;

use app\entities\models\Project;

class ProjectWithTicksTransformer extends BaseTransformer
{
    /**
     * @param Project $project
     *
     * @return array
     */
    public function transform(Project $project)
    {
        $ticks = [];

        if ($project->ticksInAMonth) {
            foreach ($project->ticksInAMonth as $tick) {
                $ticks[] = [
                    'id' => $tick->id,
                    'user' => $tick->user,
                    'created' => $tick->created,
                    'createdBy' => $tick->createdByUser
                ];
            }
        }

        return [
            'id' => $project->id,
            'name' => $project->name,
            'ticks' => $ticks
        ];
    }
}