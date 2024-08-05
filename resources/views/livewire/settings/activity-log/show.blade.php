<div>
    <x-modal wire:model="show" title="Activity" class="backdrop-blur" box-class="min-w-[80%] min-h-[80%]" persistent>
        @if($show)
            <x-hr class="mb-5"/>
            <x-diff :old="$old" :new="$new" file-name="{!! $activity->subject_type !!} - {{ $activity->subject_id }}"/>
            <x-slot:actions>
                <x-button label="Cancel" @click="$dispatch('activity-cancel')"/>
            </x-slot:actions>
        @endif
    </x-modal>
</div>
