<?php

namespace app\transformers;

use app\entities\models\Project;

class ProjectWithTickStatistic extends BaseTransformer
{
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * ProjectWithTickStatistic constructor.
     *
     * @param UserTransformer $userTransformer
     */
    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * @param Project $project
     *
     * @return array
     */
    public function transform(Project $project)
    {
        $untickedUsers = [];
        $tickedUsers = [];

        foreach ($project->untickedUsers as $user) {
            $untickedUsers[] = $this->userTransformer->transform($user);
        }

        foreach ($project->tickedUsers as $user) {
            $tickedUsers[] = $this->userTransformer->transform($user);
        }

        return [
            'id' => $project->id,
            'name' => $project->name,
            'untickedUsers' => $untickedUsers,
            'tickedUsers' => $tickedUsers
        ];
    }
}