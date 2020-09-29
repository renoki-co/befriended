<?php

namespace Rennokki\Befriended\Traits;

trait HasCustomModelClass
{
    /**
     * Get the model's morph class to act as the main resource.
     *
     * @param  string|null  $model
     * @return string
     */
    protected function getModelMorphClass($model = null)
    {
        return $model
            ? (new $model)->getMorphClass()
            : $this->getCurrentModelMorphClass();
    }

    /**
     * Get the current model's morph class.
     *
     * @return string
     */
    protected function getCurrentModelMorphClass()
    {
        return $this->getMorphClass();
    }
}
