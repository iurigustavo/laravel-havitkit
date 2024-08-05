<?php

namespace App\Livewire\Settings\ActivityLog;

use Livewire\Attributes\Modelable;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Show extends Component
{
    #[Modelable]
    public ?Activity $activity = null;

    public bool $show = false;

    public ?string $new = '{}';
    public ?string $old = '{}';

    public function boot(): void
    {
        if (!$this->activity) {
            $this->show = false;

            return;
        }

        $this->new = json_encode($this->activity->properties['attributes'] ?? [], JSON_THROW_ON_ERROR);
        $this->old = json_encode($this->activity->properties['old'] ?? [], JSON_THROW_ON_ERROR);

        $this->show = true;
    }

    public function render()
    {
        return view('livewire.settings.activity-log.show');
    }
}
