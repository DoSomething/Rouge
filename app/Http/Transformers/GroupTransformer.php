<?php

namespace Rogue\Http\Transformers;

use Rogue\Models\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract
{
    /**
     * Transform resource data.
     *
     * @param \Rogue\Models\Group $group
     * @return array
     */
    public function transform(Group $group)
    {
        return [
            'id' => $group->id,
            'group_type_id' => $group->group_type_id,
            'name' => $group->name,
            'goal' => $group->goal,
            'created_at' => $group->created_at->toIso8601String(),
            'updated_at' => $group->updated_at->toIso8601String(),
        ];
    }
}