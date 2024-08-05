<?php

namespace App\Traits;

/**
 * Reset all components properties
 */
trait ClearsProperties
{
    public function clear(): void
    {
        $this->reset();
    }
}
