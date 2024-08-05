<?php

namespace App\View\Components\Button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Delete extends Component
{

    public function render(): View|Closure|string
    {
        return <<<'HTML'
                    <x-button icon="o-trash" tooltip="Delete" wire:confirm="Are you sure?" {{ $attributes->whereDoesntStartWith('class') }} spinner {{ $attributes->class(['btn btn-sm btn-circle bg-red-100 hover:bg-red-300 text-red-600 hover:text-red-100']) }}/>
            HTML;
    }


}
