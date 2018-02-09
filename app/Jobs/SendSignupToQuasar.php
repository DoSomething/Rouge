<?php

namespace Rogue\Jobs;

use Rogue\Models\Signup;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSignupToQuasar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The signup to send to Quasar via Blink.
     *
     * @var Signup
     */
    protected $signup;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Signup $signup)
    {
        $this->signup = $signup;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Format payload
        $payload = $this->signup->toQuasarPayload();

        // Send to Quasar
        gateway('blink')->post('v1/events/quasar-relay', $payload);

        // Log
        info('Signup ' . $this->signup->id . ' sent to Quasar');
    }
}