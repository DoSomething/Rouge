<?php

namespace Rogue\Repositories;

use Rogue\Models\Event;
use Rogue\Models\Signup;

class SignupRepository
{
    /**
     * Create a signup.
     *
     * @param  array $data
     * @return \Rogue\Models\Signup|null
     */
    public function create($data)
    {
        // Add these values to pass to the Event
        $data['event_type'] = 'signup';
        $data['submission_type'] = 'user';

        // Create the signup event
        $event = Event::create($data);

        // Create the signup
        $signup = $event->signup()->create([
            'event_id' => $event->id,
            'northstar_id' => $data['northstar_id'],
            'campaign_id' => $data['campaign_id'],
            'campaign_run_id' => $data['campaign_run_id'],
            'quantity' => isset($data['quantity']) ? $data['quantity'] : null,
            'quantity_pending' => isset($data['quantity_pending']) ? $data['quantity_pending'] : null,
            'why_participated' => isset($data['why_participated']) ? $data['why_participated'] : null,
            'source' => isset($data['source']) ? $data['source'] : null,
        ]);

        // Let Laravel take care of the timestamps unless they are specified in the request
        // @TODO: keep only the else after the migration
        if (isset($data['created_at'])) {
            // Associate the event with the signup
            $event->signup_id = $signup->id;

            // Set the created_at time
            $signup->created_at = $data['created_at'];
            $event->created_at = $data['created_at'];

            // Set the updated time if provided, if not, assume no updates
            if (isset($data['updated_at'])) {
                $signup->updated_at = $data['updated_at'];
                $event->updated_at = $data['updated_at'];
            } else {
                $signup->updated_at = $data['created_at'];
                $event->updated_at = $data['created_at'];
            }

            $signup->save(['timestamps' => false]);
            $event->save(['timestamps' => false]);
        } else {
            // Now that the signup exists, set the signup_id on the signup event
            $event->signup_id = $signup->id;
            $event->save();
        }

        return $signup;
    }

    /**
     * Get a signup
     *
     * @param  string $northstarId
     * @param  int $campaignId
     * @param  int $campaignRunId
     * @return \Rogue\Models\Signup|null
     */
    public function get($northstarId, $campaignId, $campaignRunId)
    {
        $signup = Signup::where([
            'northstar_id' => $northstarId,
            'campaign_id' => $campaignId,
            'campaign_run_id' => $campaignRunId,
        ])->first();

        return $signup;
    }
}