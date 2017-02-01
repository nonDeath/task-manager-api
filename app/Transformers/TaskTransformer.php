<?php

namespace App\Transformers;

use App\Priority;
use App\Task;
use App\Transformers\PriorityTransformer;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'priority',
        'createdBy',
        'assignedTo'
    ];

    protected $defaultIncludes = [
        'priority'
    ];

    public function transform(Task $task)
    {
        return $task->getAttributes();
    }

    public function includePriority(Task $task)
    {
        $priority = $task->priority;
        return $this->item($priority, new PriorityTransformer);
    }

    public function includeCreatedBy(Task $task)
    {
        $user = $task->createdBy;
        return $this->item($user, new UserTransformer);
    }

    public function includeAssignedTo(Task $task)
    {
        $user = $task->assignedTo;
        if (! $user) {
            return;
        }
        return $this->item($user, new UserTransformer);
    }
}
