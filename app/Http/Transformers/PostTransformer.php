<?php

namespace Rogue\Http\Transformers;

use Rogue\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * Transform resource data.
     *
     * @param \Rogue\Models\Photo $photo
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'signup_id' => $post->signup_id,
            'northstar_id' => $post->northstar_id,
            'media' => [
                'url' => $post->url,
                'caption' => $post->caption,
            ],
            // @TODO: add the below line in when we use the transformer in the /tags endpoint.
            // 'tagged' => $post->tagNames(),
            'status' => $post->status,
            'source' => $post->source,
            'remote_addr' => $post->remote_addr,
            'created_at' => $post->created_at->toIso8601String(),
            'updated_at' => $post->updated_at->toIso8601String(),
        ];
    }
}
