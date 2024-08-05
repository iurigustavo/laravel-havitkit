<?php

namespace App\View\Components\Button;

use Closure;
use Illuminate\Contracts\View\View as ViewView;
use Illuminate\View\Component;

class Submit extends Component
{

    public function render(): ViewView|Closure|string
    {
        return <<<'HTML'
                    <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit"  {{ $attributes->whereDoesntStartWith('class') }} {{ $attributes->class(['btn-primary hover:scale-105']) }}/>
            HTML;
    }


}
