<?php

namespace App\View\Components\Button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Edit extends Component
{

    public function render(): View|Closure|string
    {
        return <<<'HTML'
                    <x-button icon="o-pencil" tooltip="Edit" {{ $attributes->whereDoesntStartWith('class') }} spinner {{ $attributes->class(['btn btn-sm btn-circle bg-blue-100 hover:bg-blue-300 text-blue-300 hover:text-blue-100']) }}/>
            HTML;
    }


}
