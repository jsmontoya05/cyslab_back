<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\UsesCase\EnviromentSettings\PublishEnvironmentSettingsForLaboratory;
use Illuminate\Support\Facades\Log;

class PublishTemplateOfVirtualMachines implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $data;


    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(
        PublishEnvironmentSettingsForLaboratory $publishEnvironmentSettingsForLaboratory
    ) {
        if ($this->attempts() < 5) {

            try {
                $enviromentSettingsPublished = $publishEnvironmentSettingsForLaboratory->execute(
                    $this->data['labAccountName'],
                    $this->data['laboratoryName'],
                    $this->data['enviromentSettingsName']
                );

                if (isset($enviromentSettingsPublished['content']['error'])) {
                    dispatch(new self($this->data))
                    ->onQueue('default')
                    ->delay(now()
                    ->addMinutes(5));
                }
            } catch (\Exception $th) {
                dispatch(new self($this->data))
                ->onQueue('default')
                ->delay(now()
                ->addMinutes(5));
                Log::error($th);
            }

        } else {
            // delete job
        }
    }
}
