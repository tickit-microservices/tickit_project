<?php

namespace app\transformers;

use app\entities\models\Project;

class ProjectWithUntickedUsersTransformer extends BaseTransformer
{
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * ProjectWithUntickedUsersTransformer constructor.
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

        if ($project->untickedUsers) {
            foreach ($project->untickedUsers as $user) {
                $untickedUsers[] = $this->userTransformer->transform($user);
            }
        }

        return [
            'id' => $project->id,
            'name' => $project->name,
            'unticked-users' => $untickedUsers
        ];
    }
}