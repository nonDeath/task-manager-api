<?php

namespace App\Transformers;

use App\Priority;
use League\Fractal\TransformerAbstract;

class PriorityTransformer extends TransformerAbstract
{
    public function transform(Priority $priority)
    {
        return [
            'id' => $priority->id,
            'name' => $priority->name,
        ];
    }
}
