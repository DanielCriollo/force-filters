<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;


class WaOfiJob extends SpatieProcessWebhookJob
{
    public function handle()
    {
        $data=array();

        $data = json_decode($this->webhookCall, true)['payload'];
        Log::info($data);
    }
}
