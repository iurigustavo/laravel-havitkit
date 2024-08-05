<?php

namespace App\Core\Concerns;

use Mary\Traits\Toast;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

abstract class Tableable extends PowerGridComponent
{
    use WithExport;
    use Toast;

    public bool $authorize = false;

    public function setUp(): array
    {
        if ($this->authorize) {
            $this->authorize('viewAny', $this->getModel());
        }

        return [
            Exportable::make('export')->striped()->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()->showPerPage()->showRecordCount('full'),
        ];
    }

    abstract public function getModel(): string;

    protected function queryString(): array
    {
        return $this->powerGridQueryString();
    }


}
