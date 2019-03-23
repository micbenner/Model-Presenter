<?php

namespace Micbenner\ModelPresenter;

use Illuminate\Database\Eloquent\Model;

class Builder
{
    private $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function add(string $key, $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function addPresenter(Presenter $presenter): self
    {
        $this->attributes = array_merge($this->attributes, $presenter->toArray());

        return $this;
    }

    public function when(bool $condition, string $key, $value): self
    {
        if ($value instanceof \Closure) {
            return $this->whenCall($condition, $key, $value);
        }

        if ($condition) {
            $this->add($key, $value);
        }

        return $this;
    }

    public function whenCall(bool $condition, string $key, callable $value): self
    {
        if ($condition) {
            $this->add($key, $value());
        }

        return $this;
    }

    // todo
    public function whenRelationLoaded(Model $model, $relation, string $presenter = null): self
    {
        $key      = is_array($relation) ? key($relation) : $relation;
        $relation = is_array($relation) ? current($relation) : $relation;

        if ($model->relationLoaded($relation)) {
            $value = $model->getRelation($relation);

            $this->add($key, is_null($presenter) ? $value : new $presenter($value, true));
        }

        return $this;
    }
}