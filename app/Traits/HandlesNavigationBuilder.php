<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HandlesNavigationBuilder
{
    public $mountedItem;

    public $mountedItemData = [];

    public $mountedChildTarget;

    public array $data = [];

    public bool $show = false;

    public function sortNavigation(string $targetStatePath, array $targetItemsStatePaths)
    {
        $items = [];

        foreach ($targetItemsStatePaths as $targetItemStatePath) {
            $item = data_get($this, $targetItemStatePath);
            $uuid = Str::afterLast($targetItemStatePath, '.');

            $items[$uuid] = $item;
        }

        data_set($this, $targetStatePath, $items);
    }

    public function addItem()
    {
        if ($this->mountedItem) {
            data_set($this, $this->mountedItem, array_merge(data_get($this, $this->mountedItem), $this->itemForm->getData()));

            $this->mountedItem = null;
            $this->mountedItemData = [];
        } elseif ($this->mountedChildTarget) {
            $children = data_get($this, $this->mountedChildTarget.'.children', []);

            $children[(string) Str::uuid()] = [
                ...$this->itemForm->getData(),
                ...['children' => []],
            ];

            data_set($this, $this->mountedChildTarget.'.children', $children);

            $this->mountedChildTarget = null;
        } else {
            $this->form->items[(string) Str::uuid()] = [
                ...$this->itemForm->getData(),
                ...['children' => []],
            ];

        }

        $this->itemForm->reset();
        $this->show = false;
    }

    public function addChild(string $statePath)
    {
        $this->mountedChildTarget = $statePath;
        $this->itemForm->reset();
        $this->show = true;
    }

    public function removeItem(string $statePath)
    {
        $uuid = Str::afterLast($statePath, '.');

        $parentPath = Str::beforeLast($statePath, '.');
        $parent = data_get($this, $parentPath);

        data_set($this, $parentPath, Arr::except($parent, $uuid));
    }

    public function editItem(string $statePath)
    {
        $this->mountedItem = $statePath;
        $this->mountedItemData = Arr::except(data_get($this, $statePath), 'children');
        $this->itemForm->fill($this->mountedItemData);
        $this->show = true;
    }

    public function createItem()
    {
        $this->mountedItem = null;
        $this->mountedItemData = [];
        $this->itemForm->reset();
        $this->show = true;
    }
}
