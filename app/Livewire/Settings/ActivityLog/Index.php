<?php

namespace App\Livewire\Settings\ActivityLog;

use App\Models\User;
use App\Traits\ClearsProperties;
use App\Traits\ResetsPaginationWhenPropsChanges;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Index extends Component
{
    use ClearsProperties;
    use ResetsPaginationWhenPropsChanges;
    use WithPagination;
    #[Url]
    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

    public bool $showFilters = false;

    #[Url]
    public ?string $event = '';

    #[Url]
    public ?string $subject_type = '';

    #[Url]
    public ?string $subject_id = '';

    #[Url]
    public array $causer_id = [];

    #[Url]
    public int $perPage = 10;

    // Selected Brand to edit on modal
    public ?Activity $activity = null;

    #[On('activity-cancel')]
    public function clear(): void
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.settings.activity-log.index', [
            'headers'    => $this->headers(),
            'activities' => $this->activities(),
            'users'      => $this->users(),
            'subjects'   => $this->subjects(),
            'events'     => $this->events(),
            'filterCount' => $this->filterCount(),
        ]);
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => 'Log Id', 'class' => 'hidden lg:table-cell'],
            ['key' => 'event', 'label' => 'Event', 'sortBy' => 'event'],
            ['key' => 'subject_type', 'label' => 'Subject Type', 'sortBy' => 'subject_type'],
            ['key' => 'subject_id', 'label' => 'Subject', 'sortBy' => 'subject_id'],
            ['key' => 'causer', 'label' => 'Causer', 'sortable' => false],
            ['key' => 'created_at', 'label' => 'Created At', 'sortBy' => 'created_at'],
        ];
    }

    public function activities(): LengthAwarePaginator
    {
        return Activity::query()
            ->with(['causer'])
            ->when($this->subject_type, fn(Builder $q) => $q->where('subject_type', $this->subject_type))
            ->when($this->subject_id, fn(Builder $q) => $q->where('subject_id', $this->subject_id))
            ->when($this->event, fn(Builder $q) => $q->where('event', $this->event))
            ->when($this->causer_id, fn(Builder $q) => $q->whereIn('causer_id', $this->causer_id))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    public function users(): Collection
    {
        return User::query()->orderBy('name')->get();
    }

    public function subjects(): Collection
    {
        return Activity::query()->groupBy('subject_type')->pluckWithIdName('subject_type', 'subject_type');
    }

    public function events(): Collection
    {
        return Activity::query()->groupBy('event')->pluckWithIdName('event', 'event');
    }

    public function filterCount(): int
    {
        return ($this->subject_id !== null && $this->subject_id !== '' && $this->subject_id !== '0' ? 1 : 0) + ($this->causer_id !== [] ? 1 : 0) + (strlen((string) $this->event) !== 0 ? 1 : 0) + (strlen((string) $this->subject_type) !== 0 ? 1 : 0);
    }

    public function show(Activity $activity): void
    {
        $this->activity = $activity;
    }
}
