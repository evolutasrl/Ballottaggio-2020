<?php

namespace App\Concerns;

use Laravel\Scout\Builder;

trait TextSearchable
{
    public static function stringSearch($queryText = '', $callback = null)
    {
        $q = app(Builder::class, [
            'model' => new static,
            'query' => $queryText,
            'callback' => $callback,
            'softDelete' => static::usesSoftDelete() && config('scout.soft_delete', false),
        ]);

        return ($queryText == '') ? (new static)::query() : (new static)::whereIn('id', $q->keys());

    }
}
